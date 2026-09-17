<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Mail\Email;
use App\Models\Loan;
use App\Models\Rent;
use App\Models\Order;
use App\Models\Employe;
use App\Models\Customer;
use App\Models\JobAmount;
use App\Models\OrderBook;
use App\Models\AdminEvent;
use App\Models\EmpPayment;
use App\Http\Helper\Helper;
use App\Mail\EmployeeEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MonthlySalary;
use App\Models\EmployeeCredit;
use App\Models\AdditionalExpense;
use App\Models\EmployeePermission;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\CashFlowHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    function dashboard()
    {

        // Find employeer details
        $emp = DB::table('employes')->where('emp_id', Auth::guard('employee')->user()->emp_id)->first();

        // Get today's date
        $today = Carbon::today()->toDateString();

        // Find employer assigned booking all orders count
        $allEventsCount = Order::where(function ($query) use ($emp) {
            $query->whereRaw("FIND_IN_SET(?, name)", [$emp->name])
                ->where('order_status', '=', 'booking');
        })->count();


        // Find employer assigned booking orders for events for today
        $todayEvents = Order::where(function ($query) use ($emp, $today) {
            $query->whereRaw("FIND_IN_SET(?, name)", [$emp->name])
                ->where('order_status', '=', 'booking')
                ->whereDate('start_time', '=', $today);
        })->get();

        // Today events count
        $todayEventsCount = count($todayEvents);

        // Find employer assigned booking orders for events upcoming
        $eventsUpcoming = Order::where(function ($query) use ($emp, $today) {
            $query->whereRaw("FIND_IN_SET(?, name)", [$emp->name])
                ->where('order_status', '=', 'booking')
                ->whereDate('start_time', '>', $today);
        })->get();

        // Upcoming events count
        $upcomingEventsCount = count($eventsUpcoming);

        // Find today events start_time and end_time
        foreach ($todayEvents as $event) {
            $todayEvents->start_time = $event->start_time;
            $todayEvents->end_time = $event->end_time;

        }

        // Find upcoming events start_time and end_time
        foreach ($eventsUpcoming as $eventUpcoming) {
            $eventsUpcoming->start_time = $eventUpcoming->start_time;
            $eventsUpcoming->end_time = $eventUpcoming->end_time;

        }

        // Get employee assigned order include additional expenses
        $additionalExpenseOrders = Order::where(function ($query) use ($emp) {
            $query->whereRaw("FIND_IN_SET(?, name)", [$emp->name])
                ->where('order_status', '=', 'booking');
        })->with('additional_expenses')->get();


        // Get Pending job amount
        $pendingJobAmounts = JobAmount::where('emp_id', Auth::guard('employee')->user()->emp_id)->where('payment_status', '=', 'pending')->get();

        // Retrieve event names for pending job amount
        foreach ($pendingJobAmounts as $pendingJobAmount) {
            $order = DB::table('order')->where('order_id', $pendingJobAmount->order_id)->first();
            if($order) {
                $pendingJobAmount->event_name = $order->event_name;
                $pendingJobAmount->event_date = $order->start_time;
            }
        }
        // Assigned rent items
        $rents = Rent::where('employee_id', $emp->emp_id)->get();
        return view('employee.dashboard', ['todayEvents' => $todayEvents, 'eventsUpcoming' => $eventsUpcoming, 'pendingJobAmounts' => $pendingJobAmounts, 'allEventsCount' => $allEventsCount, 'todayEventsCount' => $todayEventsCount, 'upcomingEventsCount' => $upcomingEventsCount, 'rents' => $rents, 'additionalExpenseOrders' => $additionalExpenseOrders]);
    }

    //** FUNCTION TO VIEW EMPLOYEE PROFILE*/
    public function profile(Request $request)
    {
        // Find employeer details
        if (Auth::guard('employee')->check()) {
            $emp_id = Auth::guard('employee')->user()->emp_id;
        }
        $emp = DB::table('employes')->where('emp_id', $emp_id)->first();
        return view('employee.profile', ['emp' => $emp]);
    }
    // ** FUNCTION TO UPDATE EMPLOYEE PROFILE*/
    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|exists:employes,email',
            'mobile' => 'nullable|regex:/^[0-9]{10}$/',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg,jfif',
            'emp_type' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employee = Auth::guard('employee')->user();

        DB::beginTransaction();

        try {
            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                if ($employee->profile_image) {
                    $image_path = public_path($employee->profile_image);

                    if (file_exists($image_path)) {
                        unlink($image_path); // Remove existing image
                    }
                }
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $path = Helper::getFileUrl($request->image, 'uploads/employees/');
                $employee->profile_image = $path;
            }

            // Fetch related data
            // $ExistNameAssignedorders = Order::where('name', 'like', "%{$employee->name}%")->get();  // When same name included two employee problem that update
            // $ExistNameAssignedorderBooks = OrderBook::where('name', $employee->name)->get();
            $ExistsJobAmounts = JobAmount::where('name', $employee->name)->where('emp_id', $employee->emp_id)->get();
            $existEmpPayements = DB::table('emp_payments')->where('name', $employee->name)->where('emp_id', $employee->emp_id)->get();
            $existMontlysalary = MonthlySalary::where('name', $employee->name)->where('emp_id', $employee->emp_id)->get();
            $existLoan = Loan::where('name', $employee->name)->where('emp_id', $employee->emp_id)->get();

            // Update employee profile details
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'emp_type' => $request->emp_type,
            ]);

            // // Update related records
            // foreach ($ExistNameAssignedorders as $order) {
            //     $order->update(['name' => $request->name]);
            // }

            // foreach ($ExistNameAssignedorderBooks as $orderBook) {
            //     $orderBook->update(['name' => $request->name]);
            // }

            foreach ($ExistsJobAmounts as $jobAmount) {
                $jobAmount->update(['name' => $request->name]);
            }

            foreach ($existEmpPayements as $payment) {
                DB::table('emp_payments')->where('id', $payment->id)->update(['name' => $request->name]);
            }

            foreach ($existMontlysalary as $salary) {
                $salary->update(['name' => $request->name]);
            }

            foreach ($existLoan as $loan) {
                $loan->update(['name' => $request->name]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Profile Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Profile not updated. Error: ' . $e->getMessage());
        }
    }


    //** FUNCTION TO CHANGE EMPLOYEE PASSWORD  */
    public function updatepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'string|required',
            'new_password' => 'string|required|min:8|Max:255',
            'confirm_password' => 'string|required|min:8|same:new_password',
            'email' => 'email|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //check seasion through find employee
        if (Auth::guard('employee')->check()) {
            $emp_id = Auth::guard('employee')->user()->emp_id;
        }

        // Get the currently authenticated user
        $employee = Employe::find($emp_id);


        // Check if the provided old password matches the stored hashed password
        if (!Hash::check($request->old_password, $employee->password)) {

            // Redirect back with error message display in tab
            return redirect()->back()->with('error', 'The provided password does not match your current password.');
        }

        $data['new_password'] = Hash::make($request->new_password);
        //update employee password
        $employee->update([
            'password' => $data['new_password']
        ]);

        return redirect()->back()->with('success', 'Password Updated Successfully');
    }


    public function empregister()
    {
        $employeeTypes = DB::table('employes')->get();
        return view('employee.register', ['employeeTypes' => $employeeTypes]);
    }


    //** FUNTION TO CREATE EMPLOYEE BY ADMIN */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'email' => 'email|required',
            'password' => 'string|required',
            'code' => 'nullable',
            'active' => 'nullable',
            'regdate' => 'nullable',
            'created_by' => 'string|nullable',
            'updated_by' => 'string|nullable',
            'emp_type' => 'string|required',
            'basic_amount' => 'required',
            'etf' => 'required',
            'epf' => 'required',

        ]);

        $data['password'] = Hash::make($request->password);
        Employe::create($data);

        $userType = Auth::guard('admin');
        if ($userType->check()) {
            return redirect()->route('useradmin.dashboard')->with('success', 'Employee created successfully!');
        } else {
            return redirect()->route('emp.emplogin')->with('success', 'Employee created successfully.');
        }
    }

    public function emplogin()
    {

        return view('employee.login');
    }



    public function viewemp()
    {
        $viewemployees = Employe::orderBy('created_at', 'desc')->get();
        return view('Admin.viewemp', compact('viewemployees'));
    }

    public function delete($id)
    {

        $employee = Employe::where('emp_id', $id)->first();
        if (!$employee) {
            return redirect()->route('useradmin.viewemployee')->with('error', 'Employee not found.');
        }

            try{
                $employee->delete();
            }catch(\Exception $e){
                 return redirect()->route('useradmin.viewemployee')->with('error', 'Employee cant be deleted.');
            }


        return redirect()->route('useradmin.viewemployee')->with('success', 'Employee deleted successfully.');
    }

    public function edit($id)
    {
        $employes = DB::table('employes')->where('emp_id', $id)->first();

        if ($employes) {
            return view('Admin.editemployee', compact('employes'));
        } else {

            return redirect()->route('useradmin.viewemployee');
        }
    }
    // Employee etf epf calculation
    public function emp_etf_epf_calculate($etf, $epf, $employee_epf, $basic_amount)
    {

        // 8%
        $employee_con_epf_amount = $basic_amount * $employee_epf * 0.01;
        // 12%
        $employer_con_epf_amount = $basic_amount * $epf * 0.01;
        // 3%
        $employer_con_etf_amount = $basic_amount * $etf * 0.01;
        // Total Employer Contribution(12% + 3%)
        $total_employer_con = $employer_con_epf_amount + $employer_con_etf_amount;
        // Net Salary
        $net_salary = $basic_amount - $employee_con_epf_amount;

        return [
            'employee_con_epf_amount' => $employee_con_epf_amount,
            'employer_con_epf_amount' => $employer_con_epf_amount,
            'employer_con_etf_amount' => $employer_con_etf_amount,
            'total_employer_con' => $total_employer_con,
            'net_salary' => $net_salary
        ];

    }

    public function updates(Request $request, $id)
    {


        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'required|max:255',
            'nic' => ['required','string','regex:/^(\d{9}[VX]|\d{12})$/'],
            'code' => 'required',
            'active' => 'required',
            'regdate' => 'required|date',
            'emp_type' => 'string|required',
            'password' => 'string|nullable',
            'basic_amount' => $request->emp_type === 'Day Salary Employee' ? 'null' : 'required',
            'etf' => $request->emp_type === 'Day Salary Employee' ? 'null' : 'required',
            'epf' => $request->emp_type === 'Day Salary Employee' ? 'null' : 'required',
            'epf_employee' => $request->emp_type === 'Day Salary Employee' ? 'null' : 'required',

        ]);

            // //if employee type is permanent employee then  etf, epf, employee_epf, basic_amount filed is required
            // if ($request->emp_type === 'Permanent Employee') {
            //     $data['basic_amount'] = $request->basic_amount;
            //     $data['etf'] = $request->etf;
            //     $data['epf'] = $request->epf;
            //     $data['epf_employee'] = $request->epf_employee;
            // }


        // Check employee id check
        if (!Employe::where('emp_id', $id)->exists()) {
            return redirect()->back()->with('error', 'Employee id does not exist.');
        }
        // Check employee email
        if (Employe::where('email', $request->email)->where('emp_id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Updated email already exists.');
        }
        // check employee name
        if (Employe::where('name', $request->name)->where('emp_id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Updated name already exists.');
        }
        // Password had change
        if ($data['password'] != null && $data['password'] != '' && $data['email'] != '') {

            $orginalPassword = $data['password'];
            $email = $data['email'];

            // Send password and login email to the employeer email
            Mail::to($email)->send(new EmployeeEmail($data, $orginalPassword));

        }
        // Email Change but password field is empty
        if ($data['password'] == null && $data['email'] != '') {

            $email = $data['email'];
            // Check email is employee email or not
            if (Employe::where('emp_id', $id)->where('email', '!=', $data['email'])) {

                // Random password
                $randomPassword = Str::random(8);
                // Send password and login email to the employeer email
                Mail::to($email)->send(new EmployeeEmail($data, $randomPassword));

                $data['password'] = $randomPassword;


            }

        }



        if ($data['emp_type'] == 'Permanent Employee') {
            // Get etf, epf, employee_epf , basic_amount
            $etf = $request->etf;
            $epf = $request->epf;
            $employee_epf = $request->epf_employee;
            $basic_amount = $request->basic_amount;

            // Call the function to calculate etf, epf, employee_epf
            $calculated_data = $this->emp_etf_epf_calculate($etf, $epf, $employee_epf, $basic_amount);
            // Access the returned data
            $employee_con_epf_amount = $calculated_data['employee_con_epf_amount'];
            $employer_con_epf_amount = $calculated_data['employer_con_epf_amount'];
            $employer_con_etf_amount = $calculated_data['employer_con_etf_amount'];
            $total_employer_con = $calculated_data['total_employer_con'];
            $net_salary = $calculated_data['net_salary'];

            $data['net_salary'] = $net_salary;
            $data['employer_con_total_amount'] = $total_employer_con;
            $data['employer_con_epf_amount'] = $employer_con_epf_amount;
            $data['employer_con_etf_amount'] = $employer_con_etf_amount;
            $data['employee_epf'] = $employee_epf;
            $data['employee_con_epf_amount'] = $employee_con_epf_amount;
        }

        $affected = DB::table('employes')
            ->where('emp_id', $id)
            ->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'] != null ? Hash::make($data['password']) : null,
                'mobile' => $data['mobile'],
                'address' => $data['address'],
                'nic' => $data['nic'],
                'code' => $data['code'],
                'active' => $data['active'],
                'regdate' => $data['regdate'],
                'emp_type' => $data['emp_type'],
                'basic_amount' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['basic_amount'],
                'etf' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['etf'],
                'epf' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['epf'],
                'employee_epf' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['epf_employee'],
                'employer_con_total_amount' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['employer_con_total_amount'],
                'employer_con_epf_amount' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['employer_con_epf_amount'],
                'employer_con_etf_amount' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['employer_con_etf_amount'],
                'employee_con_epf_amount' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['employee_con_epf_amount'],
                'net_salary' => $data['emp_type'] === 'Day Salary Employee' ? null : $data['net_salary'],
            ]);

        if ($affected > 0) {
            return back()->with('success', 'Data updated successfully');
        } else {
            return back()->with('error', 'Data not updated');
        }
    }


    public function create()
    {
        return view('Admin.addemployee');
    }

    public function check_emp_name(Request $request)
    {
        $name = $request->name;
        $check = Employe::where('name', $name)
            ->first();

        if ($check) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function check_emp_email(Request $request)
    {
        $email = $request->email;
        $check = Employe::where('email', $email)
            ->first();

        if ($check) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function empstore(Request $request)
    {

        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'required|max:255',
            'password' => 'string|required',
            'nic' => ['nullable','string','regex:/^(\d{9}[VX]|\d{12})$/'],
            'code' => 'nullable',
            'active' => 'nullable',
            'regdate' => 'nullable',
            'created_by' => 'string|nullable',
            'updated_by' => 'string|nullable',
            'emp_type' => 'string|required',
            'basic_amount' => $request->emp_type === 'Day Salary Employee' ? 'nullable' : 'required',
            'etf' => $request->emp_type === 'Day Salary Employee' ? 'nullable' : 'required',
            'epf' => $request->emp_type === 'Day Salary Employee' ? 'nullable' : 'required',
            'epf_employee' => $request->emp_type === 'Day Salary Employee' ? 'nullable' : 'required',

        ]);

        //  If employee type is permanent employee then  etf, epf, employee_epf, basic_amount filed is required
        if ($request->emp_type === 'Permanent Employee') {
            $data['basic_amount'] = $request->basic_amount;
            $data['etf'] = $request->etf;
            $data['epf'] = $request->epf;
            $data['epf_employee'] = $request->epf_employee;
        }

        // Check name is unique
        if (Employe::where('name', $request->name)->exists()) {
            return redirect()->back()->with('error', 'Name already exists.');
        }
        // Check email is unique
        if (Employe::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email already exists.');
        }

        if ($data['emp_type'] == 'Permanent Employee') {
            // Get etf, epf, employee_epf , basic_amount
            $etf = $request->etf;
            $epf = $request->epf;
            $employee_epf = $request->epf_employee;
            $basic_amount = $request->basic_amount;


            // Call the function to calculate etf, epf, employee_epf
            $calculated_data = $this->emp_etf_epf_calculate($etf, $epf, $employee_epf, $basic_amount);
            // Access the returned data
            $employee_con_epf_amount = $calculated_data['employee_con_epf_amount'];
            $employer_con_epf_amount = $calculated_data['employer_con_epf_amount'];
            $employer_con_etf_amount = $calculated_data['employer_con_etf_amount'];
            $total_employer_con = $calculated_data['total_employer_con'];
            $net_salary = $calculated_data['net_salary'];

            $data['net_salary'] = $net_salary;
            $data['employer_con_total_amount'] = $total_employer_con;
            $data['employer_con_epf_amount'] = $employer_con_epf_amount;
            $data['employer_con_etf_amount'] = $employer_con_etf_amount;
            $data['employee_epf'] = $employee_epf;
            $data['employee_con_epf_amount'] = $employee_con_epf_amount;
        }

        // Name capitalize
        $data['name'] = ucfirst($request->name);
        $orginalPassword = $data['password'];
        $data['password'] = Hash::make($request->password);


        if ($employee = Employe::create($data)) {
            // Send password and login email to the employeer email
            Mail::to($data['email'])->send(new EmployeeEmail($data, $orginalPassword));

            // Send email verification link
            $employee->sendEmailVerificationNotification();

            return redirect()->route('useradmin.viewemployee')->with('success', 'Employee created successfully!');
        } else {
            return redirect()->route('useradmin.viewemployee')->with('failed', 'Employee created failed!');
        }

    }

    public function destroy(Request $request, Employe $employee)
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/emp/login');
    }

    public function emp_salary_view()
    {
        $details = DB::table('monthly salary')->orderBy('created_at', 'desc')->get();
        return view('employee.salary', compact('details'));
    }

    public function emp_salary_create()
    {
        // Get Permanent Employees
        $employees = Employe::where('emp_type', '=', 'Permanent Employee')->get();
        $jobs = JobAmount::whereIn('payment_status', ['Pending', 'Failed'])->get();
        // dd($employees);
        return view('employee.salary_create', compact('employees', 'jobs'));
    }

    public function getEmployeeDetails(Request $request)
    {
        $empId = $request->emp_id;

        // Find the employee details
        $employee = Employe::where('emp_id', $empId)->first();

        if ($employee) {
            return response()->json([
                'success' => true,
                'emp_type' => $employee->emp_type,
                'name' => $employee->name,
                'basic_amount' => $employee->basic_amount,
                'etf' => $employee->etf,
                'epf' => $employee->epf,
                'employee_epf' => $employee->employee_epf,
                'net_amount' => $employee->net_salary,
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Employee not found.']);
        }
    }

    public function emp_salary_store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'emp_id' => 'numeric|required|exists:employes,emp_id',
            'name' => 'string|required|max:255',
            'basic_amount' => 'numeric|required',
            'etf' => 'numeric|required',
            'epf' => 'numeric|required',
            'credit_amount' => 'numeric|required',
            'job_amount' => 'numeric|required',
            'salary_status' => 'string|required',
            'start_date' => 'date|required|before:end_date',
            'end_date' => 'date|required|after:start_date',
            'employee_epf' => 'numeric|required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $salary = new MonthlySalary();
        $salary->emp_id = $request['emp_id'];
        $salary->name = $request['name'];
        $salary->emp_type = $request['emp_type'];
        $salary->basic_amount = $request['basic_amount'];
        $salary->etf = $request['etf'];
        $salary->epf = $request['epf'];
        $salary->loan_amount = $request['credit_amount'];
        $salary->job_amount = $request['job_amount'];
        $salary->start_date = $request['start_date'];
        $salary->end_date = $request['end_date'];
        $salary->salary_status = $request['salary_status'];

        $salary->save();

        if ($salary->save()) {
            return redirect()->route('useradmin.emp.salaryview')->with('success', 'Salary added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add salary. Please try again.');
        }
    }


    //*** FUNCTION TO EMPLOYEE SALARY EDIT */
    public function emp_salary_edit($id)
    {

        $details = MonthlySalary::where('id', $id)->first();
        // Find Permanent Employee Employee epf in Employye table
        $epf = DB::table('employes')->where('emp_id', $details->emp_id)->first();
        $details->employee_epf = $epf->employee_epf;
        return view('employee.salary_edit', ['details' => $details]);

    }

    public function emp_salary_update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'numeric|required|exists:monthly salary,id',
            'name' => 'string|required|max:255',
            'basic_amount' => 'numeric|required',
            'etf' => 'numeric|required',
            'epf' => 'numeric|required',
            'credit_amount' => 'numeric|required',
            'job_amount' => 'numeric|required',
            'salary_status' => 'string|required',
            'start_date' => 'date|required|before:end_date',
            'end_date' => 'date|required|after:start_date',
            'employee_epf' => 'numeric|required',
        ]);


        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $affected = DB::table('monthly salary')
            ->where('id', $request->id)
            ->update([
                'id' => $request['id'],
                'name' => $request['name'],
                'basic_amount' => $request['basic_amount'],
                'etf' => $request['etf'],
                'epf' => $request['epf'],
                'job_amount' => $request['job_amount'],
                'loan_amount' => $request['credit_amount'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
                'salary_status' => $request['salary_status'],

            ]);

        if ($affected > 0) {
            return redirect()->route('useradmin.emp.salaryview')->with('success', 'Salary Updated successfully');
        } else {
            return redirect()->route('useradmin.emp.salaryview')->with('error', 'Salary not updated');
        }
    }

    public function emp_salary_delete($id)
    {
        $affected = DB::table('monthly salary')
            ->where('id', $id)
            ->delete();

        if ($affected > 0) {
            return back()->with('success', 'Salary deleted successfully');
        } else {
            return back()->with('error', 'Salary not deleted');
        }
    }

    public function emp_salary_payments_view()
    {

        $details = EmpPayment::orderByDesc('id', 'desc')->get();
        return view('employee.salary_payments', compact('details'));

    }
    public function emp_salary_payment_create()
    {

        $employees = Employe::all();
        $salary = DB::table('monthly salary')->where('salary_status', 'Pending')->get();
        // Get job amount
        $jobs = JobAmount::whereIn('payment_status', ['Pending'])->get();
        // when employees has credit amount in employee credit table check and store employees who have credit amount
        $empCredits = DB::table('employee_credits')->where('credit_status', 'approved')->get();
        // Add credit amounts to corresponding employees
        foreach ($employees as $employee) {
            // Filter employee credits that match the current employee's ID
            $matchingCredits = $empCredits->where('employee_id', $employee->emp_id);

            // Sum the credit amounts and store them in the employee object
            if ($matchingCredits->count() > 0) {
                $employee->credit_amount = $matchingCredits->sum('credit_amount');
            } else {
                $employee->credit_amount = 0;
            }
        }

        return view('employee.salary_payment_create', compact('employees', 'salary', 'jobs', 'empCredits'));
    }


    public function emp_salary_payment_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jobsId' => 'nullable|string',
            'employee_id' => 'required|integer|exists:employes,emp_id',
            'available_amount' => 'required|numeric|min:0',
            'credit_amt' => 'required|numeric|min:0',
            'pay_type' => 'required|string|in:Cash,Bank,Other',
            'can_deduct' => 'string|in:true,false',
        ]);


        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            // Get selected job ids
            $jobIds = explode(',', $request->input('jobsId'));


            $empId = null; // Initialize employee ID

            if (!empty($jobIds) && !in_array("", $jobIds)) {
                // Process job IDs
                foreach ($jobIds as $jobId) {
                    // Job amount details
                    $job = JobAmount::find($jobId);
                    if (!$job) {
                        return redirect()->back()->with('error', 'Job ID not found');
                    }

                    // Update payment status and payment date
                    $job->payment_date = Carbon::now();
                    $job->payment_status = 'Paid';
                    $job->save(); // Save job payment updates

                    // Get employee id
                    $empId = $job->emp_id;
                }
            } else {
                $empId = $request->input('employee_id');
            }

            // Ensure empId is valid
            if (!$empId) {
                return redirect()->back()->with('error', 'Employee ID not found');
            }

            // Check employee type
            $employee = Employe::where('emp_id', $empId)->first();
            if ($employee) {
                if ($employee->emp_type === "Permanent Employee") {
                    $salary = MonthlySalary::where('emp_id', $empId)
                        ->whereIn('salary_status', ['Pending', 'NotPay'])
                        ->first();

                    if (!$salary) {
                        return redirect()->back()->with('error', 'Please add salary details first');
                    } else {
                        // Update salary status and payment date
                        $salary->salary_status = 'Paid';
                        $salary->save(); // Save salary updates
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Employee not found');
            }

            // Find selected employee name and type
            $employeeName = $employee->name;
            $employeeType = $employee->emp_type;

            $creditAmt = $request->credit_amt; // Get credit amount
            $availableAmount = $request->available_amount;



            $employeLoans = null;
            if ($request->can_deduct == 'true') {
                // Check if credit amount is greater than available amount
                if ($creditAmt > $availableAmount) {
                    return redirect()->back()->with('error', 'Cannot deduct more than available amount');
                } else {
                    $finalTotalPayAmount = $availableAmount - $creditAmt;
                    $employeLoans =  EmployeeCredit::where('employee_id', $empId)->where('credit_status', 'approved')->get();
                    // Update employee_credits table
                    EmployeeCredit::where('employee_id', $empId)->where('credit_status', 'approved')->update(['paid_date' => Carbon::now(), 'credit_status' => 'paid']);

                    // get total credit amount from employee_credits table as array
                    if($employeLoans != null){
                        $loanCreditAmt = 0;
                        foreach ($employeLoans as $loan) {
                            $loanCreditAmt += $loan->credit_amount;
                        }
                    }

                }

            } else if ($request->can_deduct == 'false') {

                $finalTotalPayAmount = $availableAmount;
            } else {
                $finalTotalPayAmount = $availableAmount;
            }

            // Create payment record
            $savedEmployesPayment = EmpPayment::create([
                'emp_id' => $request['employee_id'],
                'name' => $employeeName,
                'pay_amount' => $finalTotalPayAmount,
                'credit_amount' =>$request->can_deduct == 'true' ? $creditAmt : 0,
                'date' => Carbon::now(),
                'emp_type' => $employeeType,
                'payment_status' => $request['pay_type'],
            ]);

            // Create a new CashFlow entry using the helper when pay employee salary with pay  credit
            if ($request->can_deduct == 'true') {
                if($creditAmt < $availableAmount && $loanCreditAmt == $creditAmt){

                    // create cash flow records for credit deduction as income
                    foreach ($employeLoans as $loan) {
                       CashFlowHelper::create(
                            $name = 'Employee Credit' . Carbon::parse($savedEmployesPayment->date)->format('Y-m-d') . ' ' . $employeeName,
                            $amount = $loan->credit_amount,
                            $date = $savedEmployesPayment->date,
                            $ref_id = $loan->Employee_credit_id,
                            $ref_name = EmployeeCredit::getTableName(),
                            $incomeOrExpense = 'INCOME'
                        );
                    }
                }
            }

            // Create a new CashFlow entry using the helper when pay employee salary without pay  credit
            if($availableAmount > 0){
                $is_cashflow_saved_salary = CashFlowHelper::create(
                    $name = 'Employee Salary' . Carbon::parse($savedEmployesPayment->date)->format('Y-m-d') . ' ' . $employeeName,
                    $amount = $availableAmount,
                    $date = $savedEmployesPayment->date,
                    $ref_id = $savedEmployesPayment->id,
                    $ref_name = EmpPayment::getTableName(),
                    $incomeOrExpense = 'EXPENSE'
                );
            }

            DB::commit(); // Commit the transaction
            return redirect()->route('useradmin.emp.salary_pauments_view')->with('success', 'Employee Payment Paid Successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction on error
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }


    //** FUNCTION TO  EMPLOYEE SALARY PAYMENT EDIT */
    public function emp_salary_payment_edit($id)
    {

        $details = EmpPayment::where('id', $id)->first();
        return view('employee.salary_payment_edit', ['details' => $details]);

    }
    //** FUNCTION TO EMPLOYEE SALARY PAYMENT UPDATE */
    public function emp_salary_payment_update(Request $request)
    {
        // Update the emp_payment record using Eloquent
        $empPayment = EmpPayment::findOrFail($request->id);
        $empPayment->update([
            'name' => $request->name,
            'pay_amount' => $request->pay_amount,
            'payment_status' => $request->payment_status
        ]);


       // Get the date and format it
       $paymentDate = Carbon::parse($empPayment->date)->format('Y-m-d');

        // Update the corresponding cash flow record
        $is_cashflow_updated = CashFlowHelper::update(
            $name = 'Employee Salary' . $paymentDate . ' ' . $request->name,
            $amount = $request->pay_amount,
            $date = $paymentDate,
            $ref_id = $request->id,
            $ref_name = EmpPayment::getTableName(),
           $incomeOrExpense = 'EXPENSE'
        );

        return redirect()->route('useradmin.emp.salary_pauments_view')->with('success', 'Employee Payement Updated Successfully!');

    }
    //** FUNCTION TO PAYMENT DELETE */
    public function emp_salary_payment_delete($id)
    {

        $affected = DB::table('emp_payments')
            ->where('id', $id)
            ->delete();

        // Delete the corresponding cash flow record
        $is_cashflow_deleted = CashFlowHelper::delete(
            $ref_id = $id,
            $ref_name = EmpPayment::getTableName()
        );

        if ($affected > 0) {
            return redirect()->route('useradmin.emp.salary_pauments_view')->with('success', 'Payment deleted successfully');
        } else {
            return redirect()->route('useradmin.emp.salary_pauments_view')->with('error', 'Error');
        }
    }
    // ** FUNCTION TO GET EMPLOYEE Credit AMOUNT */
    public function emp_Credits(Request $request)
    {
        $empId = $request->input('emp_id');
        $startDate = $request->input('startTime');
        $endDate = $request->input('endTime');

        $creditAmount = DB::table('employee_credits')->where('employee_id', $empId)
                                    ->where('credit_status', 'approved')
                                    ->whereBetween('credit_date', [$startDate, $endDate])
                                    ->sum('credit_amount');

        if($creditAmount == null){
            $creditAmount = 0;
        }
        return response()->json(['credit_amount' => $creditAmount]);
    }


    //! JOB AMOUNT */

    /**
     * This function is used to view all job amounts in the system.
     * It shows a list of all job amounts, orders and employees.
     * The job amounts are ordered by their created date in descending order.
     * The orders are ordered by their created date in descending order.
     * The employees are all of the employees in the system.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emp_job_amount_view()
    {
        $details = DB::table('job_amount')->orderBy('created_at', 'desc')->get();
        $orders = Order::where('order_type', 'invoice')->orderBy('created_at', 'desc')->get();
        $employees = Employe::all();
        return view('employee.job_amount', compact('details', 'orders', 'employees'));
    }



    /**
     * This function is used to create a new job amount.
     * It shows a form with dropdowns for selecting the order and employee.
     * The orders are all of the orders in the system with type 'invoice'.
     * The employees are all of the active employees in the system.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobAmountCreate()
    {
        // Get all orders
        $orders = Order::where('order_type', 'invoice')->get();
        // Get all employees
        $employees = Employe::where('active', 'Active')->get();
        // Get all events
        $events = AdminEvent::all();
        // Assign null to specificEvent
        $specificEvent = null;

        return view('employee.job_amount_create', compact('orders', 'employees', 'events', 'specificEvent'));
    }

    // In employee create filter option acoording to selected date.
    public function filterJobAmount(Request $request)
    {
        $query = DB::table('job_amount');

        // Apply booking date filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('booking_date', [$request->start_date, $request->end_date]);
        }

        // Apply payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Get the filtered results
        $details = $query->get();

        return view('employee.job_amount', compact('details'))->with('filtered', true);
    }

    /**
     * This function is used to create a new job amount for a specific event.
     * It shows a form with dropdowns for selecting the order and employee.
     * The orders are all of the orders in the system with type 'invoice' and event_id equal to $eventId.
     * The employees are all of the active employees in the system.
     * @param int $eventId The ID of the event for which job amounts should be created.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobAmountCreateEvent($eventId)
    {
        // Get all employees
        $employees = Employe::where('active', 'Active')->get();
        // Get the event
        $specificEvent = AdminEvent::find($eventId);
        // Get all events
        $events = AdminEvent::all();
        // Get all orders
        $orders = Order::where('order_type', 'invoice')->where('event_id', $eventId)->get();

        return view('employee.job_amount_create', compact('employees', 'specificEvent', 'events', 'orders'));

    }

    /**
     * Retrieves job amounts and assigned employees for a specific order.
     *
     * This function fetches the order by the given order ID and retrieves
     * job amounts associated with the order from the 'job_amount' table.
     * It also extracts the names of assigned employees from the 'orders'
     * table where the order type is 'invoice'. Employees who are assigned
     * to the order but not listed in the 'job_amount' table are identified,
     * and default job amount details are returned for them.
     *
     * @param int $orderId The ID of the order for which job amounts and assigned employees are retrieved.
     * @return \Illuminate\Http\JsonResponse A JSON response containing job amounts and additional employee information.
     */
    public function getJobAmounts($orderId)
    {
        try {
            // Fetch the order
            $order = Order::find($orderId);
            $bookingDate = $order->booking_date;

            // Try parsing the date using Carbon
            $carbonDate = Carbon::parse($bookingDate);
            // Try formatting the date using Carbon
            $formattedDate = $carbonDate->format('Y-m-d');
            $order->formatted_date = $formattedDate;

            // Get job amounts for this order
            $jobAmounts = DB::table('job_amount')
                ->where('order_id', $orderId)
                ->get();

            // Extract assigned employee names from the `order` table
            $assignedEmployees = DB::table('order')
                ->selectRaw("GROUP_CONCAT(name) as names") // Combine all names into a single string
                ->where('order_id', $orderId)
                ->where('order_type', 'invoice')
                ->value('names');

            // Split the names string into an array
            $assignedEmployeeNames = $assignedEmployees ? explode(',', $assignedEmployees) : [];

            // Filter out employees already listed in `job_amount`
            $employeesWithoutJobAmounts = array_diff(
                $assignedEmployeeNames,
                $jobAmounts->pluck('name')->toArray()
            );

            // Format response
            $employees = [];
            foreach ($employeesWithoutJobAmounts as $employeeName) {
                $employees[] = [
                    'name' => $employeeName,
                    'job_amount' => 0, // Set the default job amount to 0
                    'payment_status' => 'Not paid',
                    'payment_date' => null
                ];
            }

            return response()->json([
                'jobAmounts' => $jobAmounts,
                'employees' => $employees,
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Handles the job amount update and creation from the UI.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function jobAmountStore(Request $request)
    {
        $validatedData = Validator()->make($request->all(), [
            'order_id' => 'required|integer',
            'event_id' => 'required|integer',
            'event_name' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'jobAmountArrayInput' => 'required|string|json',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        DB::BeginTransaction();

        try {
            $jobAmountsArray = json_decode($request->input('jobAmountArrayInput'), true);

            JobAmount::updateCreateOrDelete($data = $jobAmountsArray, $order_id =$request->input('order_id'), $event_id = $request->input('event_id'));

            DB::commit();

            return redirect()->route('useradmin.emp.job.amount.view')->with('success', 'Job amount updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('useradmin.emp.job.amount.view')->with('error', $e->getMessage());
        }

    }


    /**
     * Edits a job amount.
     *
     * @param int $id The ID of the job amount to edit.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jobAmountEdit($id)
    {
        $details = DB::table('job_amount')->where('id', $id)->first();
        return view('employee.job_amount', ['details' => $details]);
    }


    /**
     * Updates a job amount.
     *
     * @param \Illuminate\Http\Request $request A request with the data to update.
     * @return \Illuminate\Http\RedirectResponse A redirect response with a success or error message.
     */
    public function jobAmountUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'order_id' => 'required',
            'booking_date' => 'required',
            'job_amount' => 'required',
            'payment_status' => 'required',
            'payment_date' => 'required',
        ]);
        $affected = DB::table('job_amount')
            ->where('id', $request->id)
            ->update([
                'id' => $validatedData['id'],
                'name' => $validatedData['name'],
                'order_id' => $validatedData['order_id'],
                'booking_date' => $validatedData['booking_date'],
                'job_amount' => $validatedData['job_amount'],
                'payment_status' => $validatedData['payment_status'],
                'payment_date' => $validatedData['payment_date'],

            ]);

        if ($affected > 0) {
            return back()->with('success', 'Data updated successfully');
        } else {
            return back()->with('error', 'Data not updated');
        }
    }

    /**
     * Deletes a job amount from the database.
     *
     * @param int $id The ID of the job amount to delete.
     * @return \Illuminate\Http\RedirectResponse A redirect response with a success or error message.
     */
    public function jobAmountDelete($id)
    {
        DB::beginTransaction(); // Start the transaction

        try {
            // Get the order ID associated with the `job_amount`
            $order_id = JobAmount::where('id', $id)->value('order_id');

            if (!$order_id) {
                throw new \Exception('Order not found for the given job amount');
            }

            // Retrieve the order record
            $order = Order::where('order_id', $order_id)->first();

            if (!$order) {
                throw new \Exception('Order not found');
            }

            // Get the name column (employee names)
            $employees = explode(',', $order->name);

            // Remove the employee associated with the `job_amount`
            $employeeToRemove = JobAmount::where('id', $id)->value('name');
            $updatedEmployees = array_filter($employees, fn($employee) => trim($employee) !== trim($employeeToRemove));

            // Update the `name` column in the `order` table
            Order::where('order_id', $order_id)
                ->update(['name' => implode(',', $updatedEmployees)]);

            // Delete the `job_amount` entry
            JobAmount::where('id', $id)->delete();

            DB::commit(); // Commit the transaction
            return redirect()->back()->with('success', 'Job amount delete successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    //***EMPLOYER EVENTS */
    public function viewevents()
    {
        //login in employee
        $emp_id = Auth::guard('employee')->user()->emp_id;

        //find employeer details
        $emp = DB::table('employes')->where('emp_id', $emp_id)->first();

        // Find employer assigned events
        $events = Order::where(function ($query) use ($emp) {
            $query->whereRaw("FIND_IN_SET(?, name)", [$emp->name])
                ->whereIn('order_status', ['booking', 'completed', 'credit order']);
        })->get();


        //find these events start_time and end_time fin
        foreach ($events as $event) {
            $events->start_time = $event->start_time;
            $events->end_time = $event->end_time;

        }

        return view('employee.employer_events', ['events' => $events]);
    }


    //***EMPLOYER JOB AMOUNT */
    public function viewjobamount()
    {
        //login in employee
        $emp_id = Auth::guard('employee')->user()->emp_id;

        // Retrieve job amounts and corresponding event names for a specific employer ID
        $jobAmounts = DB::table('job_amount')->where('emp_id', $emp_id)->get();

        // Retrieve event names for each job amount
        foreach ($jobAmounts as $index => $jobAmount) {
            $orders = DB::table('order')->where('order_id', $jobAmount->order_id)->first();
            $jobAmounts[$index]->event_name = $orders->event_name;
            $jobAmounts[$index]->event_date = $orders->start_time;
        }

        return view('employee.employer_jobAmount', ['jobAmounts' => $jobAmounts]);

    }

    //***EMPLOYER Payment Amounts */
    public function employeeSalary()
    {
        //login in employee
        $emp_id = Auth::guard('employee')->user()->emp_id;

        //Check employee permenent or not
        $employeeType = Employe::where('emp_id', $emp_id)->get('emp_type');

        if ($employeeType[0]->emp_type == "Permanent Employee") {

            // get salary details with employee table net salary get employees table only net salary
            $salaryDetails = DB::table('monthly salary')
                ->join('employes', 'monthly salary.emp_id', '=', 'employes.emp_id')
                ->select('monthly salary.*', 'employes.net_salary')
                ->where('employes.emp_id', $emp_id)->get();

        } else {
            return redirect()->back()->with('error', 'You are not a Permanent Employee');
        }

        return view('employee.employer_payment', ['salaryDetails' => $salaryDetails]);

    }

    //***EMPLOYER EVENTS DATE DISPLAY IN CALENDAR */
    public function viewcalender()
    {
        //  Login user details
        $emp_id = Auth::guard('employee')->user()->emp_id;
        //  Find employeer details
        $emp = Employe::where('emp_id', $emp_id)->first();

        // Find employer assigned booking and credit order events
        $assignedBookingCreditEvents = Order::where(function ($query) use ($emp) {
            $query->whereRaw("FIND_IN_SET(?, name)", [$emp->name])
                ->whereIn('order_status', ['booking','credit order'])
                ->whereIn('order_type', ['invoice']);
        })->select('event_id')->distinct()->get();
        // Find employer assigned booking and credit order events details
        $assignedBookingCreditEventsDetails = AdminEvent::whereIn('eid', $assignedBookingCreditEvents->pluck('event_id'))->get();

        // Find employer assigned completed events
        $completedData = Order::where(function ($query) use ($emp) {
            $query->whereRaw("FIND_IN_SET(?, name)", [$emp->name])
                ->whereIn('order_status', ['completed'])
                ->whereIn('order_type', ['invoice']);
        })->select('event_id')->distinct()->get();
        // Find employer assigned completed events details
        $completedDataDetails = AdminEvent::whereIn('eid', $completedData->pluck('event_id'))->get();

        // Check if employee has permission to view customer details with phone number
        $hasCustomerDetailsViewPermission = EmployeePermission::where('employee_id', $emp_id)
        ->whereHas('permission', function ($query) {
            $query->where('name', 'view_customer_details');
        })
        ->exists();

        // Get all booking events
        $bookingAllEvents = AdminEvent::whereIn('status', ['booking'])->get();

        // Check if employee has permission to view all booking events
        $hasAllEventsViewPermission = EmployeePermission::where('employee_id', $emp_id)
        ->whereHas('permission', function ($query) {
            $query->where('name', 'view_all_booking_events');
        })
        ->exists();

        return view('employee.employer_events_calender', compact('assignedBookingCreditEventsDetails', 'completedDataDetails', 'hasCustomerDetailsViewPermission', 'bookingAllEvents', 'hasAllEventsViewPermission'));

    }

    //*** FUNCTION TO FETCH Event DETAILS FOR  EMPLOYER CALENDER   */
    public function getOrderDetails($eventId)
    {
        // Find the event details
        $event = AdminEvent::find($eventId);

        if ($event) {
            return response()->json([
                'id' => $event->eid,
                'event_name' => $event->event_name,
                'location' => $event->location,
                'customer_name' =>Customer::where('customer_id', $event->customer_id)->value('customer_name'),
                'customer_phone' => Customer::where('customer_id', $event->customer_id)->value('customer_phone'),
                'event_start_time' => $event->start_datetime,
                'event_end_time' => $event->end_datetime,
                'setup_time' => $event->setup_time,
            ]);
        } else {
            return response()->json(['error' => 'Event not found'], 404);
        }

    }

    /**
     * This function is used to view credits of employee
     *
     * It will fetch all the credits of employee and show them in the view
     *
     * @return \Illuminate\Http\Response
     */
    public function employeeCreditsView()
    {
        //login in employee
        $emp_id = Auth::guard('employee')->user()->emp_id;

        // Retrieve credits for a specific employer ID
        $credits = DB::table('employee_credits')->where('employee_id', $emp_id)->get();

       return view('employee.employer_credits_view', compact('credits'));
    }
}
