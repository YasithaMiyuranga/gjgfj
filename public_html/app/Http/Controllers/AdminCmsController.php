<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Admin;
use App\Models\Order;
use App\Models\AdminEvent;
use App\Http\Helper\Helper;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\AdditionalExpense;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerRequirement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminCmsController extends Controller
{
    function setLogin()
    {
        return view('auth.login');
    }

    function index()
    {
        //  Get all orders
        $data = DB::table('order')->orderByDesc('order_id')->where('order_status', '=', 'booking')->get();

        //  Get completed orders only
        $completeOrdersCount = DB::table('order')->count();

        //  Get count of all products
        $totalProducts=Item::count();

        //  Get this month all order list
        $thisMonthOrders = DB::table('order')
            ->whereMonth('booking_date', '=', date('m'))
            ->whereYear('booking_date', '=', date('Y'))
            ->get();

        //  Get today orders
        $todayOrders = DB::table('order')
            ->whereDate('booking_date', '=', date('Y-m-d'))
            ->where('order_status', '=', 'booking')
            ->get();

        //  Total Employee salary for this month
        $totalPayAmounts = DB::table('emp_payments')
        ->whereMonth('created_at', '=', date('m'))
        ->whereYear('created_at', '=', date('Y'))
        ->sum('pay_amount');

        // Total Expences this month
        $totalExpences = AdditionalExpense::whereMonth('expense_date', '=', date('m'))
        ->whereYear('expense_date', '=', date('Y'))
        ->sum('amount');

        //  Get sum of all booking and completed order payments this month
        $totalPayments= Order::whereMonth('created_at', '=', date('m'))
                            ->whereYear('created_at', '=', date('Y'))
                            ->where(function($query) {
                                //  Get orders with status of completed or booking
                                $query->where('order_status', '=', 'completed')
                                    ->orWhere('order_status', '=', 'booking');
                            })
                            ->sum('pay_amount');

        //  Get sum of all payment logs this month
        $paymentLogs = DB::table('payment_logs')->whereMonth('created_at', '=', date('m'))
                            ->whereYear('created_at', '=', date('Y'))
                            ->sum('paid_amount');

        //  Add payment logs to total payments
        $totalPayments += $paymentLogs;

        //  Get sum credit amounts in credit order table
        $creditAmounts = DB::table('credit_orders')
        ->sum('credit_amount');

        // Get total events
        $totalEvents = AdminEvent::count();
        // Get all bank accounts
        $bankAccounts = BankAccount::all();
        // Get all customer requirements
        $customerRequirements = CustomerRequirement::all();

        return view('Admin.dashboard',compact('data','completeOrdersCount','totalProducts','thisMonthOrders','totalPayAmounts','totalPayments','creditAmounts', 'todayOrders','totalExpences', 'totalEvents', 'bankAccounts','customerRequirements','paymentLogs'));
    }

    // ** FUNCTION TO  DISPLAY ADMIN PROFILE*/
    function profile()
    {
        return view('Admin.profile');
    }

    // ** FUNCTION TO  UPDATE ADMIN PROFILE*/
    function update_profile(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone_number' => 'required|regex:/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/',
            'image' => 'nullable|image|max:5120|mimes:jpeg,png,jpg,gif,svg,jfif',
        ]);

        $admin = Admin::find(Auth::guard('admin')->user()->id);
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $path = Helper::getFileUrl($request->image, 'uploads/admins/');
                $admin->profile_image =$path;
        }
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->phone_number,
        ]);
        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    // ** FUNCTION TO  DISPLAY ADMIN PASSWORD CHANGE*/
    function update_password(Request $request)
    {
        $validation = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

         //check seasion through find admin
         if(Auth::guard('admin')->check()){
            $id = Auth::guard('admin')->user()->id;
        }

        // Get the currently authenticated user
        $admin = Admin::find($id);

        if( !$admin) {
            // Redirect back with error message
            return redirect()->back()->with('error', 'Admin not found.');
        }

        // Check if the provided old password matches the stored hashed password
        if (!Hash::check($request->old_password, $admin->password)) {

            // Redirect back with error message
            return redirect()->back()->with('error', 'The provided password does not match your current password.');
        }

        $data['new_password'] = Hash::make($request->new_password);
        //update admin password
        $admin->update([
            'password' => $data['new_password']
        ]);
        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function destroy(Request $request, Admin $admin)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
