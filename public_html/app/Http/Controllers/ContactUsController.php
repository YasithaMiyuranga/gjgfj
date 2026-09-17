<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{

    //This controller Use for the and admin and user both
    public function store(Request $request) {

        // Validation rules
        $rules = [
            'firstName' => 'required|string|max:255', // Example rules
            'lastName' => 'required|string|max:255', // Example rules
            'telephone' => 'required|string|max:255', // Example rules
            'email' => 'required|string|max:255', // Example rules

            // Add more validation rules as needed
        ];

        // Custom error messages
        $messages = [
            'firstName' => 'Frist Name Require', // Example rules
            'lastName' => 'Last Name is required.', // Example rules
            'telephone' => 'Mobile No is required.', // Example rules
            'email' => 'Email is required.',
            // Add more custom messages as needed
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If validation passes, proceed to save the data
        $data = [
            'customer_name' => $request->input('firstName') . ' ' . $request->input('lastName'),
            'telephone' => $request->input('telephone'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'status' => '1',
           

            // Map other fields as necessary
        ];

        Contactus::create($data);

        return redirect()->route('contactus')->with('success', 'Contact Us Add successfully!');   
    }
}
