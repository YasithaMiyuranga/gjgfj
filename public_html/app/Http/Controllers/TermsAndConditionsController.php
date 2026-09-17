<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsAndConditions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TermsAndConditionsController extends Controller
{
public function create()
{
   return view('order.addTermsAndConditions');
}


public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:terms_and_conditions', 
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
           if ($request->ajax()) {
               return response()->json([
                   'errors' => $validator->errors()
               ], 422);
           }
        }else {
            $validatedData = $validator->validated();
        }

        TermsAndConditions::create($validatedData);

        if($request->ajax()) {
            return response()->json(['message' => 'Terms & Conditions Add successfully!'], 200);
        }
    }

    public function viewTermsAndConditions()
    {
        $viewTermsAndConditions = TermsAndConditions::all();
        return view('order.viewTermsAndConditions', compact('viewTermsAndConditions'));
    }

    public function delete($id)
    {
        $termsCondition = TermsAndConditions::findOrFail($id);
        $termsCondition->delete();

        return redirect()->route('useradmin.viewTermsAndConditions')->with('success', 'Terms & Conditions deleted successfully.');
    }


    public function edit($id)
    {
        $termsCondition = TermsAndConditions::find($id);

        if ($termsCondition) {
            return view('order.editTermsAndConditions', compact('termsCondition'));
        } else {
            return redirect()->route('useradmin.viewTermsAndConditions')->with('error', 'Record not found.');
        }
    }



    public function updates(Request $request, $id)
{
    try {
        // Find the record
        $termsCondition = TermsAndConditions::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
         }else {
             $validatedData = $validator->validated();
         }

        // Update the record
        $termsCondition->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        // Handle success response
        if ($request->ajax()) {
            return response()->json(['message' => 'Terms & Conditions updated successfully!'], 200);
        }


    } catch (\Exception $e) {
        // Handle errors
        if ($request->ajax()) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}
}
