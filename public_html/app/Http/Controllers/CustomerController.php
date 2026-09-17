<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function create()
    {
        return view('Admin.addcustomer');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'customer_phone' => 'required|regex:/^[0-9]{10}$/|unique:customer,customer_phone',
            'location' => 'nullable|string|max:255',
            'nic' => ['nullable', 'unique:customer,nic', 'string', 'regex:/^(\d{9}[VX]|\d{12})$/'],
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'register_date' => 'nullable|date',
        ]);


        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // HTTP status code for unprocessable entity
            }
        } else {
            $validatedData = $validator->validated();
        }

        Customer::create($validatedData);

        if ($request->ajax()) {
            return response()->json(['message' => 'Customer Add successfully!'], 200);
        }
    }

    public function viewcustomer()
    {
        $viewcustomers = Customer::orderBy('created_at', 'DESC')->get();
        return view('Admin.viewcustomer', compact('viewcustomers'));
    }

    public function delete($id)
    {

        $customer = Customer::findOrFail($id);


        try {
            $customer->delete();
        } catch (\Exception $e) {
            return redirect()->route('useradmin.viewcustomer')->with('error', 'This Customer Cannot Be deleted.');
        }

        return redirect()->route('useradmin.viewcustomer')->with('success', 'Customer deleted successfully.');
    }


    public function edit($customer_id)
    {
        $customer = DB::table('customer')->where('customer_id', $customer_id)->first();

        if ($customer) {
            return view('Admin.editcustomer', compact('customer'));
        } else {

            return redirect()->route('useradmin.viewcustomer');
        }
    }


    public function updates(Request $request, $customer_id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'customer_phone' => 'required|regex:/^[0-9]{10}$/|unique:customer,customer_phone,' . $customer_id . ',customer_id',
            'location' => 'nullable|string|max:255',
            'nic' => ['nullable', 'string', 'regex:/^(\d{9}[VX]|\d{12})$/', 'unique:customer,nic,' . $customer_id . ',customer_id'],
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'register_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        } else {
            $affected = DB::table('customer')
                ->where('customer_id', $customer_id)
                ->update([
                    'customer_id' => $request->input('customer_id'),
                    'customer_name' => $request->input('customer_name'),
                    'company_name' => $request->input('company_name') ?? null,
                    'customer_phone' => $request->input('customer_phone'),
                    'location' => $request->input('location'),
                    'nic' => $request->input('nic'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'points' => $request->input('points'),
                    'status' => $request->input('status'),
                    'register_date' => $request->input('register_date'),


                ]);

            if ($affected > 0) {
                return back()->with('success', 'Data updated successfully');
            } else {
                return back()->with('error', 'Data not updated');
            }
        }
    }

}
