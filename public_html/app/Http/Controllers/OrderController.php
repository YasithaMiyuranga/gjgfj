<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rent;
use App\Models\Agent;
use App\Models\Order;
use App\Models\Employe;
use App\Models\CashFlow;
use App\Models\Customer;
use App\Models\RentItem;
use App\Models\EventDate;
use App\Models\JobAmount;
use App\Models\OrderBook;
use App\Models\OrderItem;
use App\Models\AdminEvent;
use App\Models\BankAccount;
use App\Models\CreditOrder;
use App\Models\Payment_log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\RentItemPackage;
use App\Models\AdditionalExpense;
use App\Models\PredefinedPackage;
use App\Models\TermsAndConditions;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\CashFlowHelper;
use App\Models\OrderTermsCondition;
use App\Models\RentItemPackageItem;
use App\Http\Controllers\Controller;
use App\Models\PredefinedPackageItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;


class OrderController extends Controller
{
    /**
     * Display a form to create a new order
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retrieve active employees
        $employees = Employe::where('active', 'Active')->get();

        // Retrieve active customers
        $customers = Customer::Where('status', 'Active')->get();

        // Retrieve view items
        $viewitems = Item::select('item_id', 'item_name', 'rent_price', 'category')->get();

        // Retrieve events
        $events = AdminEvent::select('eid', 'event_name')
            ->whereIn('status', ['Ongoing', 'pending', 'booking', 'credit'])
            ->orderBy('eid', 'desc')
            ->get();

        // Retrieve predefined packages
        $predefined_packages = PredefinedPackage::where('package_status', 'Active')->get();

        // Retrieve terms and conditions
        $terms = TermsAndConditions::all();

        // Retrieve all bank accounts
        $bankAccounts = BankAccount::all();

        $selectedEventId = '';

        return view('order.createorder', compact(
            'customers',
            'viewitems',
            'employees',
            'predefined_packages',
            'events',
            'terms',
            'bankAccounts',
            'selectedEventId'
        ));
    }
    /**
     * Create an order by event
     *
     * @param int $eid Event ID
     * @return \Illuminate\View\View
     */
    public function orderCreateByEvent($eid)
    {
        $selectedEventId = $eid;

        // Check if the event ID is valid
        if (!AdminEvent::where('eid', $eid)->exists()) {
            return redirect()->back()->with('error', 'Invalid event ID');
        }

        // Retrieve active employees
        $employees = Employe::where('active', 'Active')->get();

        // Retrieve active customers
        $customers = Customer::Where('status', 'Active')->get();

        // Retrieve view items
        $viewitems = Item::select('item_id', 'item_name', 'rent_price', 'category')->get();

        // Retrieve events
        $events = AdminEvent::whereIn('status', ['Ongoing', 'pending', 'booking', 'credit'])
            ->orderBy('eid', 'desc')
            ->get();

        // Retrieve predefined packages
        $predefined_packages = PredefinedPackage::where('package_status', 'Active')->get();

        // Retrieve terms and conditions
        $terms = TermsAndConditions::all();

        // Retrieve bank accounts
        $bankAccounts = BankAccount::all();

        return view('order.createorder', compact(
            'customers',
            'viewitems',
            'employees',
            'predefined_packages',
            'events',
            'terms',
            'bankAccounts',
            'selectedEventId'
        ));
    }
    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'name' => 'nullable|array|min:1',
            'name.*' => 'nullable|string',
            'order_type' => 'required|string|max:50',
            'booking_date' => 'required|date',
            // 'event_name'  => 'required|string',
            'event_id'  => 'required|exists:events,eid',
            'Bank_account' => 'nullable|exists:bank_accounts,id',
            'location'  => 'required|string|max:255',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'customer_name' => 'nullable|string|max:255',
            'customer_id' => 'nullable|exists:customer,customer_id',
            'customer_phone' => 'nullable|string',
            'is_pay' => 'boolean',
            'inv_date' => 'nullable|date',
            'order_status' => 'nullable|string|in:completed,booking,credit order,pending,canceled,pending payment,completed payment',
            'total_discount' => 'nullable|numeric',
            'additional_price' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'transport' => 'nullable|numeric',
            'total_balance' => 'nullable|numeric',
            'payment_amount' => 'nullable|numeric',
            'pay_amount' => 'nullable|numeric',
            'final_amount' => 'nullable|numeric',
            'special_note' => 'nullable|string',
            'terms_conditions' => 'nullable|string|max:255',

        ]);

        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        $validatedData = $validatedData->validated();

        // get event name from eid
        $eventName = AdminEvent::where('eid', $validatedData['event_id'])->pluck('event_name')->first();
        // set event name in order
        $validatedData['event_name'] = ucfirst($eventName);

        if (($request->input('confirmWithItemPrice'))) {
            //confirm with item price
            $confirmWithItemPrice = $request->input('confirmWithItemPrice');
        } else {
            $confirmWithItemPrice = 'off';
        }

        // Assign the validated customer_id, customer_name
        $customerId =   $validatedData['customer_id'];
        $customerName = $validatedData['customer_name'];

        //starting the transaction
        DB::beginTransaction();

        // Process your form submission
        try {
            if (isset($validatedData['name'])) {
                $employeeNames = implode(',', $validatedData['name']);
            } else {
                $employeeNames = ''; // Provide a default value if 'name' key is not present

            }

            $selectedItems = json_decode($request->input('selected_items'), true);
            // Get the rentPackage
            $rentPackageDetails = json_decode($request->input('rent_package'), true);
            // Get predefined package
            $predefinedPackageDetails = json_decode($request->input('predefinedPackage'), true);

            if ($selectedItems === null || empty($selectedItems)) {
                return redirect()->back()->with('error', 'Selected items data is null or empty.');
            }

            // If rentPackage is not null
            if($rentPackageDetails != null){
                foreach ($rentPackageDetails as  $rentPackage) {

                    $rentItemPackage = RentItemPackage::create([
                        'event_id' => $validatedData['event_id'],
                        'name' => $rentPackage['package_name'],
                    ]);
                    foreach ($selectedItems as $item) {
                        $RentItemPackageItem = RentItemPackageItem::create([
                            'rent_item_package_id' => $rentItemPackage->id,
                            'item_id' => $item['itemId'],
                            'quantity' => $item['quantity'],
                        ]);
                   }
                }
            }

            $totalPrice = 0;
            // $totalDiscount = 0;

            foreach ($selectedItems as $item) {
                $totalPrice += $item['quantity'] * $item['rent_price'] - $item['discount'];
                // $totalDiscount += $item['discount'];
            }

            //Net Amount
            $netAmount = $totalPrice; // Items discount already added to total price
            $grandTotal = $netAmount + $validatedData['tax'] + $validatedData['transport']-$validatedData['total_discount'];


            if ($request->input('pay_amount') != null && $request->input('pay_amount') != 0.00) {
                if ($request->input('additional_price') != null  && $request->input('additional_price') != 0.00) {
                    $finalAmount = $validatedData['additional_price'] - $request->input('pay_amount');
                } else {
                    $finalAmount = $grandTotal - $request->input('pay_amount');
                }
            } else {
                if ($request->input('additional_price') != null  && $request->input('additional_price') != 0.00) {
                    $finalAmount = $validatedData['additional_price'];
                } else {
                    $finalAmount = $grandTotal;
                }
            }

            $order = Order::create([
                'customer_name' => $customerName,
                'name' => $employeeNames,
                'order_type' => $validatedData['order_type'],
                'booking_date' => $validatedData['booking_date'],
                'event_name'  => $validatedData['event_name'],
                'event_id' => $validatedData['event_id'],
                'bank_id' => $validatedData['Bank_account'] ?? BankAccount::getDefaultBankAccountId(),
                'location' => $validatedData['location'],
                'start_time' => $validatedData['start_time'],
                'end_time' => $validatedData['end_time'],
                'customer_phone' => $validatedData['customer_phone'],
                'inv_date' => $validatedData['inv_date'],
                'order_status' => $validatedData['order_status'],
                'net_amount' => $netAmount,
                'total_discount' => $validatedData['total_discount'],
                'pay_amount' => $request->input('pay_amount', 0.00),
                'grand_total' => $grandTotal,
                'final_amount' => $finalAmount,
                'tax' => $validatedData['tax'],
                'transport' => $validatedData['transport'],
                'additional_price' => $validatedData['additional_price'],

            ]);

            if ($order) {
                if ($order['order_type'] == "invoice") {
                    $invoice = new Invoice();
                    $invoice->order_id = $order->order_id;
                    $invoice->save();

                    $invoiceNo = $invoice->id;
                }
                // If predefinedPackage is not null
                if($predefinedPackageDetails != null){
                    foreach ($predefinedPackageDetails as  $predefinedPackage) {
                        // Find or create the predefined package
                        $PredefinedPackage = PredefinedPackage::firstOrCreate([
                            'package_name' => $predefinedPackage['package_name'],
                            'category' => $predefinedPackage['category'],
                            'package_status' => $predefinedPackage['package_status'],
                            'order_id' => $order->order_id
                        ]);

                        // Associate the selected items with the predefined package
                        foreach ($selectedItems as $item) {
                            $PredefinedPackageItem = PredefinedPackageItem::firstOrCreate([
                                'predefined_package_id' => $PredefinedPackage->package_id,
                                'item_id' => $item['itemId'],
                                'quantity' => $item['quantity'],
                                'item_name' => $item['itemName'],
                                'item_price' => $item['rent_price'],
                            ]);
                        }
                    }
                }
                // Check order status completed
                if($order->order_status == 'completed'){
                    $completeorderAmount =  $order->final_amount;

                        // Get  the current pay_amount
                        $payAmount = $order->pay_amount;
                        // update Order table
                        $order->pay_amount = $completeorderAmount + $payAmount;
                        $order->final_amount = 0.00;
                        $order->order_status = 'completed';
                        $order->save();

                        // Store the record in the payment_log table
                        $paymentLog = new Payment_log();
                        $paymentLog->credit_order_id = null;
                        $paymentLog->order_id = $order->order_id;
                        $paymentLog->paid_date = date('Y-m-d');
                        $paymentLog->paid_amount = $completeorderAmount;

                        if ($completeorderAmount > 0) {
                            // Get the current date
                            $date = Carbon::now()->format('Y-m-d');
                            // Create a new CashFlow entry using the helper
                            $is_cashflow_saved = CashFlowHelper::create(
                                $name = ' Order_Id: ' . $order->order_id . ' Order ' . $order->customer_name . ' ' . $order->start_time . ' to ' . $order->end_time,
                                $amount = $completeorderAmount,
                                $date = $date,
                                $ref_id = $order->order_id,
                                $ref_name = Order::getTableName(),
                                $incomeOrExpense = 'INCOME'
                            );
                        }
                        $paymentLog->save();
                }
            }

            // Update Event Status
            $event = AdminEvent::where('eid', $validatedData['event_id'])->first();
            if ($event) {
                 if(  $order->order_status == 'credit order'){
                     $event->status = 'credit';
                     $event->save();
                 }
                 else{
                     $event->status = $order->order_status;
                     $event->save();
                 }
            }
            if ($order->pay_amount > 0) {
                $date = Carbon::now()->format('Y-m-d');
                // Create a new CashFlow entry using the helper
                $is_cashflow_saved = CashFlowHelper::create(
                    $name =  ' Order_Id: ' . $order->order_id . ' Order ' . $order->customer_name . ' ' . $order->start_time . ' to ' . $order->end_time,
                    $amount = $order->pay_amount,
                    $date = $date,
                    $ref_id = $order->order_id,
                    $ref_name = Order::getTableName(),
                    $incomeOrExpense = 'INCOME'
                );
            }

            // Store terms and conditions
            if ($request->has('terms_and_conditions')) {
                $termsData = $request->input('terms_and_conditions');

                if (!empty($termsData['term_id']) && !empty($termsData['description'])) {
                    OrderTermsCondition::create([
                        'order_id' => $order->order_id,
                        'terms_and_conditions_id' => $termsData['term_id'],
                        'terms_description' => $termsData['description'],
                    ]);
                }
            }

            //if order type invoice only
            if ($request->input('order_type') == 'invoice') {
                //order_status is create order store that data in create order table
                if ($order && $order->order_status == 'credit order') {
                    //create credit order
                    $creditOrder = CreditOrder::create([
                        'order_id' => $order->order_id,
                        'customer_id' => $customerId,
                        'customer_name' => $customerName,
                        'total_amount' => $order->final_amount,
                        'credit_amount' => $order->final_amount, //credit amount is same as final amount
                        'booking_date' => $order->booking_date,
                    ]);
                }
            }

            if ($order) {
                $order_id = $order->order_id;

                foreach ($selectedItems as $orderitem) {
                    $orderItemModel = new OrderItem();
                    $orderItemModel->order_id = $order_id;
                    $orderItemModel->item_id = $orderitem['itemId'];
                    $orderItemModel->item_name = $orderitem['itemName'];
                    $orderItemModel->description = $orderitem['description'];
                    $orderItemModel->rent_price = $orderitem['rent_price'];
                    $orderItemModel->discount = $orderitem['discount'];
                    $orderItemModel->quantity = $orderitem['quantity'];
                    $orderItemModel->save();


                    $orderBook = new OrderBook();
                    $orderBook->customer_name = $customerName;
                    $orderBook->booking_date = $validatedData['booking_date'];
                    $orderBook->order_status = $validatedData['order_status'];
                    $orderBook->order_id = $order_id;
                    $orderBook->name = $employeeNames;
                    $orderBook->pay_amount = $request->input('pay_amount', 0.00);
                    $orderBook->is_pay = $request->input('is_pay', 0);
                    $orderBook->event_name = $validatedData['event_name'];
                    $orderBook->location = $validatedData['location'];
                    $orderBook->start_time = $validatedData['start_time'];
                    $orderBook->end_time = $validatedData['end_time'];
                    $orderBook->customer_phone = $validatedData['customer_phone'];
                    $orderBook->item_name = $orderitem['itemName'];
                    $orderBook->total_balance = 0.00;
                    $orderBook->payment_amount = 0.00;



                    if (isset($validatedData['is_pay']) && $validatedData['pay_amount']) {
                        $orderBook->is_pay = true;
                        $orderBook->pay_amount = $request->input('pay_amount') ?? 0;
                    } else {
                        $orderBook->is_pay = false;
                        $orderBook->pay_amount = 0;
                    }


                    $orderBook->save();
                }


                $orderItems = OrderItem::where('order_id', $order_id)->get();

                $totalDiscount = $orderItems->sum('discount')+$validatedData['total_discount'];


                $netAmount = $orderItems->sum(function ($item) {
                    return ($item->quantity * $item->rent_price-$item->discount);
                });


                foreach ($orderItems as $ordertitem) {
                    //get  first matching record item_id in  item table
                    $item = DB::table('item')->where('item_id', $ordertitem->item_id)->first();
                    //asssign to item_category
                    $ordertitem->item_category = $item->category;
                }
                //Group by category
                $orderItems = $orderItems->groupBy('item_category');

                // Get whether the checkbox was ticked
                $confirmWithItemPrice = $request->input('confirmWithItemPrice');

                // Find the terms and conditions for the order
                $termsAndConditions = OrderTermsCondition::where('order_id', $order_id)->first();
                $termsDescription = $termsAndConditions ? $termsAndConditions->terms_description : '';

                // Check if the terms and conditions exist
                if ($termsAndConditions) {
                    $description = $termsAndConditions->description;
                } else {
                    $description = 'No description available';
                }

                //**TODO  THIS  USE FOR TEMPERARY */
                $grandTotalCorrect = null;
                if ($order['additional_price'] > 0) {
                    // this is the correct grand total
                    $grandTotalCorrect = $order['additional_price'];
                } else {
                    $grandTotalCorrect = ($order['final_amount'] == 0) ? $order['pay_amount'] : $order['grand_total'];
                }

                //  Update special note
                $special_note = $request->input('special_note');
                $order->special_note = $special_note;
                $order->save();

                // Check if a bank ID was provided
                if ($order->bank_id) {
                    $bankDetails = BankAccount::where('id', $order->bank_id)->first();
                }
                else{
                    // Find default bank details
                    $bankDetails = BankAccount::where('is_default', true)->first();
                }
                // Check order has event_id
                if ($order->event_id) {
                    // Get event Multiple Dates
                    $eventDates = EventDate::where('event_id', $order->event_id)->get();
                }

                //commits the changes
                DB::commit();
                if ($validatedData['order_type'] === 'quotation') {

                    return view('order.quotation', [
                        'order' => $order,
                        'orderItems' => $orderItems,
                        'totalDiscount' => $totalDiscount,
                        'netAmount' => $netAmount,
                        'grandTotal' => $grandTotal,
                        'customerName' => $customerName,
                        'additionalPrice' => $validatedData['additional_price'],
                        'tax' => $validatedData['tax'],
                        'transport' => $validatedData['transport'],
                        'customerPhone' => $validatedData['customer_phone'],
                        'Location' => $validatedData['location'],
                        'payAmount' => $request->input('pay_amount', 0.00),
                        'startTime' => $validatedData['start_time'],
                        'endTime' => $validatedData['end_time'],
                        'finalAmount' => $finalAmount,
                        'confirmWithItemPrice' => $confirmWithItemPrice,
                        'grandTotalCorrect' => $grandTotalCorrect,
                        'description' => $description,
                        'special_note' => $special_note,
                        'terms_description' => $termsDescription,
                        'bank_details' => $bankDetails,
                        'eventDates' => $eventDates ?? null

                    ])->with('success', 'Quotation Created Successfully!');
                } elseif ($validatedData['order_type'] === 'invoice') {

                    return view('order.invoice', [
                        'order' => $order,
                        'invoice' => $invoiceNo,
                        'orderItems' => $orderItems,
                        'totalDiscount' => $totalDiscount,
                        'netAmount' => $netAmount,
                        'grandTotal' => $grandTotal,
                        'customerName' => $customerName,
                        'additionalPrice' => $validatedData['additional_price'],
                        'tax' => $validatedData['tax'],
                        'transport' => $validatedData['transport'],
                        'customerPhone' => $validatedData['customer_phone'],
                        'Location' => $validatedData['location'],
                        'payAmount' => $request->input('pay_amount', 0.00),
                        'startTime' => $validatedData['start_time'],
                        'endTime' => $validatedData['end_time'],
                        'finalAmount' => $finalAmount,
                        'confirmWithItemPrice' => $confirmWithItemPrice,
                        'grandTotalCorrect' => $grandTotalCorrect,
                        'description' => $description,
                        'special_note' => $special_note,
                        'terms_description' => $termsDescription,
                        'bank_details' => $bankDetails,
                        'eventDates' => $eventDates ?? null

                    ])->with('success', 'Order Placed Successfully!');

                } else {

                    return redirect()->route('useradmin.order.create')->with('success', 'Order Placed Successfully!');
                }
            }
        } catch (\Exception $e) {
            // <= Rollback in case of an exception
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the order: ' . $e->getMessage());
        }
    }

    //*** Function To Display All Orders ***/
    public function orderview()
    {
        $data = DB::table('order')->orderByDesc('order_id')->get();
        return view('order.orderitem', ['data' => $data, 'title' => 'Order History']);
    }

    //** FUNCTION TO  DISPLAY ALL INVOICE ORDERS */
    public function invoice()
    {
        $data = DB::table('order')->where('order_type', 'invoice')->orderByDesc('order_id')->get();
        return view('order.orderitem', ['data' => $data, 'title' => 'Order Invoice']);
    }

    //** FUNCTION TO  DISPLAY ALL QUOTATION ORDERS */
    public function Quotation()
    {
        $data = DB::table('order')->where('order_type', 'quotation')->orderByDesc('order_id')->get();
        return view('order.orderitem', ['data' => $data, 'title' => 'Order Quotation']);
    }


    //*** Function TO Display For A  Specific Order*/
    function editvieworderitems($id)
    {
        $order = Order::with('event', 'event.customer')->find($id);
        // RentItemPackage
        $rentPackage = RentItemPackage::where('event_id', $order->event_id)->first();
        // Get predefinedPackages
        $predefinedPackage = PredefinedPackage::where('order_id', $id)->first();
        // Get order items
        $orderitems = OrderItem::where('order_id', $id)->get();
        // Get order items with item category
        foreach ($orderitems as $orderItem) {
            $item = Item::find($orderItem->item_id);
            $orderItem->category = $item->category;
        }
        // Find Terms and Conditions for the order
        $terms = TermsAndConditions::all();
        // Get terms and conditions for the order
        $orderTermsCondition = OrderTermsCondition::where('order_id', $id)->first();

        $items = Item::all();
        $events = AdminEvent::all();
        $employees = Employe::where('active', 'Active')->get();

        //  Get all bank accounts
        $bankAccounts = BankAccount::all();

        //  Get customerid from customer table
        $customer = Customer::where('customer_phone', $order->customer_phone)->first();

        return view('order.itemview', ['order' => $order, 'orderitems' => $orderitems, 'items' => $items, 'employees' => $employees, 'customer' => $customer, 'events' => $events, 'terms' => $terms, 'orderTermsCondition' => $orderTermsCondition, 'bankAccounts' => $bankAccounts , 'rentPackage' => $rentPackage, 'predefinedPackage' => $predefinedPackage]);

    }

    //*** Function to update orders ***/
    public function update(Request $request, Order $order)
    {
        // Validate the incoming request data
        $validatedData = Validator::make($request->all(), [
            'order_type' => 'required|in:quotation,invoice',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string',
            'customer_id' => 'nullable',
            'location' => 'required|string|max:255',
            'event_id'  => 'required|exists:events,eid',
            'Bank_account' => 'nullable|exists:bank_accounts,id',
            'start_time' => 'nullable|date|after_or_equal:booking_date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'booking_date' => 'required|date_format:Y-m-d',
            'inv_date' => 'required|date_format:Y-m-d',
            'order_status' => 'required|in:completed,booking,credit order,pending,canceled,pending payment,completed payment',
            'order_book' => 'nullable|boolean',
            'is_pay' => 'nullable|boolean',
            'transport' => 'nullable|numeric',
            'additional_price' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'advance_amount' => 'nullable|numeric',
            'total_discount' => 'nullable|numeric',
            'net_amount' => 'nullable|numeric',
            'grand_total' => 'nullable|numeric',
            'final_amount' => 'nullable|numeric',
            'name' => 'nullable|array|min:1',
            'name.*' => 'nullable|string',
            'item_name' => 'nullable|string',
            'oldOrderedItems' => 'nullable|string',
            'oldOrderedItems.*' => 'nullable|string',
            'newOrderedItems' => 'nullable|string',
            'newOrderedItems.*' => 'nullable|string',
            'special_note' => 'nullable|string',
            'terms_conditions' => 'nullable|string|max:255',
        ]);

        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        $validatedData = $validatedData->validated();
        $validatedData['pay_amount'] = (isset($request->pay_amount)) ? $request->pay_amount : 0;

        // Get event name from eid
        $eventName = AdminEvent::where('eid', $validatedData['event_id'])->pluck('event_name')->first();
        // Set event name in order
        $validatedData['event_name'] = ucfirst($eventName);

        DB::beginTransaction();

    try {
        // Old items
        $oldOrderedItems = json_decode($request->input('oldOrderedItems'), true);
        // New  items
        $newOrderedItems = json_decode($request->input('newOrderedItems'), true);
        // Get old items id array
        $oldOrderItemIds = array_column($oldOrderedItems, 'oderItemId');
        // Get old orderItems item_ids array
        $oldItemIds = OrderItem::whereIn('id', $oldOrderItemIds)->pluck('item_id')->toArray();
        // Get order items related to order id
        $orderItemsFromDB = OrderItem::where('order_id', $order->order_id)->get();
        // Created RentPackage details
        $rentCreatePackage = json_decode($request->input('rentPackageList'), true);
        // Created PredefinedPackage details
        $predefinedCreatePackage = json_decode($request->input('predefinedPackageList'), true);

        // If rentPackage is not null
        if($rentCreatePackage != null){
            foreach ($rentCreatePackage as  $rentPackage) {
                // If check existing  rent package
                if( $rentPackage['package_id'] != null || $rentPackage['package_id'] != ''){
                    // Get rent package items
                    $rentPackageItems = RentItemPackageItem::where('rent_item_package_id', $rentPackage['package_id'])->get();

                    // Iterate over each item in the rent package
                    foreach ($rentPackageItems as $item) {
                        // Check if the item is not present in the old item IDs
                        if (!in_array($item->item_id, $oldItemIds)) {
                            // Delete the item if it is not in the old item IDs
                            $item->delete();
                        }
                    }

                    // Update rent package
                    RentItemPackage::where('id', $rentPackage['package_id'])->update([
                        'event_id' => $validatedData['event_id'],
                        'name' => $rentPackage['package_name'],
                    ]);

                    // Update rent package items
                    foreach ($oldOrderedItems as $oldItem) {
                        $itemId = OrderItem::where('id', $oldItem['oderItemId'])->pluck('item_id')->first();
                        foreach ($rentPackageItems as $packageItem) {
                            if($packageItem->item_id == $itemId){
                                $packageItem->update([
                                    'quantity' => $oldItem['quantity'],
                                ]);
                            }
                        }
                    }
                    // Create rent package items for new order items
                    foreach ($newOrderedItems as $newItem) {
                        RentItemPackageItem::create([
                            'rent_item_package_id' => $rentPackage['package_id'],
                            'item_id' => $newItem['itemId'],
                            'quantity' => $newItem['quantity'],
                        ]);
                    }
                }
                else{
                    $rentItemPackage = RentItemPackage::create([
                        'event_id' => $validatedData['event_id'],
                        'name' => $rentPackage['package_name'],
                    ]);

                    // Create rent package items for old order items
                    foreach ($oldOrderedItems as $oldItem) {
                        $itemId = OrderItem::where('id', $oldItem['oderItemId'])->pluck('item_id')->first();
                        RentItemPackageItem::create([
                            'rent_item_package_id' => $rentItemPackage->id,
                            'item_id' => $itemId,
                            'quantity' => $oldItem['quantity'],
                        ]);
                    }

                    // Create rent package items for new order items
                    foreach ($newOrderedItems as $newItem) {
                        RentItemPackageItem::create([
                            'rent_item_package_id' => $rentItemPackage->id,
                            'item_id' => $newItem['itemId'],
                            'quantity' => $newItem['quantity'],
                        ]);
                    }

                }
            }
        }
        // If predefinedPackage is not null
        if($predefinedCreatePackage != null){
            foreach ($predefinedCreatePackage as  $predefinedPackage) {
                // If check existing  predefined package
                if( $predefinedPackage['package_id'] != null || $predefinedPackage['package_id'] != ''){
                    // Get predefined package items
                    $predefinedPackageItems = PredefinedPackageItem::where('predefined_package_id', $predefinedPackage['package_id'])->get();

                    // Iterate over each item in the predefined package
                    foreach ($predefinedPackageItems as $item) {
                        // Check if the item is not present in the old item IDs
                        if (!in_array($item->item_id, $oldItemIds)) {
                            // Delete the item if it is not in the old item IDs
                            $item->delete();
                        }
                    }

                    // Update predefined package
                    PredefinedPackage::where('package_id', $predefinedPackage['package_id'])->update([
                        'package_name' =>  $predefinedPackage['package_name'],
                        'category' => $predefinedPackage['category'],
                        'package_status' => $predefinedPackage['package_status'],
                    ]);

                    // Update predefined package items
                    foreach ($oldOrderedItems as $oldItem) {
                        $itemId = OrderItem::where('id', $oldItem['oderItemId'])->pluck('item_id')->first();
                        foreach ($predefinedPackageItems as $packageItem) {
                            if($packageItem->item_id == $itemId){
                                $packageItem->update([
                                    'quantity' => $oldItem['quantity'],
                                    'item_price' => $oldItem['rentPrice'],
                                ]);
                            }
                        }
                    }

                    // Create predefined package items for new order items
                    foreach ($newOrderedItems as $newItem) {
                        PredefinedPackageItem::create([
                            'predefined_package_id' => $predefinedPackage['package_id'],
                            'item_id' => $newItem['itemId'],
                            'quantity' => $newItem['quantity'],
                            'item_price' => $newItem['rentPrice'],
                        ]);
                    }
                }
                else{
                    $predefinedPackageNew = PredefinedPackage::create([
                        'package_name' =>  $predefinedPackage['package_name'],
                        'category' => $predefinedPackage['category'],
                        'package_status' => $predefinedPackage['package_status'],
                        'order_id' => $order->order_id,
                    ]);

                    // Create predefined package items for old order items
                    foreach ($oldOrderedItems as $oldItem) {
                        $item = OrderItem::where('id', $oldItem['oderItemId'])->first();
                        PredefinedPackageItem::create([
                            'predefined_package_id' => $predefinedPackageNew->package_id,
                            'item_id' => $item['item_id'],
                            'quantity' => $oldItem['quantity'],
                            'item_price' => $oldItem['rentPrice'],
                            'item_name' => $item['item_name'],
                        ]);
                    }
                    // Create predefined package items for new order items
                    foreach ($newOrderedItems as $newItem) {
                        PredefinedPackageItem::create([
                            'predefined_package_id' => $predefinedPackageNew->package_id,
                            'item_id' => $newItem['itemId'],
                            'quantity' => $newItem['quantity'],
                            'item_price' => $newItem['rentPrice'],
                            'item_name' => Item::where('item_id', $newItem['itemId'])->pluck('item_name')->first(),
                        ]);
                    }
                }
            }
        }
        // Delete order items that are not in the oldOrderItemIds array
        foreach ($orderItemsFromDB as $item) {
            if (!in_array($item->id, $oldOrderItemIds)) {
                $item->delete();
            }
        }

        // Calculate net_amount
        $net_amount = 0;

        foreach ($newOrderedItems as $item) {
            $net_amount += (($item['rentPrice'] * $item['quantity']) - $item['discount']);
        }

        foreach ($oldOrderedItems as $item) {
            $net_amount += (($item['rentPrice'] * $item['quantity']) - $item['discount']);
        }

        if ($validatedData['tax'] || $validatedData['transport']) {
            $net_amount += $validatedData['tax'] + $validatedData['transport'];
        }
        if($validatedData['total_discount']){
            $net_amount -= $validatedData['total_discount'];
        }

        if($net_amount  !=  $validatedData['net_amount']){
            return redirect()->back()->with('error', 'Net amount not matched');
        }

        //check employess selected or not
        if (isset($validatedData['name']))  {
            $employeeNames = implode(',', $validatedData['name']);

        } else {
            $employeeNames=''; // Provide a default value if 'name' key is not present

        }

        if (!$order) {
           return redirect()->back()->with('error', 'Order not found');
        }


        $order->update([

            'order_type' => $validatedData['order_type'],
            'customer_name' => $validatedData['customer_name'],
            'customer_phone' => $validatedData['customer_phone'],
            'location' => $validatedData['location'],
            'event_name' => $validatedData['event_name'],
            'event_id' => $validatedData['event_id'],
            'bank_id' => $validatedData['Bank_account'] ?? BankAccount::getDefaultBankAccountId(),
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'booking_date' => $validatedData['booking_date'],
            'inv_date' => $validatedData['inv_date'],
            'order_status' => $validatedData['order_status'],
            'order_book' => $request->input('order_book', 0),
            'is_pay' => $request->input('is_pay', 0),
            'pay_amount' => $validatedData['pay_amount'],
            'advance_amount' => $request->input('advance_amount', 0),
            'total_discount' => $request->input('total_discount', 0),
            'net_amount' => $request->input('total_price', 0),
            'grand_total' => $request->input('net_amount', 0),
            'tax' => $request->input('tax', 0),
            'transport' => $request->input('transport', 0),
            'additional_price' => $request->input('additional_price', 0),
            'final_amount' => $request->input('grand_total', 0),
            'name' => $employeeNames,
            'item_name' => $request->input('item_name'),
            'special_note' => $request->input('special_note'),
            'terms_description' => $request->input('terms_description'),


        ]);
        // Update Event Status
        $event = AdminEvent::where('eid', $validatedData['event_id'])->first();
        if ($event) {
             if(  $order->order_status == 'credit order'){
                 $event->status = 'credit';
                 $event->save();
             }
             else{
                 $event->status = $order->order_status;
                 $event->save();
             }
        }
        // Update terms and conditions
        if ($request->has('terms_and_conditions')) {
            $termsData = $request->input('terms_and_conditions');
            if(!$termsData['term_id'] || !$termsData['description']){
                return redirect()->back()->with('error', 'Please select terms and conditions');
            }
            else{
                $termsAndConditions = OrderTermsCondition::where('order_id', $order->order_id)->first();
                if ($termsAndConditions) {
                    $termsAndConditions->update([
                        'terms_and_conditions_id' => $termsData['term_id'],
                        'terms_description' => $termsData['description']
                    ]);
                } else {
                    OrderTermsCondition::create([
                        'order_id' => $order->order_id,
                        'terms_and_conditions_id' => $termsData['term_id'],
                        'terms_description' => $termsData['description']
                    ]);
                }
            }
        }

        if($validatedData['order_status'] == 'booking') {
            if ($order->pay_amount > 0) {

                // current given advance amount total
                $givenAdvanceAmount = CashFlow::where('ref_id', $order->order_id)->where('ref_name', 'order')->where('is_income', 1)->sum('amount');
                $balanceAdvancedAmount = $order->pay_amount - $givenAdvanceAmount;

                // check if balanceAdvancedAmount is greater than 0
                if ($balanceAdvancedAmount > 0) {
                    $date = Carbon::now()->format('Y-m-d');
                    // Create a new CashFlow entry using the helper
                    $is_cashflow_saved = CashFlowHelper::create(
                        $name =  ' Order_Id: ' . $order->order_id . ' Order ' . $order->customer_name . ' ' . $order->start_time . ' to ' . $order->end_time,
                        $amount = $balanceAdvancedAmount,
                        $date = $date,
                        $ref_id = $order->order_id,
                        $ref_name = Order::getTableName(),
                        $incomeOrExpense = 'INCOME'
                    );
                }
            }
        }

        if($validatedData['order_status'] == 'completed') {
            $completeorderAmount =  $request->orderAmount;

                // Get  the current pay_amount
                $payAmount = $order->pay_amount;
                // update Order table
                $order->pay_amount = $completeorderAmount + $payAmount; // Add the new amount sum to the current pay_amount
                $order->final_amount = 0.00;
                $order->order_status = 'completed';
                $order->save();

                // Store the record in the payment_log table
                $paymentLog = new Payment_log();
                $paymentLog->credit_order_id = null;
                $paymentLog->order_id = $order->order_id;
                $paymentLog->paid_date = date('Y-m-d');
                $paymentLog->paid_amount = $completeorderAmount;

                if ($completeorderAmount > 0) {
                    // Get the current date
                    $date = Carbon::now()->format('Y-m-d');
                    // Create a new CashFlow entry using the helper
                    $is_cashflow_saved = CashFlowHelper::create(
                        $name = ' Order_Id: ' . $order->order_id . ' Order ' . $order->customer_name . ' ' . $order->start_time . ' to ' . $order->end_time,
                        $amount = $completeorderAmount,
                        $date = $date,
                        $ref_id = $order->order_id,
                        $ref_name = Order::getTableName(),
                        $incomeOrExpense = 'INCOME'
                    );
                }

                $paymentLog->save();

        }

        // If order type is invoice only
        if($request->input('order_type') == 'invoice') {
            // Check if the order exists and has the status of 'credit order'
            if($order && $order->order_status == 'credit order') {
                // Create or update the credit order based on the order_id
                $creditOrder = CreditOrder::updateOrCreate(
                    ['order_id' => $order->order_id],  // Condition to check for existing credit order
                    [   // Data to update or create
                        'customer_id' => $request->input('customer_id'),
                        'customer_name' => $request->input('customer_name'),
                        'total_amount' => $order->final_amount,
                        'credit_amount' => $order->final_amount, // credit amount is the same as the final amount
                        'booking_date' => $order->booking_date,
                    ]
                );
            }
        }

        $deletedItems = json_decode($request->input('removeExist_items'), true); // get deleted item ids

        if($deletedItems) {

            // itertate the deleted item array
            foreach ($deletedItems as $deletedItem) {

                // Find delete item name
                $deleteItemName = Item::where('item_id', $deletedItem)->value('item_name');
                // Perform the delete using item name
                OrderBook::where('order_id', $order->order_id)->where('item_name',$deleteItemName)->delete();
                //  Perfome the delete using item id
                OrderItem::where('order_id', $order->order_id)->where('item_id', $deletedItem)->delete();

            }
        }


        if (isset($validatedData['is_pay']) && $validatedData['pay_amount']) {
            $isPay = true;
            $payAmount = $validatedData['pay_amount'];
        } else {
            $isPay = false;
            $payAmount = 0;
        }

        OrderBook::where('order_id', $order->order_id)->delete();

        if( !empty($oldOrderedItems) ) {

            // Update OrderItem table(old items)
            foreach ($oldOrderedItems as $item) {
                $orderItem = OrderItem::find($item['oderItemId']);
                $orderItem->update([
                    'quantity' => $item['quantity'],
                    'rent_price' => $item['rentPrice'],
                    'discount' => $item['discount'],
                    'description' => $item['description'],
                ]);

                // Order Book table update
                OrderBook::create([
                    "customer_name" => $validatedData['customer_name'],
                    "order_id" => $order->order_id,
                    "booking_date" => $validatedData['booking_date'],
                    "order_status" => $validatedData['order_status'],
                    "event_name" => $validatedData['event_name'],
                    "location" => $validatedData['location'],
                    "start_time" => $validatedData['start_time'],
                    "end_time" => $validatedData['end_time'],
                    "item_name" => $orderItem->item_name,
                    "customer_phone" => $validatedData['customer_phone'],
                    "total_balance" => $net_amount,
                    "payment_amount" => $payAmount,
                    'is_pay' => $isPay,
                    'pay_amount' => $payAmount,
                    'name' => $employeeNames,
                ]);

            }
        }

        if( !empty($newOrderedItems) ) {

            foreach ($newOrderedItems as $item) {
                // Create a new order item
                $orderItem = new OrderItem([
                    'order_id' => $order->order_id,
                    'item_id' => $item['itemId'],
                    'item_name' => Item::find($item['itemId'])->item_name,
                    'quantity' => $item['quantity'],
                    'rent_price' => $item['rentPrice'],
                    'discount' => $item['discount'],
                    'description' => $item['description'],
                ]);
                $orderItem->save();

                // Create a new order book
                OrderBook::create([
                    "customer_name" => $validatedData['customer_name'],
                    "order_id" => $order->order_id,
                    "booking_date" => $validatedData['booking_date'],
                    "order_status" => $validatedData['order_status'],
                    "event_name" => $validatedData['event_name'],
                    "location" => $validatedData['location'],
                    "start_time" => $validatedData['start_time'],
                    "end_time" => $validatedData['end_time'],
                    "item_name" => Item::find($item['itemId'])->item_name,
                    "customer_phone" => $validatedData['customer_phone'],
                    "total_balance" => $net_amount,
                    "payment_amount" => $validatedData['pay_amount'],
                    'is_pay' => $isPay,
                    'pay_amount' => $payAmount,
                    'name' => $employeeNames,
                ]);
            }
        }

        //commits the changes
        DB::commit();

        // Send a success message to the same page
        return redirect()->route('useradmin.order.vieworderitems.edit', $order->order_id)->with('success', 'Order updated successfully.');


    }catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('useradmin.order.vieworderitems.edit', $order->order_id)->with('error', 'An error occurred while processing the order: ' . $e->getMessage());
    }
}

    public function cancelOrder(Order $order)
    {

        DB::beginTransaction();

    try {
            if (!$order) {
                return redirect()->back()->with('error', 'Order not found.');
            }

            // Update order status to canceled
            $order->order_status = 'canceled';
            $order->save();


            // Update all related order items status to canceled
            OrderBook::where('order_id', $order->order_id)->update(['order_status' => 'canceled']);

            //commits the changes
            DB::commit();

            return redirect()->back()->with('success', 'Order and its items canceled successfully.');


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the order: ' . $e->getMessage());
        }
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        DB::beginTransaction();
        try {
            // Delete related records
            CashFlowHelper::delete(
                $ref_id = $id,
                $ref_name = Order::getTableName()
            );
            // Delete the order book records
            OrderBook::where('order_id', $id)->delete();
            // Delete the order item records
            OrderItem::where('order_id', $id)->delete();
            // Delete the job amount records
            JobAmount::where('order_id', $id)->delete();
            // Delete the AdditionalExpense records
            AdditionalExpense::where('order_id', $id)->delete();
            // Delete the CreditOrder records
            CreditOrder::whereIn('order_id', [$id])->delete();
            // Delete the Payment_log records
            Payment_log::whereIn('order_id', [$id])->delete();

            // Finally delete the order
            $order->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'An error occurred while processing the order: ' . $e->getMessage());
        }
    }

    public function updateDescription(Request $request)
    {
        $orderId = $request->input('order');
        $itemId = $request->input('item_id');
        $description = $request->input('description');

        // Find the order item by order ID and item ID
        $orderItem = OrderItem::where('order_id', $orderId)->where('item_id', $itemId)->first();

        // Check if the order item exists
        if ($orderItem) {
            // Update the description
            $orderItem->description = $description;

            // Save the order item
            $orderItem->save();

            // Return a success response with the updated item
            return response()->json(['success' => true, 'message' => 'Description updated successfully', 'item' => $orderItem]);
        } else {
            // Return an error if the item is not found
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }
    }

    public function itemdelete($itemId)
    {

    // Find the order item by its ID and delete it
    $order_item = OrderItem::where('item_id', $itemId)->first();
    if ( $order_item) {
            $order_item->delete();
            return response()->json(['success' => 'Item deleted successfully']);
        } else {
                return response()->json(['error' => 'Item not found'], 404);
            }
    }

    //*** Function to  view booking order dates in calender ***/
    public function calendar()
    {
        // All events
        $events =  AdminEvent::whereNotIn('status', ['cancelled', 'completed'])->get();
        // Completed events
        $completedData = AdminEvent::whereIn('status', ['completed'])->get();

        return view('order.calendar', compact('completedData', 'events'));
    }


    //*** Function to generateInvoice ***//
    public function generateInvoice(Request $request, $id)
    {
        if(($request->input('confirmWithItemPrice'))){
            // confirm with item price
          $confirmWithItemPrice = 'on';
        }
        else{
          $confirmWithItemPrice = 'off';
         }

        //get order details
        $order = Order::findOrFail($id);
        $orderItems = orderItem::where('order_id', $id)->get();

        foreach ($orderItems as $orderitem) {
        $item = DB::table('item')->where('item_id', $orderitem->item_id)->first();
        $orderitem->item_category = $item->category;
        }
        //Group by category
        $orderItems = $orderItems->groupBy('item_category');

        // Find the terms and conditions for the order
        $termsAndConditions = OrderTermsCondition::where('order_id', $id)->first();
        $termsDescription = $termsAndConditions ? $termsAndConditions->terms_description : '';

         // Bank details
         $bankId = $order->bank_id;
         // Check if a bank ID was provided
         if ($bankId) {
             $bankDetails = BankAccount::where('id', $bankId)->first();
         }
         else{
             // Find default bank details
             $bankDetails = BankAccount::where('is_default', true)->first();
         }

        // Check order has event_id
        if ($order->event_id) {
            // Get event Multiple Dates
            $eventDates = EventDate::where('event_id', $order->event_id)->get();
        }

        //check order type
        if ($order['order_type'] == "invoice") {

            $invoice = Invoice::where('order_id',$id)->first();

            if( isset($invoice)){
                $invoiceNo = $invoice->id;
            }
            else{

                // Save invoice to DB
                $invoice = new Invoice();
                $invoice->order_id = $id;
                $invoice->save();

                $invoiceNo = $invoice->id;
            }

             //**TODO  THIS  USE FOR TEMPERARY */
            $grandTotalCorrect = null;
            if ($order['additional_price'] > 0) {
                // this is the correct grand total
                $grandTotalCorrect = $order['additional_price'];
            } else {
                $grandTotalCorrect = ($order['final_amount'] == 0) ? $order['pay_amount'] : $order['grand_total'];
            }

        return view('order.invoice', [
        'order' => $order,
        'invoice' => $invoiceNo,
        'orderItems' => $orderItems,
        'totalDiscount' => $order['total_discount'],
        'netAmount' => $order['net_amount'],
        'grandTotal' => $order['grand_total'],
        'customerName' => $order['customer_name'],
        'additionalPrice' => $order['additional_price'],
        'tax' => $order['tax'],
        'transport' => $order['transport'],
        'customerPhone' => $order['customer_phone'],
        'Location' => $order['location'],
        'payAmount' => $order['pay_amount'],
        'startTime' => $order['start_time'],
        'endTime' => $order['end_time'],
        'finalAmount' => $order['final_amount'],
        'confirmWithItemPrice' => $confirmWithItemPrice,
        'grandTotalCorrect' => $grandTotalCorrect,
        'special_note' => $order['special_note'],
        'terms_description' => $termsDescription,
        'bank_details' => $bankDetails,
        'eventDates' => $eventDates ?? null

        ])->with('success', 'Order Placed Successfully!');
        } else {
        return redirect()->route('useradmin.order.vieworderitems.edit', $order->order_id)->with('error', 'Order Type Must be Invoice');
        }

    }
    //**  FUNCTION TO  GENERATE QUOTATION */

    public function generateQuotation(Request $request,$id)
    {

        if(($request->input('confirmWithItemPrice'))){
            // confirm with item price
            $confirmWithItemPrice = 'on';
        }
        else{
            $confirmWithItemPrice = 'off';
            }
        //get order details
        $order = Order::findOrFail($id);
        $orderItems = orderItem::where('order_id', $id)->get();

        // Find the terms and conditions for the order
        $termsAndConditions = OrderTermsCondition::where('order_id', $id)->first();
        $termsDescription = $termsAndConditions ? $termsAndConditions->terms_description : '';

        foreach ($orderItems as $orderitem) {
        $item = DB::table('item')->where('item_id', $orderitem->item_id)->first();
        $orderitem->item_category = $item->category;
        }
        //Group by category
        $orderItems = $orderItems->groupBy('item_category');

        // Handle terms and conditions description
        $description = null;
        if (Schema::hasColumn('terms_and_conditions', 'order_id')) {
            $termsAndConditions = TermsAndConditions::where('order_id', $id)->first();
            $description = $termsAndConditions ? $termsAndConditions->description : null;
        }

        // Bank details
        $bankId = $order->bank_id;
        // Check if a bank ID was provided
        if ($bankId) {
            $bankDetails = BankAccount::where('id', $bankId)->first();
        }
        else{
            // Find default bank details
            $bankDetails = BankAccount::where('is_default', true)->first();
        }
        // Check order has event_id
        if ($order->event_id) {
            // Get event Multiple Dates
            $eventDates = EventDate::where('event_id', $order->event_id)->get();
        }

        //Check order type
        if ($order['order_type'] == "quotation" || $order['order_type'] == "invoice") {
              //**TODO  THIS  USE FOR TEMPERARY */
              $grandTotalCorrect = null;
              if ($order['additional_price'] > 0) {
                  // this is the correct grand total
                  $grandTotalCorrect = $order['additional_price'];
              } else {
                  $grandTotalCorrect = ($order['final_amount'] == 0) ? $order['pay_amount'] : $order['grand_total'];
              }

        return view('order.quotation', [
            'order' => $order,
            'orderItems' => $orderItems,
            'totalDiscount' => $order['total_discount'],
            'netAmount' => $order['net_amount'],
            'grandTotal' => $order['grand_total'],
            'customerName' => $order['customer_name'],
            'additionalPrice' => $order['additional_price'],
            'tax' => $order['tax'],
            'transport' => $order['transport'],
            'customerPhone' => $order['customer_phone'],
            'Location' => $order['location'],
            'payAmount' => $order['pay_amount'],
            'startTime' => $order['start_time'],
            'endTime' => $order['end_time'],
            'finalAmount' => $order['final_amount'],
            'confirmWithItemPrice' => $confirmWithItemPrice,
            'description' => $description,
            'special_note' => $order['special_note'],
            'terms_description' => $termsDescription,
            'bank_details' => $bankDetails,
            'eventDates' => $eventDates ?? null

            ])->with('success', 'Order Placed Successfully!');
            } else {
            return redirect()->route('useradmin.order.vieworderitems.edit', $order->order_id)->with('error', 'Order Type Must be Quotation');
            }
    }

    //*** Function to  view all bookingOrders ***/
    public function bookorder()
    {
        // Get all booking orders
        $bookingOrders = Order::where('order_status', 'booking')->orderByDesc('order_id')->get();

        // Initialize an array to hold item names for all orders
        $itemNames = [];

        // Iterate over each booking order
        foreach ($bookingOrders as $order) {
            // Get order items in Item table
            $itemsOrder = OrderItem::where('order_id', $order->order_id)->get();

            // Iterate over each order item and add the item name to the itemNames array
            foreach ($itemsOrder as $item) {
                $itemNames[$order->order_id][] = $item->item_name;
            }
        }

        // Return view with booking orders and their item names
        return view('order.orderbook', compact('bookingOrders', 'itemNames'));
    }


    //*** Function to view credit  Orders ***/
    public function creditorder()
    {

        // Retrieve orders based on their status
        $OrderDetails = Order::where('order_status', 'credit order')->orderByDesc('order_id')->get();


        // Initialize arrays to hold item names for each order status
        $itemNamesCreditOrder = [];



        // Fetch and store item names for credit orders
        foreach ($OrderDetails as $order) {
            $itemsOrder = OrderItem::where('order_id', $order->order_id)->get();


            foreach ($itemsOrder as $item) {
                $itemNamesCreditOrder[$order->order_id][] = $item->item_name;
            }

        }

        //get  credit amount in credit_orders tables
        foreach ($OrderDetails as $order) {
            $creditOrderDetails = DB::table('credit_orders')->where('order_id', $order->order_id)->first();

            // Check if the result is null before accessing the credit_amount property
            if ($creditOrderDetails) {
                $order->credit_amount = $creditOrderDetails->credit_amount;
                $order->credit_order_id = $creditOrderDetails->credit_order_id;
            } else {
                $order->credit_amount = 0;
            }

        }

        // Pass data to the view
        return view('order.creditorder', compact('OrderDetails', 'itemNamesCreditOrder'));


    }

    //** FUNCTION TO VIEW CREDIT ORDER PAYMENT VIEW */
    public function creditorderpayments(Order $order)
    {

       //get that order details in credit table
       $creditDetails = DB::table('credit_orders')->where('order_id', $order->order_id)->first();

       $creditAmount = $creditDetails->credit_amount;
       $totalAmount = $creditDetails->total_amount;

        return view('order.creditorderpayment', compact('creditAmount','creditDetails','totalAmount'));
    }

    //** FUNCTION TO VIEW CREDIT ORDER PAYMENT STORE */
    public function creditorderpaymentstore(Request $request, Order $order)
    {

      //check validation
        $request->validate([
            'Order_id' => 'required',
            'pay_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'arrears' => 'required|numeric|min:0',
            'pay_amount' => ['required', 'min:0', 'lte:arrears'],
            'payement_type' => 'required|in:Cash,Bank Transfer,Cheque',

        ]);

    DB::beginTransaction();

    try{

        //  Find credit order id
        $creditOrder = DB::table('credit_orders')->where('order_id', $request->Order_id)->first();

        //create new payment log row
        $paymentlog = new Payment_log();
        $paymentlog->credit_order_id= $creditOrder->credit_order_id;
        $paymentlog->order_id = $request->Order_id;
        $paymentlog->paid_amount = $request->pay_amount;
        $paymentlog->paid_date = date('Y-m-d');
        $paymentlog->payment_type = $request->payement_type;

        $paymentlog->save();

       // Update the credit order's credit_amount
        $creditOrder->credit_amount = $creditOrder->credit_amount - $paymentlog->paid_amount;

        // Save the updated credit order back to the database
        DB::table('credit_orders')
            ->where('order_id', $request->Order_id)
            ->update(['credit_amount' => $creditOrder->credit_amount]);

            // When creditorder is 0 already paid all areas amount
            if ($creditOrder->credit_amount == 0) {

                //Change order status in order table
                // Save the updated credit order back to the database
                DB::table('order')
                    ->where('order_id', $request->Order_id)
                    ->update(['order_status' => 'completed']);
                //  Get Existing Final Amount
                $existingFinalAmount = DB::table('order')
                    ->where('order_id', $request->Order_id)
                    ->value('final_amount');
                // Update Final Amount AND Pay Amount
                DB::table('order')
                    ->where('order_id', $request->Order_id)
                    ->update(['pay_amount' => $existingFinalAmount, 'final_amount' => 0.00]);

            }

            // credit order add to  cashflow
            if ($request->pay_amount > 0) {
                $is_cashflow_saved_credit_order = CashFlowHelper::create(
                    $name = 'Credit Order ' . Carbon::parse($paymentlog->paid_date)->format('Y-m-d') . ' ' . $request->customer_name,
                    $amount = $request->pay_amount,
                    $date = $paymentlog->paid_date,
                    $ref_id = $paymentlog->credit_order_id,
                    $ref_name = CreditOrder::getTableName(),
                    $incomeOrExpense = 'INCOME'
                );
            }
            DB::commit();
          return redirect()->back()->with('success', 'Payment Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Payment Failed');
        }

    }

    //** FUNCTION TO VIEW CREDIT ORDER PAYMENT VIEW */
    public function creditorderPayemnetsView(Request $request)
    {
        // Get all credit order_id included payments in payment_log table
        $creditOrdersPayements = Payment_log::orderBy('created_at', 'desc')->where('credit_order_id','!=',null)->get();

        // Get creit_order_id separe details in credit_order_table
        foreach ($creditOrdersPayements as $payment) {
            $creditOrders = CreditOrder::where('credit_order_id', $payment->credit_order_id)->first();
            if($creditOrders){
                $payment->order_id = $creditOrders->order_id;
            }
        }
       return view('order.creditorderpaymentview',  ['creditOrdersPayements' => $creditOrdersPayements, 'downloadable' => true]);
    }

        //*** Function to view all complete orders ***/
    public function completeorder()
    {
        $completeOrders = Order::where('order_status', 'completed')->orderByDesc('order_id')->get();

        // Initialize an array to hold item names for all orders
        $itemNames = [];

        //* Iterate over each complete order
        foreach ($completeOrders as $order) {
            //* Get complete order items in Item table
            $itemsOrder = OrderItem::where('order_id', $order->order_id)->get();

        //* Iterate over each order item and add the item name to the itemNames array
            foreach ($itemsOrder as $item) {
                $itemNames[$order->order_id][] = $item->item_name;
            }
        }

        return view('order.completeorder', compact('completeOrders', 'itemNames'));
    }

        //*** Function to view advance orders ***/
    public function advanceorder()
    {
       $advanceOrders = Order::where('pay_amount', '!=', 0.00)
               ->whereIn('order_status', ['booking', 'completed'])
               ->orderByDesc('order_id')
               ->get();
        // Initialize an array to hold item names for all orders
            $itemNames = [];

        //* Iterate over each advance order
        foreach ($advanceOrders  as $order) {
            //* Get advance order items in Item table
            $itemsOrder = OrderItem::where('order_id', $order->order_id)->get();

            //* Iterate over each order item and add the item name to the itemNames array
            foreach ($itemsOrder as $item) {
                $itemNames[$order->order_id][] = $item->item_name;
            }
        }
        return view('order.paymentorder', compact('advanceOrders','itemNames'));
    }


    //*** Function to update order status ***/

    public function updateOrderStatus(Request $request, $order_id)
    {
        //find order which order_status and order pay_amount update
        $order = Order::findOrFail($order_id);
        $order->order_status = $request->input('order_status');
        $order->pay_amount = (float) $request->input('payment_amount');
        $order->save();

        $orderBook = OrderBook::where('order_id', $order_id)->first();
        if ($orderBook) {
            $orderBook->order_status = $request->input('order_status');
            $orderBook->total_balance = (float) ($order->final_amount - $order->pay_amount);
            $orderBook->payment_amount = $order->pay_amount;
            $orderBook->save();
        }

        return redirect()->back()->with('success', 'Order status, total balance, and payment amount updated successfully');
    }

    //***  Function AJAX request to fetch customer details ***/
    public function fetchDetails(Request $request)
    {

        //check parsing id  matching customer
        $customerId = $request->input('customer_id');
        $customer = Customer::where('customer_Id', $customerId )->first();

        if ($customer) {
            //return customer matching phone number and location
            return response()->json([
                'phone_number' => $customer->customer_phone,
                'location' => $customer->location,
            ]);
        } else {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }
    // *** Function AJAX Request to fetch event details  */
    public function fetchEventDetails(Request $request)
    {
        // Check if the event ID is valid
        $eventId = $request->input('event_id');
        $event = AdminEvent::where('eid',$eventId)->first();

        // Get the Customer details in Customer table
        $customer = Customer::where('customer_id', $event->customer_id)->first();

        if ($event) {
            // Return the event details
            return response()->json([
                'event_date' => $event->event_date,
                'start_datetime' => $event->start_datetime,
                'end_datetime' => $event->end_datetime,
                'location' => $event->location,
                'customer_name' => $customer->customer_name,
                'customer_phone' => $customer->customer_phone,
                "customer_id" => $customer->customer_id
            ]);
        } else {
            return response()->json(['error' => 'Event not found'], 404);
        }
    }


    //*** FUNCTION TO FETCH ORDER DETAILS/EVENT DETAILS FOR CALENDER   */
   public function getOrderDetails($eventId)
   {
        // Get the event
        $event = AdminEvent::where('eid', $eventId)->first();
        // Get that event assigned agents list
        $eventAgents = DB::table('agent_event')->where('event_id', $eventId)->pluck('agent_id');
        // Get the agent list
        if($eventAgents){
            $agentList = Agent::whereIn('id', $eventAgents)->get();
        }
        // Get that event assigned sponsors list
        $eventSponsors = AdminEvent::where('eid', $eventId)->with('sponsors')->first();
        // Get the orders for the event
        $orders = Order::where('event_id', $eventId)->orderByDesc('order_id')->get();

       if ($event) {
           // Return the event details and orders
           return response()->json([
               'event_details' => [
                   'id' => $event->eid,
                   'event_name' => $event->event_name,
                   'location' => $event->location,
                   'customer_name' => Customer::where('customer_id', $event->customer_id)->value('customer_name'),
                   'customer_phone' => Customer::where('customer_id', $event->customer_id)->value('customer_phone'),
                   'start_datetime' => $event->start_datetime,
                   'end_datetime' => $event->end_datetime,
                   'status' => $event->status
               ],
               'orders' => $orders->map(function ($order) {
                   return [
                       'id' => $order->order_id,
                       'event_name' => $order->event_name,
                       'location' => $order->location,
                       'customer_name' => $order->customer_name,
                       'customer_phone' => $order->customer_phone,
                       'order_type' => $order->order_type,
                       'grand_total' => number_format($order->grand_total, 2),
                       'additional_price' => number_format($order->additional_price, 2),
                       'order_status' => $order->order_status
                   ];
               }),
               'agentList' => $agentList->map(function ($agent) {
                   return [
                       'id' => $agent->id,
                       'name' => $agent->name,
                       'email' => $agent->email,
                       'phone' => $agent->phone,
                       'type' => $agent->type,
                       'status' => $agent->status
                   ];
               }),
               'sponsors' => $eventSponsors->sponsors->map(function ($sponsor) {
                   return [
                       'id' => $sponsor->sponsor_id,
                       'name' => $sponsor->sponsor_name,
                       'phone' => $sponsor->sponsor_phone,
                       'status' => $sponsor->status
                   ];
               })
           ]);
       } else {
           return response()->json(['error' => ' Event not found'], 404);
       }
   }
    //** Function to view event order ***/
    public function createEventOrder()
    {
        // Get all customers
        $customers = Customer::where('status', 'active')->get();
        return view('order.addOrderEvent', compact('customers'));
    }

    //** Function to store event order ***/
    public function storeEventOrder(Request $request)
    {

        // Validate the input
        $validated = $request->validate([
            'name' => 'required|unique:events,event_name',
            'start_datetime' => 'required|date',
            'event_date' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'setup_time' => 'nullable|date',
            'location' => 'required',
            'customer' => 'required|max:255|exists:customer,customer_id',
            'time_slot.*' => 'nullable|array',
        ]);

        try {

            //  Check if an event with the same name already exists
            $existingEvent = AdminEvent::where('event_name', $request->input('name'))->first();
            //  Get time slots
            $timeSlots = json_decode($request->input('time_slot'), true);

            if ($existingEvent) {
                // no added name
                return response()->json([
                    'status' => 400,
                    'message' => 'Event name already exists',
                ], 400);
            }

            // Create the event
            $event = AdminEvent::create([
                'customer_id' => $validated['customer'],
                'event_name' => $validated['name'],
                'event_date' => date('Y-m-d', strtotime($validated['event_date'])),
                'start_datetime' => date('Y-m-d H:i:s', strtotime($validated['start_datetime'])),
                'setup_time' => date('Y-m-d H:i:s', strtotime($validated['setup_time'])),
                'end_datetime' => date('Y-m-d H:i:s', strtotime($validated['end_datetime'])),
                'location' => $validated['location'],
                'status' => 'pending',
                'is_public' => 0
            ]);

            if($timeSlots){
                  // Create time slots for the event
                foreach ($timeSlots as $timeSlot) {
                    EventDate::create([
                        'event_id' => $event->eid,
                        'date' => $timeSlot['date'],
                        'start_time' => $timeSlot['start_time'],
                        'end_time' => $timeSlot['end_time'],
                    ]);

                }
            }

            // Get the updated list of events
            $events = AdminEvent::all();

            // Return events as JSON to the frontend
            return response()->json([
                'status' => 200,
                'message' => 'Event created successfully',
                'events' => $events, // Send the list of events
            ]);
        } catch (\Exception $e) {
            // Handle the error
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create event: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function cashflow(Order $order)
    {
        $transport = $order->transport;
        $advanced = $order->tax;

        $finalAmount = $order->final_amount;
        $payAmount = $order->pay_amount;

        $eventBudget = 0;
        ($finalAmount == 0) ? $eventBudget = $payAmount : $eventBudget = $finalAmount;

        $totalDiscount = $order->total_discount;

        // get additional expenses
        $additionalExpenses = AdditionalExpense::where('order_id', $order->order_id)->get();

        $additionalExpensesTotal = 0;
        foreach ($additionalExpenses as $additionalExpense) {
            $additionalExpensesTotal += $additionalExpense->amount;
        }

        $cashFlows = [];

        // Add Grand Total
        array_push($cashFlows, [
            'date' => $order->booking_date->format('Y-m-d'),
            'name' => 'Order Total Budget',
            'amount' => $eventBudget,
            'is_income' => 1,
            'is_expense' => 0,
            'type' => '',
        ]);

        // Add Transport
        array_push($cashFlows, [
            'date' => $order->booking_date->format('Y-m-d'),
            'name' => 'Transport',
            'amount' => $transport,
            'is_income' => 0,
            'is_expense' => 1,
            'type' => '',
        ]);

        // Jobs Amount
        $jobs = JobAmount::where('order_id', $order->order_id)->get();

        foreach ($jobs as $job) {
            array_push($cashFlows, [
                'date' => $order->booking_date->format('Y-m-d'),
                'name' => 'Order - '. $order->order_id . ' Job Amount - ' . $job->name,
                'amount' => $job->job_amount,
                'is_income' => 0,
                'is_expense' => 1,
                'type' => '',
            ]);
        }

        // Add Additional Expenses
        foreach ($additionalExpenses as $additionalExpense) {
            array_push($cashFlows, [
                'date' => $additionalExpense->expense_date,
                'name' => $additionalExpense->expense_name . ' - ' . $additionalExpense->description,
                'amount' => $additionalExpense->amount,
                'is_income' => 0,
                'is_expense' => 1,
                'type' => 'additional_expense',
                'additional_expense_id' => $additionalExpense->id
            ]);
        }

        //  Total Income
        $totalIncome = 0.00;
        $totalExpense = 0.00;

        foreach ($cashFlows as $cashFlow) {
            if ($cashFlow['is_income'] == 1) {
                $totalIncome += floatval($cashFlow['amount']);
            } elseif ($cashFlow['is_expense'] == 1) {
                $totalExpense += $cashFlow['amount'];
            }
        }

        $profitOrLoss = $totalIncome - $totalExpense;
        $title = "Cash Flow for Order " . $order->order_id;

        return view('cash_flow.view_order_wise', compact('cashFlows', 'totalIncome', 'totalExpense', 'profitOrLoss', 'order', 'title'));


    }
    public function getOrdersByEventId($eventId)
    {
        $orders = Order::where('event_id', $eventId)->get();

        return response()->json($orders);
    }

    public function bookingOrderPaymentCreate($id)
    {
        $order = Order::where('order_id', $id)->first();
        return view('order.booking_order.paymentCreate', compact('order'));
    }

    public function bookingOrderPaymentStore(Request $request , $id)
    {
      $validator = Validator::make($request->all(), [
          'Order_id' => 'required|exists:order,order_id',
          'customer_name' => 'required',
          'total_amount' => 'required|numeric',
          'arrears' => 'required|numeric',
          'pay_amount' => 'required|numeric',
      ]);

       if ($validator->fails()) {
           if ($request->ajax()) {
               return response()->json([
                   'errors' => $validator->errors()
               ], 422);
           } else {
               return redirect()->back()->withErrors($validator)->withInput();
           }
       } else {
           $validatedData = $validator->validated();
       }

       DB::beginTransaction();
       try{
           // Check arrears equal or greater than pay amount
           if ($request->pay_amount > $request->arrears) {
                return response()->json(['message' => 'Pay amount should be less than or equal to Balance!'], 500);
           }
           if($request->pay_amount <= 0){
                return response()->json(['message' => 'Pay amount should be greater than zero!'], 500);
           }
           // Check arrears equal to pay amount order status change to complete
           if ($request->pay_amount == $request->arrears) {
               $order = Order::where('order_id', $request->Order_id)->first();
               $order->order_status = 'completed';
               $order->save();

               // Update order book table
               $orderBooks = OrderBook::where('order_id', $request->Order_id)->get();
               foreach ($orderBooks as $orderBook) {
                   $orderBook->order_status = 'completed';
                   $orderBook->save();
               }
           }
            // Update the 'pay_amount' column
            $order = Order::where('order_id', $request->Order_id)->first();

            // Get existing pay_amount value
            $existingPayAmount = $order->pay_amount;

            // Get existing final amount value
            $existingFinalAmount = $order->final_amount;
            if( $existingPayAmount != null || $existingPayAmount > 0){
                $order->pay_amount = $existingPayAmount + $request->pay_amount;
                $order->final_amount = $existingFinalAmount - $request->pay_amount;
            }
            else{

                $order->pay_amount = $request->pay_amount;
                $order->final_amount = $existingFinalAmount - $request->pay_amount;
            }
            // Update order book table
            $orderBooks = OrderBook::where('order_id', $request->Order_id)->get();

            foreach ($orderBooks as $orderBook) {
                $existingPayAmount = $orderBook->pay_amount;
                $orderBook->payment_amount = $existingPayAmount + $request->pay_amount;
                $orderBook->pay_amount = $existingPayAmount + $request->pay_amount;
                $orderBook->is_pay = 1;
                $orderBook->save();
            }
            $order->save();

            DB::commit();

            return response()->json(['message' => 'Payment added successfully!'], 200);
       } catch (\Exception $e) {
           DB::rollBack();
           return response()->json(['message' => 'An error occurred while processing the payment: ' . $e->getMessage()], 500);
       }


    }
}
