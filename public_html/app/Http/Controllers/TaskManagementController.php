<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskManagementController extends Controller
{
    public function showTaskManagement()
    {
        // Return the 'Admin.task_management' view
        return view('Admin.task_management');
    }

    public function showTaskManagementEmployee()
    {
        // Return the 'emplyee.task_management' view
        return view('employee.employer_task_management');
    }
}
