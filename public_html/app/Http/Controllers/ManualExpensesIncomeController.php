<?php

namespace App\Http\Controllers;

use Exception;
use Validator;
use App\Models\CashFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\CashFlowHelper;
use App\Models\ManualExpensesIncome;

class ManualExpensesIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This function returns a view with a list of all manual expenses and income.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get all manual expenses and income from the database
        $manualExpensesIncomes = ManualExpensesIncome::all();

        // Return a view with the list of manual expenses and income
        return view('manualExpensesIncome.index', compact('manualExpensesIncomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manualExpensesIncome.addManulExpensesIncome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * This function takes a Request object and creates a new ManualExpensesIncome
     * object and saves it to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'name' => 'required|string',
            'amount' => 'required|regex:/^\d+$/',
            'type' => 'required|in:income,expense'
        ]);


        DB::beginTransaction(); // Start a database transaction

        try {
            // Create a new ManualExpensesIncome object and save it to the database
            $savedManualExpensesIncome = ManualExpensesIncome::create($validatedData);

            // Create a new CashFlow entry using the helper
            $is_cashflow_saved = CashFlowHelper::create(
                $name = 'Manual Expenses ' . $validatedData['date'] . ' ' . $validatedData['name'],
                $amount = $validatedData['amount'],
                $date = $validatedData['date'],
                // $key = ManualExpensesIncome::getTableName(). "|" .$savedManualExpensesIncome->id,
                $ref_id = $savedManualExpensesIncome->id,
                $ref_name = ManualExpensesIncome::getTableName(),
                $incomeOrExpense = ($validatedData['type'] === 'income') ? 'INCOME' : 'EXPENSE'
            );

            // If the cash flow entry was saved, commit the transaction
            if ($is_cashflow_saved) {
                DB::commit(); // Commit the transaction
                return back()->with('success', 'Manual expenses Income created successfully.');
            } else {
                DB::rollBack(); // Rollback the transaction
                return back()->with('error', 'Failed to create manual expenses income. Please try again.');
            }
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction

            // Return back with an error message
            return back()->with('error', 'Failed to create manual expenses income: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ManualExpensesIncome $manualExpensesIncome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * This function takes a ManualExpensesIncome object as an argument, and
     * returns a view with the object's data.
     *
     * @param  \App\Models\ManualExpensesIncome  $manualExpensesIncome
     */
    public function edit(ManualExpensesIncome $manualExpensesIncome)
    {
        // Retrieve the ManualExpensesIncome object from the database
        // $manualExpensesIncome = DB::table('manual_expenses_incomes')->where('id', $id)->first();

        // Return a view with the object's data
        return view('manualExpensesIncome.updateMenualExpensesIncome', compact('manualExpensesIncome'));
    }


    /**
     * Update the specified resource in storage.
     *
     * This function takes a ManualExpensesIncome object as an argument, updates it
     * with the request data, and saves it to the database. Additionally, it
     * updates the corresponding cash flow record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ManualExpensesIncome  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManualExpensesIncome $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'date' => 'required',
                'name' => 'required',
                'amount' => 'required',
                'type' => 'required'
            ]);

            // Update the ManualExpensesIncome object in the database
            $id->update($request->all());

            // Update the corresponding cash flow record
            $is_cashflow_updated = CashFlowHelper::update(
                $name = 'Manual expenses ' . $request->date . ' ' . $request->name,
                $amount = $request->amount,
                $date = $request->date,
                $ref_id = $id->id,
                $ref_name = ManualExpensesIncome::getTableName(),
                $incomeOrExpense = ($request->type === 'income') ? 'INCOME' : 'EXPENSE'
            );

            // Return a redirect response with a success message
            return back()->with('success', 'Manual expenses Income updated successfully.');

        } catch (\Exception $e) {
            // Return a redirect response with an error message
            return back()->with('error', 'An error occurred while updating the manual expenses income. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * This function takes a ManualExpensesIncome object as an argument, deletes it
     * from the database, and returns a redirect response with a success message.
     *
     * @param  \App\Models\ManualExpensesIncome  $id
     */
    public function destroy(ManualExpensesIncome $id)
    {
        try {
            // Delete the ManualExpensesIncome object from the database
            $id->deleteOrFail();

            // Delete the corresponding cash flow record
            $is_cashflow_deleted = CashFlowHelper::delete(
                $ref_id = $id->id,
                $ref_name = ManualExpensesIncome::getTableName()
            );

            // Return a redirect response with a success message
            return back()->with('success', 'Record deleted successfully');
        } catch (\Exception $e) {
            // Return a redirect response with an error message
            return back()->with('error', 'Failed to delete record. Please try again.');
        }
    }

    /**
     * This function returns a view with a list of all ManualExpensesIncome objects in the database.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function viewmanualexpensesincome()
    {
        // Retrieve all ManualExpensesIncome objects from the database
        $manualExpenses =  ManualExpensesIncome::orderBy('created_at', 'desc')->get();

        // Return a view with the list of ManualExpensesIncome objects
        return view('manualExpensesIncome.index', compact('manualExpenses'));
    }
}
