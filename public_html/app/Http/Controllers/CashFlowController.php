<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use App\Models\CashFlowLog;
use FontLib\Table\Type\fpgm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class CashFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       // Define the number of items per page, with a default of 10
       $perPage = $request->input('per_page', 10);

       // Fetch paginated records in descending order
       $cashFlows = CashFlow::orderBy('id', 'desc')->paginate($perPage);

       // Return the paginated records to the index.view
       return view('cash_flow.index', compact('cashFlows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|max:99999999.99',
            'date' => 'required|date',
            'ref_id' => 'required|integer',
            'ref_name' => 'required|string|max:255',
            'type' => 'required|in:income,expense'
        ]);
        // Create cash flow record
        CashFlow::create($request->all());

        // Return the same view with a success message
        return back()->with('success', 'Cash Flow created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashFlow $cashFlow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashFlow $cashFlow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashFlow $cashFlow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashFlow $id)
    {
        $id->deleteOrFail();

        return back()->with('success', 'Record deleted successfully');
    }

    public function search(Request $request)
    {
        return view('cash_flow.add_cash_flow_view');
    }

    public function filter(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $withDeleted = $request->has('with_deleted_records');

        $amount = null;

        if($request->input('amount')){
            $amount = $request->input('amount');
        }

        if ($withDeleted) {
            // Apply date filter to cash flows with deleted records
            $cashFlowsQuery = CashFlow::withTrashed()->whereBetween('date', [$startDate, $endDate]);
        } else {
            // Apply date filter to cash flows
            $cashFlowsQuery = CashFlow::whereBetween('date', [$startDate, $endDate]);
        }

        // Apply optional amount filter
        if ($request->filled('amount')) {
            $cashFlowsQuery->where('amount', $request->input('amount'));
        }

        // Paginate the filtered cash flows
        $cashFlows = $cashFlowsQuery->paginate(10);

        // Clone the base query for income and expense totals
        $totalIncome = (clone $cashFlowsQuery)->where('is_income', 1)->sum('amount');
        $totalExpense = (clone $cashFlowsQuery)->where('is_expense', 1)->sum('amount');

        return view('cash_flow.view', compact('cashFlows', 'totalIncome', 'totalExpense', 'withDeleted', 'startDate', 'endDate', 'amount'));
    }


    public function viewCashFlows(Request $request)
    {
        // Define the number of items per page, with a default of 10
        $perPage = $request->input('per_page', 10);

        // Get this month with the first day of the month and last day of the month
        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        // Fetch paginated records
        $cashFlows = CashFlow::where('date', '>=', $thisMonthStart)->where('date', '<=', $thisMonthEnd)->paginate($perPage);

        // Fetch paginated records
        // $cashFlows = CashFlow::paginate($perPage);

        // Calculate total income and expense
        $totalIncome = CashFlow::where('date', '>=', $thisMonthStart)->where('date', '<=', $thisMonthEnd)->where('is_income', 1)->sum('amount');
        $totalExpense = CashFlow::where('date', '>=', $thisMonthStart)->where('date', '<=', $thisMonthEnd)->where('is_expense', 1)->sum('amount');

        $startDate = $thisMonthStart;
        $endDate = $thisMonthEnd;

        // Return the paginated records to the index.view
        return view('cash_flow.view', compact('cashFlows', 'totalIncome', 'totalExpense', 'startDate', 'endDate'));
    }

    public function downloadCashFlows(Request $request)
    {
        $password = $request->password;

        // Check if the password is correct logged in user
        if (!Hash::check($password, Auth::user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password.'
            ], 403);
        }

        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $withDeleted = $request->withDeleted;

        $cashFlowsQuery = $withDeleted
            ? CashFlow::withTrashed()->whereBetween('date', [$startDate, $endDate])
            : CashFlow::whereBetween('date', [$startDate, $endDate]);

        if ($request->amount != 0) {
            $cashFlowsQuery->where('amount', $request->amount);
        }

        $cashFlows = $cashFlowsQuery->get();

        $totalIncome = (clone $cashFlowsQuery)->where('is_income', 1)->sum('amount');
        $totalExpense = (clone $cashFlowsQuery)->where('is_expense', 1)->sum('amount');

        $csvFileName = 'cash_flows_' . $startDate . '_to_' . $endDate . '.csv';
        $filePath = storage_path('app/public/' . $csvFileName); // Save in the storage/public directory

        // Open file and write CSV content
        $handle = fopen($filePath, 'w');
        fputcsv($handle, ['Start Date', $startDate]);
        fputcsv($handle, ['End Date', $endDate]);
        fputcsv($handle, ['With Deleted Records', $withDeleted ? 'Yes':'No']);
        fputcsv($handle, ['']);
        fputcsv($handle, ['Date', 'Name', 'Income', 'Expense']);

        foreach ($cashFlows as $cashFlow) {
            fputcsv($handle, [
                $cashFlow->date,
                $cashFlow->name,
                $cashFlow->is_income ? $cashFlow->amount : 0,
                $cashFlow->is_expense ? $cashFlow->amount : 0
            ]);
        }

        fputcsv($handle, ['']);
        fputcsv($handle, ['Total Income', $totalIncome]);
        fputcsv($handle, ['Total Expense', $totalExpense]);

        fclose($handle);

        // Return the file URL to the client
        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $csvFileName)
        ], 200);

    }
    public function viewCashFlowLogs(Request $request)
    {
        // Define the number of items per page, with a default of 10
        $perPage = $request->input('per_page', 10);

        // Fetch paginated records
        $cashFlowLogs = CashFlowLog::orderBy('id', 'desc')->paginate($perPage);

        // Return the paginated records to the index.view
        return view('cash_flow.cash_flow_log', compact('cashFlowLogs'));
    }

}
