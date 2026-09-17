<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Item;
use App\Models\Rent;
use App\Models\Order;
use App\Models\Employe;
use App\Models\Customer;
use App\Models\RentItem;
use App\Models\Supplier;
use App\Models\AdminEvent;
use App\Models\DamageItem;
use App\Models\MissingItem;
use Illuminate\Http\Request;
use App\Models\RentItemPackage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RentItemSupplier;
use App\Models\PredefinedPackage;
use App\Models\RentUpdateHistory;
use App\Models\EmployeePermission;
use Illuminate\Support\Facades\DB;
use App\Models\RentItemPackageItem;
use Illuminate\Support\Facades\Validator;

class RentItemController extends Controller
{
    //** FUNCTION TO DISPLAY SEND HISTORY *** */
    function sendhistory(){
        $rentdata = Rent::where('rent_status', '!=', 'Received')->orderByDesc("rent_id")->get();
        // Find rentData Matching the Event Name
        foreach( $rentdata as $rent){
            if ($rent->event_id !== null) {
                $rent->event_name = AdminEvent::find($rent->event_id)->event_name;
            } else {
                $rent->event_name = 'N/A';
            }
        }
        return view('rentitems.senditemhistory', ['rentdata' => $rentdata, 'downloadable' => true]);
    }
    //*** FUNCTION TO DISPLAY SEND ITEM FORM ***//
    function senditemform()
    {
        $items = Item::where('status', 'Available')->get();
        $employees = Employe::where('active', 'Active')->get();
        $customers = Customer::where('status', 'Active')->get();
        $predefined_packages = PredefinedPackage::all();
        $orders = Order::with('order_items')->get();
        $events = AdminEvent::has('orders')->select('eid', 'event_name')->whereIn('status', ['Ongoing', 'pending', 'booking', 'credit'])->orderBy('eid', 'desc')->get();
        $rentItemPackages = RentItemPackage::all();
        $suppliers = Supplier::all();

        if( $employee = Auth::guard('employee')->user()) {
            // Check permission
            $hasPermission = EmployeePermission::where('employee_id', $employee->emp_id)
                ->whereHas('permission', function ($query) {
                    $query->where('name', 'create_rent_item');
                })
                ->exists();
            if (!$hasPermission) {
                return redirect()->back()->with('error', 'You are not permission to create sent rent items');
            }
            return view('rentitems.employeesenditem', ['items' => $items, 'employees' => $employees, 'customers' => $customers, 'predefined_packages' => $predefined_packages, 'orders' => $orders, 'events' => $events, 'rentItemPackages' => $rentItemPackages, 'suppliers' => $suppliers]);
        }
        else{
            return view('rentitems.senditem', ['items' => $items, 'employees' => $employees, 'customers' => $customers, 'predefined_packages' => $predefined_packages, 'orders' => $orders, 'events' => $events, 'rentItemPackages' => $rentItemPackages, 'suppliers' => $suppliers]);
        }
    }


    //*** FUNCTION TO FIND ALL ORDER ITEMS FOR A SPECIFIC ORDER ***//
    function findorderitems($id)
    {
        $orderitems = DB::table('order_item')->where('order_id', $id)->get();
        return $orderitems;
    }

    //*** FUNCTION TO SAVE RENT ITEMS TO THE DATABASE ***//
    function saverentitems(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:255',
            'event_id' => 'nullable|integer|exists:events,eid',
            'rent_package_id' => 'nullable|integer|exists:rent_item_packages,id',
            'order_id' => 'nullable|integer|exists:order,order_id',
            'employee_id' => 'required|integer|min:1',
            'predefined_package_id' => 'nullable|integer|exists:predefined_package,package_id',
            'selected_items' => 'required',
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('selected_items', json_encode($request->input('selected_items', [])));
        }

        DB::beginTransaction();

        try {

            $rent = new Rent();
            $customer = Customer::where('customer_name', $request->customer_name)->first();
            $rent->customer_name = $customer->customer_name;
            $rent->event_id = $request->event_id;
            $rent->order_id = $request->order_id;
            $rent->rent_item_package_id = $request->rent_package_id;
            $rent->customer_id = $customer->customer_id;
            $employee = Employe::where('emp_id', $request->employee_id)->first();
            $rent->employee_name = $employee->name;
            $rent->employee_id = $request->employee_id;
            $rent->save();

            $rent_id = $rent->rent_id;
            $rentitems = json_decode($request->selected_items);

            // Group items by itemId to sum quantities and handle suppliers
              $groupedItems = collect($rentitems)->groupBy('itemId');

            // Check rentitems quantity include item in stock
            foreach ($groupedItems as $itemId => $items) {

                // Calculate the total quantity of items grouped by itemId
                $totalQuantity = collect($items)->sum('quantity');

                // Retrieve the item details from the database
                $item = Item::where('item_id', $itemId)->first();

                // Check if the item is not associated with a supplier
                if ($items->first()->supplierId == null) {

                    // Validate if the item stock is sufficient for the requested quantity
                    if ($item->in_stock < $items->first()->quantity) {
                        // Redirect back with an error if stock is insufficient
                        return redirect()->back()->withErrors(['stock_error' => 'Item: ' . $item->item_name . ' is out of stock. Available stock :' . $item->in_stock])
                            ->withInput()
                            ->with('selected_items', json_encode($request->input('selected_items', [])));
                    }

                    // Decrement in_stock for the item
                    DB::table('item')->where('item_id', $itemId)->decrement('in_stock', $totalQuantity);

                    // Update status to 'Out of Stock' if stock is zero or less
                    if (DB::table('item')->where('item_id', $itemId)->value('in_stock') <= 0) {
                        DB::table('item')->where('item_id', $itemId)->update(['status' => 'Out of Stock']);
                    }

                    // Increment out_stock for the item
                    DB::table('item')->where('item_id', $itemId)->increment('out_stock', $totalQuantity);

                    // Create rent item with total quantity
                    $rentItemModel = new RentItem();
                    $rentItemModel->rent_id = $rent_id;
                    $rentItemModel->item_id = $itemId;
                    $rentItemModel->is_external =  0;
                    $rentItemModel->quantity = $totalQuantity;
                    $rentItemModel->save();
                }else{
                    // Create rent item with total quantity
                    $rentItemModel = new RentItem();
                    $rentItemModel->rent_id = $rent_id;
                    $rentItemModel->item_id = $itemId;
                    $rentItemModel->is_external = 1;
                    $rentItemModel->quantity = $totalQuantity;
                    $rentItemModel->save();

                    foreach ($items as $item) {
                        // Supplier Details
                        $supplier = Supplier::where('id', $item->supplierId)->first();

                        // Create a new RentItemSupplier
                        $rentItemSupplierModel = new RentItemSupplier();
                        $rentItemSupplierModel->rent_item_id = $rentItemModel->rent_item_id;
                        $rentItemSupplierModel->supplier_id = $supplier->id;
                        $rentItemSupplierModel->quantity = $item->quantity;
                        $rentItemSupplierModel->price = $item->supplierPrice;
                        $rentItemSupplierModel->save();
                    }
                }
            }
            DB::commit();
            // Auth gurd check
            if( $employee = Auth::guard('employee')->user()) {
                return redirect()->route('employee.emp.assign.rent')->with('success', 'Rent items saved successfully');
            }
            else{
                 //*** DISPLAY PDF VIEW ***/
                $rent = Rent::where('rent_id', $rent_id)->first();
                $rentitems = RentItem::where('rent_id', $rent_id)->get();

                foreach ($rentitems as $rentitem) {
                    $item = Item::where('item_id', $rentitem->item_id)->first();
                    $rentitem->item_name = $item->item_name;

                    // Get all suppliers for the item
                    $suppliers = RentItemSupplier::where('rent_item_id', $rentitem->rent_item_id)
                        ->join('suppliers', 'rent_item_supplier.supplier_id', '=', 'suppliers.id')
                        ->select('suppliers.*', 'rent_item_supplier.quantity as rent_quantity', 'rent_item_supplier.price as rent_price')
                        ->get();
                    // Assign suppliers to the rent item
                    $rentitem->suppliers = $suppliers;
                }

                return view('PDF.document', ['rent' => $rent, 'rentitems' => $rentitems, 'downloadable' => true]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    //*** FUNCTION TO EDIT SEND ITEMS ***//
    public function editrentitems(Rent $rent)
    {
        $items = Item::where('status', 'Available')->get();
        $employees = Employe::where('active', 'Active')->get();
        $predefined_packages = PredefinedPackage::get();
        $orders = Order::with('order_items')->get();
        $events = AdminEvent::has('orders')->select('eid', 'event_name')->whereIn('status', ['Ongoing', 'pending', 'booking', 'credit'])->orderBy('eid', 'desc')->get();
        $supplierList = Supplier::all();
        // Check selected event in rent table
        if( $rent->event_id == null) {
            // Select order
            $selectOrder = Order::where('order_id', $rent->order_id)->first();
        }
        else{
            // That event invoice order find
            $selectOrder = Order::where('event_id', $rent->event_id)->first();
        }
        $rentItemPackages = RentItemPackage::all();
        // Selected Items
        $rentitems = RentItem::where('rent_id', $rent->rent_id)->get();
        foreach ($rentitems as $rentitem) {
            $item =Item::where('item_id', $rentitem->item_id)->first();
            $rentitem->itemName = $item->item_name;

             // Get all suppliers for the item
             $suppliers = RentItemSupplier::where('rent_item_id', $rentitem->rent_item_id)
             ->join('suppliers', 'rent_item_supplier.supplier_id', '=', 'suppliers.id')
             ->select('suppliers.*', 'rent_item_supplier.quantity as rent_quantity', 'rent_item_supplier.price as rent_price')
             ->get();
             $rentitem->suppliers = $suppliers;
        }

        return view('rentitems.senditemedit', [
            'items' => $items,
            'employees' => $employees,
            'predefined_packages' => $predefined_packages,
            'suppliers' => $supplierList,
            'orders' => $orders,
            'events' => $events,
            'rentItemPackages' => $rentItemPackages,
            'selectOrder' => $selectOrder,
            'rentitems' => $rentitems,
            'rent' => $rent
        ]);
    }

    //*** FUNCTION TO UPDATE SEND ITEMS ***//
    public function updaterentitems(Request $request, Rent $rent)
    {

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:255',
            'event_id' => 'nullable|integer|exists:events,eid',
            'rent_package_id' => 'nullable|integer|exists:rent_item_packages,id',
            'employee_id' => 'required|integer|min:1',
            'order_id' => 'nullable|integer|exists:order,order_id',
            'predefined_package_id' => 'nullable|integer|exists:predefined_package,package_id',
            'selected_items' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('selected_items', json_encode($request->input('selected_items', [])));
        }

        DB::beginTransaction();

        try {
                $customer = Customer::where('customer_name', $request->customer_name)->first();
                $employee = Employe::where('emp_id', $request->employee_id)->first();

                // Update Rent
                $rent->customer_name = $request->customer_name;
                $rent->customer_id = $customer->customer_id;
                $rent->event_id = $request->event_id;
                $rent->order_id = $request->order_id;
                $rent->rent_item_package_id = $request->rent_package_id;
                $rent->employee_id = $request->employee_id;
                $rent->employee_name = $employee->name;
                $rent->save();

                // Get selected items
                $rentitems = json_decode($request->selected_items);
                /*Group the selected items by item_id
                   Each group will have a collection of items with the same item_id
                   The supplierId is added to each item and set to null if not present */
                $groupedItems = collect($rentitems)
                                  ->map(function ($item) {
                                      // Add supplierId to each item and set to null if not present
                                      $item->supplierId = $item->supplierId ?? null;
                                      return $item;
                                  })
                                  ->groupBy('item_id');

                // Delete rent items that do not exist in the $rentitems array
                $existingRentItems = RentItem::where('rent_id', $rent->rent_id)->get();
                // Loop through existing rent items
                foreach ($existingRentItems as $existingRentItem) {
                    $found = false;
                    foreach ($rentitems as $rentitem) {
                        if ($existingRentItem->item_id == $rentitem->item_id) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        // Check if the item is associated with a supplier
                        $isSupplier = RentItemSupplier::where('rent_item_id', $existingRentItem->rent_item_id)->exists();
                        // Check if the rent item has supplier
                        if ($isSupplier) {
                            // Delete the supplier
                            RentItemSupplier::where('rent_item_id', $existingRentItem->rent_item_id)->delete();
                            // Delete the rent item
                            $existingRentItem->delete();
                        }else {
                            // Delete the rent item
                            $existingRentItem->delete();
                            // Update the item stock
                            Item::where('item_id', $existingRentItem->item_id)->increment('in_stock', $existingRentItem->quantity);
                            Item::where('item_id', $existingRentItem->item_id)->decrement('out_stock', $existingRentItem->quantity);
                        }
                    }
                }
                // Loop through selected items
                foreach ($rentitems as $rentitem) {
                    $rentItem = RentItem::where('rent_id', $rent->rent_id)->where('item_id', $rentitem->item_id)->first();
                    // Check if rent item exist
                    if ($rentItem) {
                        // Check rent item is not external
                        if ($rentItem->is_external == 0) {
                            // Check old quantity and new quantity
                            if ($rentItem->quantity > $rentitem->quantity) {
                                // When old quantity is greater than new quantity
                                Item::where('item_id', $rentitem->item_id)->increment('in_stock', $rentItem->quantity - $rentitem->quantity);
                                Item::where('item_id', $rentitem->item_id)->decrement('out_stock', $rentItem->quantity - $rentitem->quantity);
                            } else if ($rentItem->quantity < $rentitem->quantity) {
                                // Get item
                                $item = Item::where('item_id', $rentitem->item_id)->first();
                                // When old quantity is less than new quantity check item stock
                                if ($item->in_stock < $rentitem->quantity - $rentItem->quantity) {
                                    return redirect()->back()->withErrors(['stock_error' => 'Item: ' . $item->item_name . ' is out of stock. Available stock :' . $item->in_stock])->withInput()->with('selected_items', json_encode($request->input('selected_items', [])));
                                }
                                // When old quantity is less than new quantity
                                Item::where('item_id', $rentitem->item_id)->decrement('in_stock', $rentitem->quantity - $rentItem->quantity);
                                Item::where('item_id', $rentitem->item_id)->increment('out_stock', $rentitem->quantity - $rentItem->quantity);
                            }
                            else{
                               // When old quantity is equal to new quantity
                            }
                            // Update quantity
                            $rentItem->quantity = $rentitem->quantity;
                        }
                        else{
                            /* Rent item is external,
                             check suppliers in rent item */
                            $rentItemSuppliers = RentItemSupplier::where('rent_item_id', $rentItem->rent_item_id)->get();
                            $newQuantity = 0;
                            foreach ($rentItemSuppliers as $rentItemSupplier) {
                                // Get all suppliers for the item
                                foreach( $rentitem->suppliers as $supplier){
                                    if( $rentItemSupplier->supplier_id == $supplier->id){
                                        $rentItemSupplier->quantity = $supplier->rent_quantity;
                                        $rentItemSupplier->price = $supplier->rent_price;
                                        $rentItemSupplier->save();
                                        $newQuantity = $newQuantity + $supplier->rent_quantity;
                                    }
                                }
                            }
                            // Update  new quantity in rent item
                            $rentItem->quantity = $newQuantity;
                        }
                        $rentItem->save();
                    } else {
                        // Check item has supplier
                        if( $rentitem->supplierId == null){
                            /*  When item is not supplier newly added rent item */
                            // Check item in stock
                            $item = Item::where('item_id', $rentitem->item_id)->first();
                            if ($item->in_stock < $rentitem->quantity) {
                                return redirect()->back()->withErrors(['stock_error' => 'Item: ' . $item->item_name . ' is out of stock. Available stock :' . $item->in_stock])->withInput()->with('selected_items', json_encode($request->input('selected_items', [])));
                            }
                            // Create new rent item
                            $rentItem = new RentItem();
                            $rentItem->rent_id = $rent->rent_id;
                            $rentItem->item_id = $rentitem->item_id;
                            $rentItem->quantity = $rentitem->quantity;

                            // *** UPDATE ITEM QUANTITY ***//
                            Item::where('item_id', $rentitem->item_id)->decrement('in_stock', $rentitem->quantity);
                            if (Item::where('item_id', $rentitem->item_id)->value('in_stock') <= 0) {
                                Item::where('item_id', $rentitem->item_id)->update(['status' => 'Out of Stock']);
                            }
                            Item::where('item_id', $rentitem->item_id)->increment('out_stock', $rentitem->quantity);
                            $rentItem->save();
                        }
                    }
                }
                /*  Loop through each item id and sum the quantity of the item
                for each item, create a rent item with the total quantity
                 and create rent item suppliers for each supplier of the item  */
                foreach ($groupedItems as $itemId => $items) {
                    // Check if the item is associated with a supplier
                    if( $items->first->supplierId != null){

                        // Calculate the total quantity of items grouped by itemId
                        $totalQuantity = collect($items)->sum('quantity');

                        //  Retrieve the item details from the database
                        $item = Item::where('item_id', $itemId)->first();

                        // Create a new rent item
                        $rentItemModel = new RentItem();
                        $rentItemModel->rent_id = $rent->rent_id;
                        $rentItemModel->item_id = $item->item_id;
                        $rentItemModel->is_external = 1;
                        $rentItemModel->quantity = $totalQuantity;
                        $rentItemModel->save();

                        // Create rent item suppliers for each supplier of the item
                        foreach ($items as $item) {
                            $rentItemSupplier = new RentItemSupplier();
                            $rentItemSupplier->rent_item_id = $rentItemModel->rent_item_id;
                            $rentItemSupplier->supplier_id = $item->supplierId;
                            $rentItemSupplier->quantity = $item->quantity;
                            $rentItemSupplier->price = $item->supplierPrice;
                            $rentItemSupplier->save();
                        }
                    }
                    else{
                        continue;
                    }

                }
                DB::commit();
                return redirect()->route('useradmin.send.history')->with('success', 'Rent items updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update rent items: ' . $e->getMessage());
        }

    }


    //*** FUNCTION TO UPDATE RECEIVED ITEMS ***//
    public function receiveitems(Request $request, $id)
    {
        // Check rent id not exist
        $rentDetails = Rent::where('rent_id', $id)->first();
        // Check rent id not exist
        if (!$rentDetails) {
            return redirect()->back()->with('error', 'Rent not found');
        }

        $validator = Validator::make($request->all(), [
            'received_quantity' => 'required',
            'missing_quantity' => 'required',
            'damaged_quantity' => 'required',
            'note' => 'nullable|string|max:255',
            'damage_note' => 'nullable|string|max:255',
            'received_status' => 'required|in:Good,Damage/Missing,Missing,Damage',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $rent = Rent::find($id);
            $rent->received_status = $request->received_status;
            $rent->rent_status = 'Received';
            $rent->note = $request->note ?? '';
            $rent->save();

            $received_quantity = $request->received_quantity;
            $missing_quantity = $request->missing_quantity;
            $damaged_quantity = $request->damaged_quantity;

            $rentitems = RentItem::where('rent_id', $id)->get();

            $i = 0;
            foreach ($rentitems as $rentitem) {
                // Check rent item is not external
                if( $rentitem->is_external == 0){
                    // *** UPDATE ITEM QUANTITY ***//
                    DB::table('item')->where('item_id', $rentitem->item_id)->increment('in_stock', $received_quantity[$i]);
                    DB::table('item')->where('item_id', $rentitem->item_id)->decrement('out_stock', $received_quantity[$i]);

                    if (DB::table('item')->where('item_id', $rentitem->item_id)->value('in_stock') > 0) {
                        DB::table('item')->where('item_id', $rentitem->item_id)->update(['status' => 'Available']);
                    }
                }

                if ($missing_quantity[$i] > 0) {
                    $missingItems = new MissingItem();
                    $missingItems->item_id = $rentitem->item_id;
                    $missingItems->quantity = $missing_quantity[$i];
                    $missingItems->rent_item_id = $rentitem->rent_item_id;
                    $missingItems->rent_id = $id;
                    $missingItems->save();
                }

                if ($damaged_quantity[$i] > 0) {
                    $damageItems = new DamageItem();
                    $damageItems->rent_id = $id;
                    $damageItems->rent_item_id = $rentitem->rent_item_id;
                    $damageItems->quantity = $damaged_quantity[$i];
                     $damageItems->damage = $request->input('damage_note') ?? '';
                    $damageItems->status = 'Fixing';
                    $damageItems->save();
                    // Update Item Table
                    DB::table('item')->where('item_id', $rentitem->item_id)->decrement('in_stock', $damaged_quantity[$i]);

                }

                $i++;
            }
            DB::commit();

            // Auth gurd check
            if( $employee = Auth::guard('employee')->user()) {
                return redirect()->route('employee.emp.view.received.items')->with('success', 'Rent items received successfully');
            }
            else{

                return redirect()->route('useradmin.rent.view')->with('success', 'Rent items received successfully');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            if( $employee = Auth::guard('employee')->user()) {
                return redirect()->route('employee.emp.view.received.items')->with('error', 'An error occurred: ' . $e->getMessage());
            }
            else{
                return redirect()->route('useradmin.rent.view')->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }
    }


    //*** FUNCTION TO VIEW ALL RENT DATA ***//
    function viewrent()
    {
        //  Rent items
        $rentdata = Rent::where('rent_status', '!=', 'Received')->orderByDesc("rent_id")->get();
        return view('rentitems.renthistory', ['rentdata' => $rentdata], ['downloadable' => true]);
    }

    //*** FUNCTION TO VIEW RENT UPDATE HISTORY *** */
    public function viewrentupdate()
    {
        // Get rent_update_history_data
        $rent_update_history_data = RentUpdateHistory::with('rent', 'employee', 'item')->get();
        // Find rentData Matching the Event Name
        foreach( $rent_update_history_data as $rent_update_history){
            $rent_update_history->event_name = AdminEvent::find($rent_update_history->rent->event_id)->event_name;
        }
        // Group by rent_id
        $rent_update_history_data = $rent_update_history_data->groupBy('rent_id');

        return view('rentitems.rentupdatehistory', ['rent_update_history_data' => $rent_update_history_data]);
    }

    //*** FUNCTION TO VIEW PREVIOUS RECORDS ***/
    function viewpreviousrent()
    {
        $rentdata = DB::table('rent')->where('rent_status', '=', 'Received')->orderByDesc('updated_at')->get();
        //Accept Downloadable
        return view('rentitems.previousrecords', ['rentdata' => $rentdata, 'downloadable' => true]);
    }

    //*** FUNCTION TO VIEW ALL RENT ITEMS FOR A SPECIFIC RENT ***//
    function viewrentitems($id)
    {
        $rent = DB::table('rent')->where('rent_id', $id)->first();
        $rentitems = DB::table('rent_items')->where('rent_id', $id)->get();

        foreach ($rentitems as $rentitem) {
            $item = DB::table('item')->where('item_id', $rentitem->item_id)->first();
            $rentitem->item_name = $item->item_name;
        }
        return view('rentitems.receiveitem', ['rent' => $rent, 'rentitems' => $rentitems]);
    }

    //*** FUNCTION TO VIEW PREVIOUS RENT ITEMS ***/
    function viewpreviousrentitems($id)
    {
        $rent = DB::table('rent')->where('rent_id', $id)->first();
        $rentitems = DB::table('rent_items')->where('rent_id', $id)->get();
        // Get damage_items table to damage
        $damageitems = DB::table('damage_items')->where('rent_id', $id)->get();
        foreach ($rentitems as $rentitem) {
            $item = DB::table('item')->where('item_id', $rentitem->item_id)->first();
            $rentitem->item_name = $item->item_name;
        }


        return view('rentitems.viewprevious', ['rent' => $rent, 'rentitems' => $rentitems, 'damageitems' => $damageitems, 'downloadable' => true]);
    }

    //*** FUNCTION TO DISPLAY ALL MISSING ITEM DATA ***//
    function viewmissingitems()
    {
        $missingdata = DB::table('missing_item')->orderByDesc('missing_id')->get();
        $missingdata = $missingdata->groupBy('rent_id');

        foreach ($missingdata as $missing) {
            $rent = DB::table('rent')->where('rent_id', $missing[0]->rent_id)->first();
            $missing->customer_name = $rent->customer_name;
            $missing->employee_name = $rent->employee_name;
            $missing->sent_date = $rent->created_at;
            $missing->rent_id = $rent->rent_id;
        }
        return view('rentitems.missingitems', ['missingdata' => $missingdata]);
    }

    //*** FUNCTION TO VIEW MISSING ITEMS FOR A SPECIFIC RENT ***//
    function editmissingdetails($id)
    {
        $missingitems = DB::table('missing_item')->where('rent_id', $id)->get();
        $rent = DB::table('rent')->where('rent_id', $id)->first();

        foreach ($missingitems as $missingitem) {
            $item = DB::table('item')->where('item_id', $missingitem->item_id)->first();
            $missingitem->item_name = $item->item_name;
        }

        return view('rentitems.viewmissingitemdata', ['missingitems' => $missingitems, 'rent' => $rent]);
    }

    //*** FUNCTION TO UPDATE MISSING ITEMS DATA ***//
    function updatemissing(Request $request, $id)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'employee_name' => 'required|max:255',
            'received_status' => 'required',
            'missing_quantity' => 'required',
            'note' => 'nullable|max:255',
            'damage_note' => 'nullable|max:255',
        ]);

        // Retrieve the rent details for the given rent ID
        $rentDetails = Rent::where('rent_id', $id)->first();

        // Check rent id not exist
        if (!$rentDetails) {
            return redirect()->back()->with('error', 'Rent not found');
        }

        // Validate the request data and check for errors
        if ($validator->fails()) {
            // If validation fails, redirect back with error messages and input data
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            // Find rent status
            $rentReceivedStatus = Rent::where('rent_id', $id)->value('received_status');

            /* Check if the rent status is already set to 'Damage/Missing'
            If yes, then update the rent table accordingly */
            if ($rentReceivedStatus == 'Damage/Missing') {
                /* Check the value of received_status in the request
                If it is 'Good', then update the rent table to 'Damage'
                And set the note to an empty string  */
                if($request->received_status == 'Good'){
                    // Update the rent table
                    $rent = Rent::where('rent_id', $id)->update([
                        'received_status' => 'Damage',
                        'note' => ''
                    ]);
                }
            }
            else{
                // Update Rent table when missing item received
                Rent::where('rent_id', $id)->update([
                    'received_status' => $request->input('received_status'),
                    'note' => $request->input('note')
                ]);
            }
            // Get all missing items for the given rent ID
            $missingitems = MissingItem::where('rent_id', $id)->get();

            $received_quantity = $request->received_quantity;   //  Get no of received item quantity
            $missing_quantity = $request->missing_quantity;     //  Get no of missing quantity

            $i = 0;
            foreach ($missingitems as $missingitem) {

                // Check missing item is rent_item_id through find its is_external
                $rentItem = RentItem::where('rent_item_id', $missingitem->rent_item_id)->first();
                // Check rent item is not external
                if ($rentItem->is_external == 0) {

                    // *** UPDATE ITEM QUANTITY ***//
                    Item::where('item_id', $missingitem->item_id)->increment('in_stock', $received_quantity[$i]);
                    Item::where('item_id', $missingitem->item_id)->decrement('out_stock', $received_quantity[$i]);
                    if (Item::where('item_id', $missingitem->item_id)->value('in_stock') > 0) {
                        Item::where('item_id', $missingitem->item_id)->update(['status' => 'Available']);
                    }
                }

                if ($missing_quantity[$i] > 0) {
                    $missingitem->quantity = $missing_quantity[$i];
                    MissingItem::where('missing_id', $missingitem->missing_id)->update(['quantity' => $missing_quantity[$i]]);
                    // Update Rent table when missing item received
                    Rent::where('rent_id', $id)->update([
                        'received_status' => $request->input('received_status'),
                        'note' => $request->input('note')
                    ]);

                } else {
                    MissingItem::where('missing_id', $missingitem->missing_id)->delete();

                }
                $i++;
            }
            DB::commit();
            return redirect()->route('useradmin.rent.missing')->with('success', 'Missing items updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update missing items: ' . $e->getMessage());
        }
    }

    //*** EMPLOYEE  */

    //** FUNCTION TO VIEW EMPLOYEE RENT ITEMS PREVIOUS PAGE*/
    public function assignRentItems()
    {
        $emp_id = Auth::guard('employee')->user()->emp_id;
        $rents = Rent::select('rent.*', 'events.event_name')
        ->join('events', 'rent.event_id', '=', 'events.eid')
        ->where('rent.employee_id', $emp_id)
        ->where('rent.rent_status', 'Sent')
        ->orderByDesc('rent.rent_id')
        ->get();

        return view('rentitems.employeepreviousrecords', ['rents' => $rents, 'downloadable' => true]);
    }

    //** FUNCTION TO VIEW EMPLOYEE ASSIGNED RENT ITEMS  VIEWPREVIOUS  PAGE*/
    public function assignRentItemsView(Request $request, $rent_id)
    {
        // Check if the employee is authorized to view the rent
        $emp_id = Auth::guard('employee')->user()->emp_id;
        // Check view rent items permission
        $hasviewrentitemsPermission =  EmployeePermission::where('employee_id', $emp_id)
        ->whereHas('permission', function ($query) {
            $query->where('name', 'view_rent_items');
        })
        ->exists();
        // Check if the employee has permission to view rent items
        if (!$hasviewrentitemsPermission) {
            return redirect()->back()->with('error', 'You are not authorized to view this rent');
        }
        // Get Rent Details
        $rents = Rent::where('rent_id', $rent_id)->get();

        if( !$rents ) {
            return redirect()->back()->with('error', 'Rent not found');
        }

        // Get All Available Items
        $items = Item::where('status', 'Available')->get();

        foreach ($rents as $id => $rent) {
            //get rent items and rent names
            $rents[$id]->rent_items = RentItem::
                join('item', 'rent_items.item_id', '=', 'item.item_id')->where('rent_id', $rent->rent_id)->get();
            $rents[$id]->customer_name = Customer::where('customer_id', $rent->customer_id)->value('customer_name');
            //get employee name
            $rents[$id]->employee_name = Employe::where('emp_id', $rent->employee_id)->value('name');
            // Get event name
            $rents[$id]->event_name = AdminEvent::where('eid', $rent->event_id)->value('event_name');
            // Event setup date
            $rents[$id]->setup_time = AdminEvent::where('eid', $rent->event_id)->value('setup_time');

        }
        return view('rentitems.employeeviewprevious', ['rents' => $rents, 'items' => $items]);
    }

    public function assignRentItemsUpdate(Request $request, $rent_id)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|integer|exists:employes,emp_id',
            'employee_name' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'rent_date' => 'required|date_format:Y-m-d H:i:s',
            'oldRentItems' => 'required|json',
            'newRentItems' => 'required|json',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {

            $oldRentItems = json_decode($request->input('oldRentItems'), true);
            $newRentItems = json_decode($request->input('newRentItems'), true);
            $updatedBy = $request->input('employee_id');

            // Get rent_items for the given rent_id
            $rentItemsFromDB = RentItem::where('rent_id', $rent_id)->get();

            // Check new rent item quantity include item in stock
            foreach ($newRentItems as $rentitem) {
                $item = Item::where('item_id', $rentitem['itemId'])->first();
                if ($item->in_stock < $rentitem['quantity']) {
                    return redirect()->back()->withErrors(['stock_error' => 'Item: ' . $item->item_name . ' is out of stock. Available stock :' . $item->in_stock])->withInput()->with('selected_items', json_encode($request->input('selected_items', [])));
                }
            }

            // Delete rent items that are not in the oldRentItems array
            foreach ($rentItemsFromDB as $rentItem) {
                if (!in_array($rentItem->rent_item_id, array_column($oldRentItems, 'rent_item_id'))) {
                    // Record the deletion in history
                    RentUpdateHistory::create([
                        'rent_id' => $rent_id,
                        'item_id' => $rentItem->item_id,
                        'previous_quantity' => $rentItem->quantity,
                        'current_quantity' => 0,
                        'updated_quantity' => $rentItem->quantity,
                        'action' => 'remove',
                        'employee_id' => $updatedBy,
                    ]);
                    $rentItem->delete();
                }
            }

            // Handle old rent items (updated or deleted) )
            foreach ($oldRentItems as $oldItem) {
                $rentItem = RentItem::where('rent_id', $rent_id)->where('rent_item_id', $oldItem['rent_item_id'])->first();

                if ($rentItem) {
                    // Check if the quantity has changed
                    if ($rentItem->quantity != $oldItem['quantity']) {
                        // Record the change in history
                        RentUpdateHistory::create([
                            'rent_id' => $rent_id,
                            'item_id' => $oldItem['itemId'],
                            'previous_quantity' => $rentItem->quantity,
                            'current_quantity' => $oldItem['quantity'],
                            'updated_quantity' => $oldItem['quantity'] - $rentItem->quantity,
                            'action' => 'update',
                            'employee_id' => $updatedBy,
                        ]);
                    }

                    // Update the quantity
                    $rentItem->quantity = $oldItem['quantity'];
                    $rentItem->save();
                }

            }

            // Handle new rent items (added)
            foreach ($newRentItems as $newItem) {
                // Record the addition in history
                RentUpdateHistory::create([
                    'rent_id' => $rent_id,
                    'item_id' => $newItem['itemId'],
                    'previous_quantity' => 0,
                    'current_quantity' => $newItem['quantity'],
                    'updated_quantity' => $newItem['quantity'],
                    'action' => 'add',
                    'employee_id' => $updatedBy,
                ]);

                // Add new rent item
                RentItem::create([
                    'rent_id' => $rent_id,
                    'item_id' => $newItem['itemId'],
                    'quantity' => $newItem['quantity'],
                ]);
            }

            DB::commit();
            return redirect()->route('employee.emp.assign.rent')->with('success', 'Rent items updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update rent items: ' . $e->getMessage());
        }
    }


    public function checkAvailability($itemId)
    {
        $item = DB::table('item')->where('item_id', $itemId)->first();

        if ($item) {
            // Return the in_stock status
            return response()->json(['in_stock' => $item->in_stock]);
        } else {
            // If the item doesn't exist, assume out of stock
            return response()->json(['in_stock' => false]);
        }
    }

    public function checkTotalQuantityAvailability($itemId) {
        $item = Item::where('item_id', '=', $itemId)->first();
        if ( $item ) {
            // Return the total_stock status
            return response()->json(['totalStock' => $item->total_stock]);
        } else {
            // If the item doesn't exist, assume out of stock
            return response()->json(['totalStock' => false]);
        }
    }

    // Get Rent Item Packages and Orders for a specific event
    public function getRentItemPackagesAndOrders($eventId) {

        $rent_item_packages = RentItemPackage::where('event_id', $eventId)->get();
        $orders = Order::where('event_id', $eventId)->get();
        $customerId = AdminEvent::where('eid', $eventId)->value('customer_id');
        $customerName = Customer::where('customer_id', $customerId)->value('customer_name');
        return response()->json(['rent_item_packages' => $rent_item_packages, 'orders' => $orders, 'customerName' => $customerName]);
    }
    // Get Rent Item Packages Items for a Rent Item Package
    public function getRentItemPackageItems($id) {
        $rent_item_package_items = RentItemPackageItem::where('rent_item_package_id', $id)->get();
        // Assign event_name
        foreach ($rent_item_package_items as $rent_item_package_item) {
            $rent_item_package_item->item_name = Item::where('item_id', $rent_item_package_item->item_id)->value('item_name');
        }
        return response()->json(['rent_item_package_items' => $rent_item_package_items]);
    }

    /**
     * View received items
     *
     * @return \Illuminate\Http\Response
     */
    Public function viewReceivedItems() {

        $rentdetails = Rent::where('rent_status', '!=', 'Received')->where('employee_id', Auth::guard('employee')->user()->emp_id)->orderByDesc("rent_id")->get();
        return view('rentitems.employeerenthistory', ['rentdetails' => $rentdetails], ['downloadable' => true]);
    }

    /**
     * View received items details
     *
     * @param int $id rent id
     * @return \Illuminate\Http\Response
     */
    public function viewReceivedItemsDetails($id) {
        // Check authorization
        $employee = Auth::guard('employee')->user();
        $hasPermission = EmployeePermission::where('employee_id', $employee->emp_id)
            ->whereHas('permission', function ($query) {
                $query->where('name', 'receive_rent_item');
            })
            ->exists();
        if (!$hasPermission) {
            return redirect()->back()->with('error', 'You are not access to view received items');
        }
        $rent = Rent::where('rent_id', $id)->first();
        $rentitems = RentItem::where('rent_id', $id)->get();

        foreach ($rentitems as $rentitem) {
            $item =Item::where('item_id', $rentitem->item_id)->first();
            $rentitem->item_name = $item->item_name;
        }
        return view('rentitems.employeereceiveitem', ['rent' => $rent, 'rentitems' => $rentitems]);
    }

}
