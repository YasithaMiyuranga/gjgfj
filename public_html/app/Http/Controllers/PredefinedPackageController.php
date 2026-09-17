<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\PredefinedPackage;
use Illuminate\Support\Facades\DB;
use App\Models\PredefinedPackageItem;
use App\Models\PredefinedPackageCategory;
use Illuminate\Support\Facades\Validator;


class PredefinedPackageController extends Controller
{
    //*** FUNCTION TO DISPLAY FORM ***//
    function newpackage()
    {
        $items = Item::where('status', 'Available')->get();
        $packageCategories = PredefinedPackageCategory::all();

        // Get previous url
        $previousUrl = url()->previous();
        // Check if previous url is useradmin/order/create or edit
        if (str_contains($previousUrl, 'useradmin/order/create') || str_contains($previousUrl, 'useradmin/orderitems/view/edit/')) {
            return view('predefinedpackage.createpackagemodel', ['packageCategories' => $packageCategories]);

        }
        else{
            return view('predefinedpackage.createpackage', ['items' => $items], ['packageCategories' => $packageCategories]);
        }
    }

    //*** FUNCTION TO SAVE PACKAGE TO THE DATABASE ***//
    function savepackage(Request $request)
    {

        // Validation
        $data = Validator::make($request->all(), [
            'package_name' => 'required|string|max:255|unique:predefined_package,package_name',
            'category' => 'required|string|max:255',
            'package_status' => 'required|string',
            'selected_items' => 'required',
            'selected_items.*.itemId' => 'required|numeric',
            'selected_items.*.itemName' => 'required|string|max:255',
            'selected_items.*.rent_price' => 'required|numeric',
            'selected_items.*.quantity' => 'required|numeric',
            'item_id' => 'required|array',
            'item_id.*' => 'required|numeric',
            'rent_price' => 'required|array',
            'rent_price.*' => 'required|numeric',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric',
        ]);

        if ($data->fails()) {
            return redirect()->back()->withErrors($data)->withInput();
        }

        DB:: BeginTransaction();

        try {
            $package = new PredefinedPackage();
            $package->package_name = $request->package_name;
            $package->category = $request->category;
            $package->package_status = $request->package_status;
            $package->save();

            $package_id = $package->package_id;

            $packageItems = json_decode($request->selected_items);

            foreach ($packageItems as $packageItem) {
                $packageitem = new PredefinedPackageItem();
                $packageitem->predefined_package_id = $package_id;
                $packageitem->item_id = $packageItem->itemId;
                $packageitem->item_name = $packageItem->itemName;
                $packageitem->item_price = $packageItem->rent_price;
                $packageitem->quantity = $packageItem->quantity;

                $packageitem->save();
            }

            DB::commit();
            return redirect()->route('useradmin.predefined.all')->with('success', 'Package created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('useradmin.predefined.all')->with('error', 'Package creation failed');

        }


    }
    //*** FUNCTION TO CHECK PACKAGE NAME */
    function checkpackagename(Request $request)
    {
        $validatedData = $request->validate([
            'packageName' => 'required|string|max:255',
        ]);


        $packageName = $validatedData['packageName'];
        $packageExists = PredefinedPackage::where('package_name', $packageName)->exists();

        return response()->json(['exists' => $packageExists]);
    }
    //** FUNCTION TO CHECK PACKAGE NAME IN EDIT */
    function checkpackagenameedit(Request $request)
    {

        $validatedData = $request->validate([
            'packageName' => 'required|string|max:255',
        ]);


        $packageName = $validatedData['packageName'];
        $packageExists = PredefinedPackage::where('package_name', $packageName)->where('package_id', '!=', $request->packageId)->exists();

        return response()->json(['exists' => $packageExists]);
    }

    //*** FUNCTION TO VIEW ALL PACKAGES ***//
    function allpredefined()
    {
        $packagedata = DB::table('predefined_package')
                        ->orderBy('package_id', 'desc')
                        ->get();
        return view('predefinedpackage.allpackages', ['packagedata' => $packagedata]);
    }

    //*** FUNCTION TO EDIT PACKAGES ***//
    function editpredefined($id)
    {
        $packagedata = PredefinedPackage::where('package_id', $id)->first();
        $predefinedItems = PredefinedPackageItem::where('predefined_package_id', $id)->get();
        $predefinedPackageCategories = PredefinedPackageCategory::all();
        $items = Item::all();
        // Get previous url
        $previousUrl = url()->previous();
        // Check if previous url is useradmin/order/edit
        if (str_contains($previousUrl, 'useradmin/orderitems/view/edit/')) {
            return view('predefinedpackage.editpackagemodel', ['packagedata' => $packagedata, 'predefinedPackageCategories' => $predefinedPackageCategories]);

        }else{
            return view('predefinedpackage.editpackage', ['packagedata' => $packagedata, 'predefinedItems' => $predefinedItems, 'items' => $items, 'predefinedPackageCategories' => $predefinedPackageCategories]);
        }
    }

    //*** FUNCTION TO UPDATE PACKAGES DATA IN DB ***//
    function updatepredefined(Request $request, $id)
    {

        // Check  validation
        $request->validate([
            'package_name' => 'required|string|max:255|unique:predefined_package,package_name,' . $id . ',package_id',
            'category' => 'required|string|max:255',
            'package_status' => 'required|string',
            'package_id' => 'required|numeric|exists:predefined_package,package_id',
            'selected_items' => 'required',
            'selected_items.*.itemId' => 'required|numeric',
            'selected_items.*.itemName' => 'required|string|max:255',
            'selected_items.*.rent_price' => 'required|numeric',
            'selected_items.*.quantity' => 'required|numeric',
            'item_id' => 'nullable|array',
            'item_id.*' => 'nullable|numeric',
            'rent_price' => 'nullable|array',
            'rent_price.*' => 'nullable|numeric',
            'quantity' => 'nullable|array',
            'quantity.*' => 'nullable|numeric',

             // Validation for predefined_* arrays
            'predefined_rentprice' => 'nullable|array',
            'predefined_rentprice.*' => 'nullable|numeric',
            'predefined_quantity' => 'nullable|array',
            'predefined_quantity.*' => 'nullable|numeric',
            'predefined_item_id' => 'nullable|array',
            'predefined_item_id.*' => 'nullable|numeric',
            'old_predefined_package_items' => 'nullable',
            'old_predefined_package_items.*' => 'nullable|numeric',
        ]);

        DB:: BeginTransaction();

        try {
            $package = PredefinedPackage::find($id);
            $package->package_name = $request->package_name;
            $package->category = $request->category;
            $package->package_status = $request->package_status;
            $package->save();

            $oldPredefinedeItems = json_decode($request->old_predefined_package_items);

            if($request->old_predefined_package_items != null){
                foreach ($oldPredefinedeItems as $old_predefined_package_item) {
                    $oldPredefinedPackageItem = PredefinedPackageItem::where('predefined_item_id', $old_predefined_package_item)->first();
                    if($oldPredefinedPackageItem){
                        $oldPredefinedPackageItem->delete();
                    }
                }
            }

            $packageItems = json_decode($request->selected_items);
            $predefinedItems = $request->predefined_item_id;
            $quantity = $request->predefined_quantity;
            $itemPrice = $request->predefined_rentprice;

            $i = 0;
            if ($predefinedItems != null) {
                foreach ($predefinedItems as $predefinedItem) {
                    $predefineditem = PredefinedPackageItem::find($predefinedItem);
                    $predefineditem->quantity = $quantity[$i];
                    $predefineditem->item_price = $itemPrice[$i];
                    $i++;
                    $predefineditem->save();
                }
            }

            if ($packageItems != null) {
                foreach ($packageItems as $packageItem) {
                    $packageitem = new PredefinedPackageItem();
                    $packageitem->predefined_package_id = $id;
                    $packageitem->item_id = $packageItem->itemId;
                    $packageitem->item_price = $packageItem->rent_price;
                    $packageitem->item_name = $packageItem->itemName;
                    $packageitem->quantity = $packageItem->quantity;

                    $packageitem->save();
                }
            }

            DB::commit();
            return redirect()->route('useradmin.predefined.all')->with('success', 'Package updated successfully');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('useradmin.predefined.all')->with('error', 'Package update failed');
        }

    }

    //*** FUNCTION TO DELETE PACKAGES ***//
    function deletepredefined($id)
    {
        $package = PredefinedPackage::find($id);
        $package->delete();
        return redirect()->route('useradmin.predefined.all')->with('success', 'Package deleted successfully');
    }

    // **  FUNCTION TO  VIEW ALL PREDEFINED PACKAGE CATEGORIES ***//
    function categories()
    {

        $categories = DB::table('predefined_package_category')->get();
        return view('predefinedpackage.allcategories', ['categories' => $categories]);
    }

    //*** FUNCTION TO ADD NEW CATEGORIES ***//
    function  addcategory()
    {
        return view('predefinedpackage.createcategory');
    }

    // ** FUNCTION TO SAVE CATEGORIES TO THE DATABASE ***//
    function storecategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|max:255|unique:predefined_package_category,category_name',
        ]);

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

        $category = new PredefinedPackageCategory();
        $category->category_name = $request->categoryName;

        if($category->save()){
            if ($request->ajax()) {
                return response()->json(['message' => 'Category Added Successfully'], 200);
            }

        }
    }

    // *** FUNCTION TO EDIT CATEGORIES ***//
    function editcategory($id)
    {

        $category = PredefinedPackageCategory::find($id);
        return view('predefinedpackage.editcategory', ['category' => $category]);
    }

    // *** FUNCTION TO UPDATE CATEGORIES ***//
    function updatecategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'categoryName' => 'required|max:255|unique:predefined_package_category,category_name,' . $id . ',category_id',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = PredefinedPackageCategory::find($id);
        $category->category_name = $request->categoryName;

        if($category->save()){
            if ($request->ajax()) {
                return response()->json(['message' => 'Category Updated Successfully'], 200);
            }
        }
    }

    // *** FUNCTION TO DELETE CATEGORIES ***//
    function deletecategory($id)
    {

        $category = PredefinedPackageCategory::find($id);
        $category->delete();
        return redirect()->route('useradmin.predefined.categories')->with('success', 'Category deleted successfully');
    }

    //*** FUNCTION TO REMOVE ITEMS FROM PACKAGES ***//
    function deletepredefineditem(Request $request)
    {
        $id = $request->itemId;
        $packageitem = PredefinedPackageItem::find($id);
        $packageitem->delete();
        return response()->json(['success' => 'Item removed successfully.']);
    }

    //*** FUNCTION TO GET ALL PREDEFINED PACKAGE ITEMS THROUGH AJAX REQUEST ***//
    function predefinedpackageitems(Request $request)
    {
        $id = $request->predefined_package_id;
        $predefinedItems = DB::table('predefined_package_item')->where('predefined_package_id', $id)->get();
        return response()->json(['predefinedItems' => $predefinedItems]);
    }

    //** FUNCTION TO GET ALL PREDEFINED PACKAGE ITEMS AND ITEMS PRICES THROUGH AJAX REQUEST */
    function orderPredefinedPackage(Request $request)
    {
        $id = $request->predefinedPackageId;
        $predefinedItems = DB::table('predefined_package_item')->where('predefined_package_id', $id)->get();
        if(empty($predefinedItems)){
            return response()->json(['predefinedItems' => $predefinedItems]);
        }
        foreach ($predefinedItems as $predefinedItem) {
            $item = Item::where('item_id', $predefinedItem->item_id)->first();
            $predefinedItem->category = $item->category;
        }

        return response()->json(['predefinedItems' => $predefinedItems]);
    }

}
