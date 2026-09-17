<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Admin;
use App\Models\RentItem;
use App\Models\DamageItem;
use App\Http\Helper\Helper;
use App\Models\MissingItem;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Models\ItemUpdateHistory;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PredefinedPackageItem;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    //*** FUNCTION TO ADD NEW ITEMS TO THE SYSTEM ***/
    function additem(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'item_name' => 'string|required|unique:item,item_name',
            'total_stock' => 'string|required',
            'in_stock' => 'string|required',
            'out_stock' => 'string|required',
            'rent_price' => 'string|required',
            'product_amount' => 'string|required',
            'category' => 'string|nullable',
            'status' => 'string|nullable',
            'description' => 'nullable|string|max:255',
            'visible_to_customer' => 'string|required',
            'image' => 'nullable|image|mimes:jpeg,png,webp,jpg,gif,svg|max:5120',
            'item_type' => 'string|required|in:internal,external',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // HTTP status code for unprocessable entity
            }
            // For non-AJAX requests, redirect back with errors
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $item = new Item;
        $item->item_name = $request->input('item_name');
        $item->total_stock = $request->input('total_stock');
        $item->in_stock = $request->input('in_stock');
        $item->out_stock = $request->input('out_stock');
        $item->rent_price = $request->input('rent_price');
        $item->product_amount = $request->input('product_amount');
        $item->category = $request->input('category');
        $item->status = $request->input('status');
        $item->description = $request->input('description');
        $item->visible_to_customer = $request->input('visible_to_customer');
        $item->image = Helper::getFileUrl($request->image, 'uploads/products/');
        $item->item_type = $request->input('item_type');

        if($item->save()){
            if ($request->ajax()) {
                return response()->json(['message' => 'Item Added Successfully'], 200); // HTTP status 200 for success
            }

        }
    }

    //*** FUNCTION TO DISPLAY ADD ITEM FORM ***/
    function additemform()
    {
        // Get categories
        $categories = ItemCategory::where('status', 'active')->get();
        return view('item.additem', compact('categories'));
    }

    //*** FUNCTION TO VIEW ALL ITEMS IN THE SYSTEM ***/
    function viewitem()
    {
        $items = Item::all();
        return view('item.index', ['items' => $items]);
    }

    //*** FUNCTION TO EDIT ITEMS IN THE SYSTEM ***/
    function edititem($id)
    {
        $items = Item::where('item_id', $id)->first();
        $categories = ItemCategory::where('status', 'active')->get();
        return view('item.edititem', compact('items', 'categories'));
    }

    //*** FUNCTION TO UPDATE ITEMS IN THE SYSTEM ***/
    function updateitem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => '|required|string|max:255|unique:item,item_name,' . $id.',item_id',
            'total_stock' => '|required|string',
            'in_stock' => 'required|string',
            'out_stock' => 'required|string',
            'rent_price' => 'required|string',
            'product_amount' => 'required|string',
            'category' => 'nullable|string',
            'status' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'visible_to_customer' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,webp,jpg,gif,svg|max:5120',
            'item_type' => 'required|in:internal,external',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // HTTP status code for unprocessable entity
            }
            // For non-AJAX requests, redirect back with errors
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $imageName = $request->input('image');
        if ($request->hasFile('image')) {
            $oldimageName = Item::where('item_id', $id)->pluck('image')->first();
            $image_path =  $oldimageName;

            if ($oldimageName !== null && $oldimageName !== '' && file_exists($image_path)) {
                unlink($image_path);
            }
            $imageName = Helper::getFileUrl($request->image, 'uploads/products/');
        } else {
            $imageName = Item::where('item_id', $id)->pluck('image')->first();

        }

        DB::table('item')->where('item_id', $id)
            ->update([
                'item_name' => $request->input('item_name'),
                'total_stock' => $request->input('total_stock'),
                'in_stock' => $request->input('in_stock'),
                'out_stock' => $request->input('out_stock'),
                'rent_price' => $request->input('rent_price'),
                'product_amount' => $request->input('product_amount'),
                'category' => $request->input('category'),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
                'visible_to_customer' => $request->input('visible_to_customer'),
                'image' => $imageName,
                'item_type' => $request->input('item_type'),
            ]);

            $updatehistory = new ItemUpdateHistory;
            $updatehistory->item_id = $id;
            $updatehistory->previous_stock = $request->input('previous_total_stock');
            $updatehistory->updated_stock = $request->input('total_stock');
            $updatehistory->updated_by = $request->input('updated_by');
            $updatehistory->updated_at = $request->input('updated_at');
            $updatehistory->save();

            return response()->json(['message' => 'Item Updated Successfully'], 200); // HTTP status 200 for success
    }

    //*** FUNCTION TO DELETE ITEMS IN THE SYSTEM ***/
    function deleteitem($id)
    {
       try {
           $imageName = Item::where('item_id', $id)->pluck('image')->first();
           $image_path =  $imageName;

           if ($imageName !== null && $imageName !== '' && file_exists($image_path)) {
               unlink($image_path);
           }
           // Delete the item
           Item::where('item_id', $id)->delete();

           // Delete the corresponding item_update_history records
           $updatehistory = ItemUpdateHistory::where('item_id', $id)->delete();

           // Get  the rent item records associated with the deleted item
           $rentItems = RentItem::where('item_id', $id)->get();

           foreach ($rentItems as $rentItem) {

               // Check for that missing item records associated with the deleted item
               $missingItems = MissingItem::where('rent_item_id', $rentItem->rent_item_id)->get();
               foreach ($missingItems as $missingItem) {
                   $missingItem->delete();
               }

               // Check for the damage item records associated with the deleted item
               $damageItems = DamageItem::where('rent_item_id', $rentItem->rent_item_id)->get();
               foreach ($damageItems as $damageItem) {
                   $damageItem->delete();
               }
               $rentItem->delete();
           }
           // Get the predefined item records associated with the deleted item
           $predefinedItems = PredefinedPackageItem::where('item_id', $id)->get();
            foreach ($predefinedItems as $predefinedItem) {
                $predefinedItem->delete();
            }

           // Get the purchase order items associated with the deleted item
           $purchaseOrderItems = PurchaseOrderItem::where('item_id', $id)->get();
           foreach ($purchaseOrderItems as $purchaseOrderItem) {
               $purchaseOrderItem->delete();
           }

           return redirect()->route('useradmin.stockitem.view')->with('success', 'Item deleted successfully!');
       } catch (\Exception $e) {

           // Return an error message
           return redirect()->route('useradmin.stockitem.view')->with('error', 'Error deleting item: ' . $e->getMessage());
       }
    }

    //*** FUNCTION TO VIEW ITEM UPDATE HISTORY ***/
    function ViewUpdateHistory()
    {
        $updatehistory = ItemUpdateHistory::all();
        foreach ($updatehistory as $history) {
            $history->item_name = Item::where('item_id', $history->item_id)->pluck('item_name')->first();
        }
        return view('item.edithistory', ['updatehistory' => $updatehistory]);
    }
}
