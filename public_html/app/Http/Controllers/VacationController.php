<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    /**
     * Show the list of vacations for the current employee.
    */
    public function index()
    {
        // Get the current employee
        $employee = Auth::guard('employee')->user();
        // Get all the vacations for the current employee
        $vacations = Vacation::where('emp_id', $employee->emp_id)->get();
        // Pass the vacations to the view
        return view('employee.Vacation.index', compact('vacations'));
    }

    /**
     * Show the form for creating a new request for vacation.
     */
    public function create()
    {
        return view('employee.Vacation.create');
    }

    /**
     * Store a newly created vacation request in database.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = $request->validate([
            'get_date' => 'required|date',
            'return_date' => 'required|date|after:get_date',
            'reason' => 'required|string|max:255',
            'status' => 'required|string|in:pending',
        ]);

        // Create a new vacation request
        $data = [
            'emp_id' => Auth::guard('employee')->user()->emp_id,
            'get_date' => $validator['get_date'],
            'return_date' => $validator['return_date'],
            'reason' => $validator['reason'],
            'status' => $validator['status'],
        ];

        // Save the new vacation request
        $vacation = Vacation::create($data);

        if ($vacation) {
            // Return a success message if the request is AJAX
            if ($request->ajax()) {
                return response()->json(['message' => 'Vacation request submitted successfully!'], 200);
            }
        } else {
            // Return an error message if the request is AJAX
            if ($request->ajax()) {
                return response()->json(['error' => 'Vacation request failed!'], 500);
            }
        }
    }

    /**
     * Show the form for editing the specified vacation request.
     */
    public function edit(Vacation $vacation)
    {
        // Get previous url
        $previousUrl = url()->previous();

        // Check if previous url is useradmin/employee/vacation
        if (str_contains($previousUrl, 'useradmin/employee/vacations')) {
            return view('employee.vacations_edit', compact('vacation'));
        }
        else{
            return view ('employee.Vacation.edit', compact('vacation'));
        }
    }

    /**
     * Update the specified vacation request in database.
     */
    public function update(Request $request, Vacation $vacation)
    {
        // Validate the request
        $validator = $request->validate([
            'get_date' => 'required|date',
            'return_date' => 'required|date|after:get_date',
            'reason' => 'required|string|max:255',
           'status' => 'required|string|in:pending,approved,rejected',
        ]);
        // Update the vacation request
        $data = [
            'get_date' => $validator['get_date'],
            'return_date' => $validator['return_date'],
            'reason' => $validator['reason'],
            'status' => $validator['status'],
        ];
        // Save the updated vacation request
        $vacation->update($data);

        if( $vacation){
            if($request->ajax()) {
                return response()->json(['message' => 'Vacation request updated successfully!'], 200);
            }
        }
        else{
            if($request->ajax()) {
                return response()->json(['error' => 'Vacation request failed!'], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vacation $vacation)
    {
        // Delete the vacation request
        $vacation->delete();
        return redirect()->back()->with('success', 'Vacation request deleted successfully!');
    }

    /**
     * Display all employees vacations
     *
     * @return \Illuminate\Http\Response
     */
    public function vacationView(){
        // All Vacations
        $vacations = Vacation::all();
        // Employee name associated with the vacations
        foreach ($vacations as $vacation) {
            $employee = Employe::where('emp_id', $vacation->emp_id)->first();
            $vacation->emp_name = $employee->name;
        }
        return view('employee.vacations', compact('vacations'));
    }
}
