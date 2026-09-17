<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee.permissions_view', [
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.permissions_create');
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            } else {
                // Handle non-AJAX request validation failure
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } else {
            $validatedData = $validator->validated();
            // Create a new permission
            Permission::create($validatedData);

            if ($request->ajax()) {
                return response()->json(['message' => 'Permission Add successfully!'], 200);
            } else {
                // Handle non-AJAX request success
                return redirect()->route('useradmin.permissions.index')->with('success', 'Permission added successfully!');
            }
        }
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('employee.permissions_edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            } else {
                // Handle non-AJAX request validation failure
                return redirect()->back()->withErrors($validator)->withInput();
            }
        } else {
            $validatedData = $validator->validated();
            // Update the permission
            $permission->update($validatedData);

            if ($request->ajax()) {
                return response()->json(['message' => 'Permission updated successfully!'], 200);
            } else {
                // Handle non-AJAX request success
                return redirect()->route('useradmin.permissions.index')->with('success', 'Permission updated successfully!');
            }
        }
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success', 'Permission deleted successfully!');
    }
}
