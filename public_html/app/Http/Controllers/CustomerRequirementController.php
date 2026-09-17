<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerRequirement;
use App\Http\Controllers\Controller;
use App\Services\CustomerDataExtractor;
use Illuminate\Support\Facades\Validator;

class CustomerRequirementController extends Controller
{
    /**
     * Customer Requirement List
     *
     * @return \Illuminate\Http\Response
     */
    public function customerRequirement() {
    }

    public function customerRequirementCreate() {
        return view('Admin.addcustomerrequirement');
    }

    /**
     * Store a newly created customer requirement in database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function customerRequirementStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
        }
        else{
            $validatedData = $validator->validated();
        }

        // Create a new customer requirement
        CustomerRequirement::create($validatedData);

        // Redirect back with success message
        if ($request->ajax()) {
            return response()->json(['message' => 'Customer requirement created successfully!'], 200);
        }
    }

    /**
     * Edit the specified customer requirement in database.
     *
     * @param \App\Models\customerRequirement $customerRequirement
     * @return \Illuminate\Http\Response
     */
    public function customerRequirementEdit(customerRequirement $customerRequirement) {
        return view('Admin.editcustomerrequirement', compact('customerRequirement'));
    }
    /**
     * Update the specified customer requirement in database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\customerRequirement $customerRequirement
     * @return \Illuminate\Http\Response
     */
    public function customerRequirementUpdate(Request $request, customerRequirement $customerRequirement) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
        }
        else{
            $validatedData = $validator->validated();
        }

        // Update the customer requirement
        $customerRequirement->update($validatedData);

        // Redirect back with success message
        if ($request->ajax()) {
            return response()->json(['message' => 'Customer requirement updated successfully!'], 200);
        }
    }
    /**
     * Remove the specified customer requirement from database.
     *
     * @param \App\Models\customerRequirement $customerRequirement
     * @return \Illuminate\Http\Response
     */
    public function customerRequirementDelete(customerRequirement $customerRequirement) {
        $customerRequirement->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Customer requirement deleted successfully!');
    }

    /**
     * Parse customer details from a message.
     *
     * This endpoint is intended to be called via AJAX. It takes a JSON payload
     * with a single key-value pair, 'message', which contains the message to be
     * parsed. The endpoint returns a JSON response with the parsed customer
     * details.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parseCustomerDetails(Request $request) {
        // Retrieve the message from the request
        $message = $request->json()->get('message');

        // Initialize the CustomerDataExtractor service
        $extractor = new CustomerDataExtractor();

        // Extract customer data from the message
        $data = $extractor->extractFromMessage($message);

        // Return the extracted data as a JSON response
        return response()->json($data);
    }

    public function parseEventDetails(Request $request) {
        // Retrieve the message from the request
        $message = $request->json()->get('message');

        // Initialize the CustomerDataExtractor service
        $extractor = new CustomerDataExtractor();

        // Extract customer data from the message
        $data = $extractor->extractEventFromMessage($message);

        // Return the extracted data as a JSON response
        return response()->json($data);
    }
}
