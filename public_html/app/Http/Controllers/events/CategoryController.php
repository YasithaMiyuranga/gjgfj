<?php

namespace App\Http\Controllers\events;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{

    //*** FUNCTION LIST OF ALL CATEGORIES */
    public function category_list()
    {
        $categories = Category::all();
        return view('Admin_events.category.index', compact('categories'));
    }

    /*** FUNCTION  TO CREATE A CATEGORY */
    public function category_create()
    {
        return view('Admin_events.category.add');
    }

    //*** FUNCTION TO STORE A CATEGORY */
    public function category_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:category|max:100',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // HTTP status code for unprocessable entity
            }
        }

        $category = new Category();
        $category->category_name = $request->category_name;

        if ($category->save()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Category added successfully.'], 200);
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['message' => 'Failed to add Category.'], 500);
            }

        }
    }

    public function category_store_and_get_recent(Request $request)
{
    $validator = Validator::make($request->all(), [
        'category_name' => 'required|string|max:100|unique:category,category_name',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors(),
        ], 422);
    }

    $category = Category::where('category_name', $request->category_name)->first();

    if ($category) {
        return response()->json([
            'success' => false,
            'message' => 'Category already exists.',
        ], 200);
    }

    $category = new Category();
    $category->category_name = $request->category_name;
    $category->save();

    return response()->json([
        'success' => true,
        'id' => $category->id,
        'category_name' => $category->category_name,
        'message' => 'Category added successfully.',
    ], 200);
}


    //** FUNCTION TO EDIT A SPECIFIC CATEGORY */
    public function category_edit($id)
    {
        $category = Category::where('id', '=', $id)->first();

        return view('Admin_events.category.edit', compact('category'));
    }

    //*** FUNCTI0N TO UPDATE A SPECIFIC CATEGORY */
    public function category_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:category,category_name,' . $id,
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // HTTP status code for unprocessable entity
            }
        }

        // Retrieve the category record from the database
        $category = Category::where('id', '=', $id)->first();

        if (!$category) {
            return redirect()->route('useradmin.events.category')->with('error', 'Category not found.');
        }

        $category->update([
            'category_name' => $request->category_name,
        ]);

        if ($category->wasChanged()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Category updated successfully.'], 200);
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['message' => 'Failed to update Category.'], 500);
            }
        }
    }

    public function category_delete_view($id)
    {
        return view('Admin_events.category.delete', compact('id'));
    }


    //*** FUNCTION TO DELETE CATEGORY IN THE SYSTEM ***/
    function category_delete($id)
    {
        $category = Category::where('id', '=', $id)->first();

        // Check if category is being used in any events
        if ($category->events()->count() > 0) {
            return redirect()->route('useradmin.events.category')->with('error', 'Cannot delete category. It is being used in one or more events.');
        }

        $category->delete();

        return redirect()->route('useradmin.events.category')->with('success', 'Category deleted successfully!');
    }
}
