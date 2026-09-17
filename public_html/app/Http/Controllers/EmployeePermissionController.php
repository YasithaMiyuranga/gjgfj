<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\EmployeePermission;
use Illuminate\Support\Facades\Validator;


class EmployeePermissionController extends Controller
{

    /**
     * Display the form for creating a new Or Update employee permission.
     *
     * @param  int  $emp_id
     * @return \Illuminate\Http\Response
     */
    public function create($emp_id)
    {
        $employe = Employe::find($emp_id);
            return view('employee.employee_permission_create', [
                'employe' => $employe,
                'permissions' => Permission::all(),
                'assignedPermissions' => EmployeePermission::where('employee_id', $emp_id)->pluck('permission_id')->toArray()
            ]);
    }
    /**
     * Store the newly assigned permissions for an employee.
     *
     * Validates the incoming request data to ensure that the employee ID and
     * permissions array are present and correctly formatted. If validation fails,
     * returns an appropriate error response for AJAX or non-AJAX requests.
     *
     * Deletes any existing permissions for the employee and assigns the new set
     * of permissions provided in the request. Records the admin user who made the
     * changes.
     *
     * Returns a success message upon successful assignment of permissions, with
     * different handling for AJAX and non-AJAX requests.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_id' => 'required|integer',
            'permissions' => 'required|array',
            'permissions.*' => 'integer',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        // Admin user
        $admin = auth()->user();
        // Check existing permissions
        EmployeePermission::where('employee_id', $request->emp_id)->delete();

        foreach ($request->permissions as $permission_id) {
            $employeePermission = new EmployeePermission();
            $employeePermission->admin_id = $admin->id;
            $employeePermission->employee_id = $request->emp_id;
            $employeePermission->permission_id = $permission_id;
            $employeePermission->save();
        }

        if($request->ajax()){
            return response()->json([
                'message' => 'Permissions assigned successfully'
            ]);
        }else{
            return redirect()->route('useradmin.viewemployee')->with('success', 'Permissions assigned successfully');
        }
    }
}
