<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\EmployeeCredit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\CashFlowHelper;

class EmployeeCreditController extends Controller
{

   //***EMPLOYER CREDITS VIEW */
   public function empCreditsView()
   {
      $credits = DB::table('employee_credits')->orderByDesc('employee_credit_id')->get();

      foreach($credits as $credit){
        // Get employee name
        $employee = DB::table('employes')->where('emp_id', $credit->employee_id)->first();
        $credit->emp_name = $employee->name;
      }

      return view('employee.employer_credits', compact('credits'));
   }

    //***EMPLOYER CREDITS CREATE */
    public function empCreditsCreate()
    {
        // Get all employees
        $employees = DB::table('employes')->where('active', 'Active')->get();
        return view('employee.employer_credits_create',compact('employees'));
    }

    //***EMPLOYER CREDITS STORE */
    public function empCreditsStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'emp_id' => 'required|exists:employes,emp_id',
            'credit' => 'required|min:1',
            'credit_date' => 'required|date',
            'credit_status' => 'required|in:approved,pending,rejected,paid',
            'payment_type' => 'required|in:Cash,Bank',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $employeeName = DB::table('employes')->where('emp_id', $request->input('emp_id'))->value('name');
        $paidDate = $request->input('credit_status') == 'paid' ? Carbon::now()->format('Y-m-d') : null;

        $creditId = DB::table('employee_credits')->insertGetId([
            'employee_id' => $request->input('emp_id'),
            'credit_amount' => $request->input('credit'),
            'credit_date' => $request->input('credit_date'),
            'paid_date' => $paidDate,
            'credit_status' => $request->input('credit_status'),
            'payment_type' => $request->input('payment_type')
        ]);

        // if credit status is paid create cashflow entry income
        if ($request->input('credit_status') == 'paid') {
             // Create a new CashFlow entry using the helper
             $is_cashflow_saved = CashFlowHelper::create(
                $name = 'Employee Credit ' . $paidDate . ' ' . $employeeName,
                $amount = $request->input('credit'),
                $date = $paidDate,
                $ref_id = $creditId,
                $ref_name =EmployeeCredit::getTableName(),
                $incomeOrExpense = 'INCOME'
            );
        }

        // if credit status is approved create cashflow entry income
        if ($request->input('credit_status') == 'approved') {
            // Create a new CashFlow entry using the helper
            $is_cashflow_saved = CashFlowHelper::create(
               $name = 'Employee Credit ' . $request->input('credit_date') . ' ' . $employeeName,
               $amount = $request->input('credit'),
               $date = $request->input('credit_date'),
               $ref_id = $creditId,
               $ref_name =EmployeeCredit::getTableName(),
               $incomeOrExpense = 'EXPENSE'
           );
       }

        if ($creditId > 0) {
            return redirect()->route('useradmin.emp.credits.view')->with('success', 'Employee Credit Added!');
        } else {
            return redirect()->route('useradmin.emp.credits.view')->with('error', 'Employee Credit Not Added!');
        }
    }

   //***EMPLOYER CREDITS EDIT */
    public function empCreditsEdit(EmployeeCredit $employeeCredit, $id)
    {
        // Get this employee credit
        $credit = DB::table('employee_credits')->where('employee_credit_id', $id)->first();
        // Get all employees
        $employee_details = DB::table('employes')->where('emp_id', $credit->employee_id)->first();
        return view('employee.employer_credits_edit', compact('credit', 'employee_details'));
    }

    //***EMPLOYER CREDITS UPDATE */
    public function empCreditsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_id' => 'required|exists:employes,emp_id',
            'credit' => 'required|min:1',
            'credit_date' => 'required|date',
            'credit_status' => 'required|in:approved,pending,rejected,paid',
            'payment_type' => 'required|in:Cash,Bank',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $employeeName = DB::table('employes')->where('emp_id', $request->input('emp_id'))->value('name');
        $paidDate = $request->input('credit_status') == 'paid' ? Carbon::now()->format('Y-m-d') : null;

        $affected = DB::table('employee_credits')
            ->where('employee_credit_id', $request->id)
            ->update([
                'employee_id' => $request->input('emp_id'),
                'credit_amount' => $request->input('credit'),
                'credit_date' => $request->input('credit_date'),
                'paid_date' => $paidDate,
                'credit_status' => $request->input('credit_status'),
                'payment_type' => $request->input('payment_type')
            ]);

        // if credit status is paid create cashflow entry income
        if ($request->input('credit_status') == 'paid') {
            // Create a new CashFlow entry using the helper
            $is_cashflow_saved = CashFlowHelper::create(
               $name = 'Employee Credit ' . $paidDate . ' ' . $employeeName,
               $amount = $request->input('credit'),
               $date = $paidDate,
               $ref_id = $request->id,
               $ref_name = EmployeeCredit::getTableName(),
               $incomeOrExpense = 'INCOME'
           );
       }

       // if credit status is approved create cashflow entry income
       if ($request->input('credit_status') == 'approved') {
           // Create a new CashFlow entry using the helper
           $is_cashflow_saved = CashFlowHelper::create(
              $name = 'Employee Credit ' . $request->input('credit_date') . ' ' . $employeeName,
              $amount = $request->input('credit'),
              $date = $request->input('credit_date'),
              $ref_id = $request->id,
              $ref_name = EmployeeCredit::getTableName(),
              $incomeOrExpense = 'EXPENSE'
          );
      }

        if ($affected > 0) {
            return redirect()->route('useradmin.emp.credits.view')->with('success', 'Employee Credit Updated!');
        } else {
            return redirect()->route('useradmin.emp.credits.view')->with('error', 'Employee Credit Not Updated!');
        }
    }
    // ***EMPLOYER CREDITS DELETE */
       public function empCreditsDelete($id)
    {
        $affected = DB::table('employee_credits')->where('employee_credit_id', $id)->delete();

         // Delete the corresponding cash flow record
         $is_cashflow_deleted = CashFlowHelper::delete(
            $ref_id = $id,
            $ref_name = EmployeeCredit::getTableName()
        );

        if ($affected > 0) {
            return redirect()->route('useradmin.emp.credits.view')->with('success', 'Employee Credit Deleted!');
        } else {
            return redirect()->route('useradmin.emp.credits.view')->with('error', 'Employee Credit Not Deleted!');
        }
    }
}
