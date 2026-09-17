<?php

namespace App\Http\Controllers;

use App\Models\AgreementCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AgreementCategoryController extends Controller
{

    /**
     * Display a Categories list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('Agreement.categories.index', [
           'categories' => AgreementCategory::all()
       ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('Agreement.categories.create');
    }

    /**
     * Store a newly created category to the database.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:agreement_categories',
            'description' => 'nullable|string|max:255',
        ]);

        // If the validation fails, return the errors
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return the errors in JSON format
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
        }else {
            // Get the validated data
            $validatedData = $validator->validated();
        }

        // Create a new Agreement Category
        AgreementCategory::create($validatedData);

        // Return a success message if the request is an AJAX request
        if($request->ajax()) {
            return response()->json(['message' => 'Agreement Category Add successfully!'], 200);
        }
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(AgreementCategory $agreementCategory)
    {
        return view('Agreement.categories.edit', compact('agreementCategory'));
    }

    /**
     * Update the specified category in the database.
     */
    public function update(Request $request, AgreementCategory $agreementCategory)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        // If the validation fails, return the errors
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return the errors in JSON format
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
         }else {
             // Get the validated data
             $validatedData = $validator->validated();
         }

        // Update the Agreement Category
        $agreementCategory->update($validatedData);

        // Return a success message if the request is an AJAX request
        if($request->ajax()) {
            return response()->json(['message' => 'Agreement Category Update successfully!'], 200);
        }
    }

    /**
     * Remove the specified category from the database.
     */
    public function destroy(AgreementCategory $agreementCategory)
    {
        try{
            $agreementCategory->delete();
            return redirect()->back()->with('success', 'Agreement Category deleted successfully!');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', 'Agreement Category assigned to an agreement template cannot be deleted.');
        }
    }
}
