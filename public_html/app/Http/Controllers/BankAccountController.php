<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{

    public function create()
    {
        return view('bank_accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'branch_name' => 'required|string',
            'account_number' => 'required|string|unique:bank_accounts',
            'account_name' => 'required|string',
        ]);

        if ($request->has('is_default')) {
            BankAccount::query()->update(['is_default' => false]);
        }

        BankAccount::create([
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_default' => $request->has('is_default') ? true : false,
        ]);

        if($request->ajax()) {
            return response()->json(['message' => 'Bank account created successfully!'], 200);
        }
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('bank_accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'branch_name' => 'required|string',
            'account_number' => 'required|string|unique:bank_accounts,account_number,' . $bankAccount->id,
            'account_name' => 'required|string',
        ]);

        if ($request->has('is_default')) {
            BankAccount::query()->update(['is_default' => false]);
        }

        $bankAccount->update([
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_default' => $request->has('is_default') ? true : false,
        ]);

        if($request->ajax()) {
            return response()->json(['message' => 'Bank account updated successfully!'], 200);
        }
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()->back()->with('success', 'Bank account deleted successfully!');
    }
}
