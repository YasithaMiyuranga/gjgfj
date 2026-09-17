<?php

namespace App\Http\Controllers;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ItemCategoryController extends Controller
{
    // *** ITEM CATEGORY VIEW ***//
    public function viewCategory()
    {
        $categories = ItemCategory::all();
        return view('item.category.index', compact('categories'));
    }

    // *** ITEM CATEGORY CREATE ***//
    public function addCategory()
    {
        return view('item.category.addcategory');
    }

    // *** ITEM CATEGORY STORE ***//
    public function storeCategory(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:item_categories,name',
            'status' => 'required|in:active,inactive',
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

        // Create the new category in the database
        ItemCategory::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        // For AJAX requests, return success response
        if ($request->ajax()) {
            return response()->json(['message' => 'Category Added Successfully'], 200); // HTTP status 200 for success
        }

    }


    // *** ITEM CATEGORY EDIT ***//
    public function editCategory($id)
    {

        $category = ItemCategory::where('id', $id)->first();
        return view('item.category.editcategory', compact('category'));
    }

    // *** ITEM CATEGORY UPDATE ***//
    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:item_categories,name,' . $id . 'id',
            'status' => 'required|in:active,inactive',

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


        $category = ItemCategory::where('id', $id)->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        if($category){
            if ($request->ajax()) {
                return response()->json(['message' => 'Category Updated Successfully'], 200); // HTTP status 200 for success
            }
        }

    }

    // *** ITEM CATEGORY DELETE ***//
    public function deleteCategory( $id)
    {

        $category = ItemCategory::where('id', $id)->delete();
        if($category){
            return redirect()->back()->with('success', 'Category Deleted Successfully');
        }
        else{
            return redirect()->back()->with('error', 'Category Not Found');
        }

    }
}
