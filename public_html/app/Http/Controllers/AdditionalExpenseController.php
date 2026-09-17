<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use App\Models\AdminEvent;
use App\Models\CashFlowLog;
use Illuminate\Http\Request;
use App\Models\AdditionalExpense;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\CashFlowHelper;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Validator;


class AdditionalExpenseController extends Controller
{
    //** FUNCTION TO VIEW ADDITIONAL EXPENSES IN ORDER */
    public function viewExpenses()
    {
        // Get all expenses
        $expenses = AdditionalExpense::with('order')->get();
        return view('order.additionalExpensesView', compact('expenses'));
    }

    //** FUNCTION TO ADD ADDITIONAL EXPENSES IN ORDER */
    public function createExpenses($id)
    {
       // Get all invoice order
       if ($id == 0) {
           $orders = Order::all();
           $events = AdminEvent::all();
       } else {
             $orders = Order::where('order_id', $id)->first();
             // Get a specific order's details if passed
             $orderspecific = Order::find($id);
             // Get a specific event's details
             $eventspecific = AdminEvent::where('eid', $orders->event_id)->first();
             return view('order.additionalExpensesCreate', compact('orders', 'eventspecific', 'orderspecific'));
       }
       return view('order.additionalExpensesCreate', compact('orders', 'events'));
    }

    //** FUNCTION TO STORE ADDITIONAL EXPENSES IN ORDER */
    public function storeExpenses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:order,order_id',
            'event_id' => 'required|exists:events,eid',
            'name' => 'required|string|max:100',
            'amount' => 'required',
            'date' => 'required|date',
            'slip_download' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            // Create new additional expense
            $additionalExpenses = new AdditionalExpense();
            $additionalExpenses->order_id = $request->input('order_id');
            $additionalExpenses->event_id = $request->input('event_id');
            $additionalExpenses->expense_name = $request->input('name');
            $additionalExpenses->amount = $request->input('amount');
            $additionalExpenses->expense_date = $request->input('date');
            $additionalExpenses->description = $request->input('description') ?? 'N/A';
            if($additionalExpenses->save()){
                $ref_id = $additionalExpenses->id;

                // Create a new CashFlow entry using the helper
                $is_cashflow_saved = CashFlowHelper::create(
                    $name = 'Additional Expense ' . $request->input('date') . ' ' . $request->input('name'),
                    $amount = $request->input('amount'),
                    $date = $request->input('date'),
                    $ref_id = $ref_id,
                    $ref_name = AdditionalExpense::getTableName(),
                    $incomeOrExpense = 'EXPENSE'
                );
                DB::commit();
                if ($request->input('slip_download')) {
                    // Generate PDF
                    $pdfController = app(PdfController::class);
                    return $pdfController->downloadExpencePdf($ref_id);
                }
                // Redirect back previous page
                return redirect()->back()->with('success', 'Additional expense added successfully');
            }
            else{
                return redirect()->back()->with('error', 'Failed to add additional expense');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the request: ' . $e->getMessage());
        }
    }

    //** FUNCTION TO EDIT ADDITIONAL EXPENSES IN ORDER */
    public function editExpenses(Request $request, $id)
    {
        $additionalExpenses = AdditionalExpense::find($id);
        // Find this order eventName IN Order table
        $orderspecific = Order::find($additionalExpenses->order_id);
        $additionalExpenses->event_name = $orderspecific->event_name;

        $orders = Order::where('order_type', 'invoice')->get();
        $events = AdminEvent::all();
        return view('order.additionalExpensesEdit', compact('additionalExpenses', 'orders'));
    }

    //** FUNCTION TO UPDATE ADDITIONAL EXPENSES IN ORDER */
    public function updateExpenses(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:order,order_id',
            'event_id' => 'required|exists:events,eid',
            'name' => 'required|string|max:100',
            'amount' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            $additionalExpenses = AdditionalExpense::find($id);
            $additionalExpenses->order_id = $request->order_id;
            $additionalExpenses->event_id = $request->event_id;
            $additionalExpenses->expense_name = $request->name;
            $additionalExpenses->amount = $request->amount;
            $additionalExpenses->expense_date = $request->date;
            $additionalExpenses->description = $request->description ?? 'N/A';
            if($additionalExpenses->save()){
                // EXist CashFlow record
                $existingCashFlow = CashFlowHelper::find($id, AdditionalExpense::getTableName());

                // Update the corresponding cash flow record
                $is_cashflow_updated = CashFlowHelper::update(
                    $name = 'Additional Expense ' . $request->input('date') . ' ' . $request->name,
                    $amount = $request->amount,
                    $date = $request->date,
                    $ref_id = $id,
                    $ref_name = AdditionalExpense::getTableName(),
                    $incomeOrExpense = 'EXPENSE'
                );
                // Check if the cash flow record was updated
                if ($is_cashflow_updated) {
                    // Add a log entry to the cash_flow_log table
                    CashFlowLog::create([
                        'cashflow_id' => $existingCashFlow->id,
                        'action' => 'update',
                        'date' => $request->date,
                        'previous_amount' => $existingCashFlow->amount,
                        'current_amount' => $request->amount,
                        'type' => 'expense',
                    ]);
                }
                DB::commit();
                return redirect()->back()->with('success', 'Additional expense updated successfully');
            }
            else{
                return redirect()->back()->with('error', 'Failed to update additional expense');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while processing the request: ' . $e->getMessage());
        }
    }

    //** FUNCTION TO DELETE ADDITIONAL EXPENSES IN ORDER */
    public function deleteExpenses($id)
    {
        $additionalExpenses = AdditionalExpense::find($id);

        // Delete the corresponding cash flow record
        $is_cashflow_deleted = CashFlowHelper::delete(
            $ref_id = $id,
            $ref_name = AdditionalExpense::getTableName(),
        );
        // Check if the cash flow record was deleted
        if ($is_cashflow_deleted) {
            // Add a log entry to the cash_flow_log table
            CashFlowLog::create([
                'cashflow_id' => $id,
                'action' => 'delete',
                'date' => now(),
                'previous_amount' => $additionalExpenses->amount,
                'current_amount' => 0,
                'type' => 'expense',
            ]);
        }

        if($additionalExpenses->delete()){
            return redirect()->back()->with('success', 'Additional expense deleted successfully');
        }
        else{
            return redirect()->back()->with('error', 'Failed to delete additional expense');
        }
    }

    //** FUNCTION TO ADD ADDITIONAL EXPENSES IN ORDER BY EMPLOYEE*/
    public function createEmpExpense($order_id)
    {
        if ($order_id) {
            // Get a specific order's details if passed
            $orderspecific = Order::find($order_id);
            // Get a specific event's details
            $eventspecific = AdminEvent::find($orderspecific->event_id);
            return view('order.additionalExpensesCreate', compact('orderspecific', 'eventspecific'));
        } else {
            // Get all orders
            $orders = Order::where('order_type', 'invoice')->get();
            // Get all events
            $events = AdminEvent::all();
            return view('order.additionalExpensesCreate', compact('orders', 'events'));
        }
    }
}
