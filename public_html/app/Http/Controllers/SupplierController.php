<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Http\Helper\CashFlowHelper;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    function addsupplier(Request $request)
    {
        $request->validate([
            'supplier_name' => 'string|required|max:255',
            'customer_phone' => 'nullable|regex:/^[0-9]{10}$/',
            'supplier_city' => 'string|nullable|max:255',
            'supplier_address' => 'string|nullable|max:255',
        ]);

        $supplier = new Supplier;
        $supplier->supplier_name = $request->input('supplier_name');
        $supplier->contact_number = $request->input('supplier_contact');
        $supplier->city = $request->input('supplier_city');
        $supplier->address = $request->input('supplier_address');
        $supplier->save();

        return redirect()->route('useradmin.supplier.view')->with('success', 'Supplier added successfully!');
    }

    function addsupplierform()
    {
        return view('supplier.addsupplier');
    }

    function viewsupplier()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', ['suppliers' => $suppliers]);
    }

    function editsupplier($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.editsupplier', ['supplier' => $supplier]);
    }

    function updatesupplier(Request $request)
    {
        $request->validate([
            'supplier_name' => 'string|required|max:255',
            'customer_phone' => 'nullable|regex:/^[0-9]{10}$/',
            'supplier_city' => 'string|nullable|max:255',
            'supplier_address' => 'string|nullable|max:255',
        ]);

        $supplier = Supplier::find($request->input('supplier_id'));
        $supplier->supplier_name = $request->input('supplier_name');
        $supplier->contact_number = $request->input('supplier_contact');
        $supplier->city = $request->input('supplier_city');
        $supplier->address = $request->input('supplier_address');
        $supplier->save();

        return redirect()->route('useradmin.supplier.view')->with('success', 'Supplier updated successfully!');
    }

    function deletesupplier($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {

            //  Find the supplier by id
            $supplier = Supplier::find($id);

            // Check if the supplier exists
            if (!$supplier) {
                return redirect()->route('useradmin.supplier.view')->with('error', 'Supplier not found!');
            }

            // Find the purchase orders for the supplier
            $Purchase  = PurchaseOrder::where('supplier_id', $id)->get();

            // Check if  the purchase order exists
            if ($Purchase) {
                // Delete the purchase order
                $Purchase->each(function ($purchase) {
                    $purchase->delete();
                });

            }

            // Delete the supplier
            $supplier->delete();

            // Commit the transaction
            DB::commit();
            return redirect()->route('useradmin.supplier.view')->with('success', 'Supplier deleted successfully!');
        } catch (\Exception $e) {

            // Rollback the transaction
            DB::rollBack();
            return redirect()->route('useradmin.supplier.view')->with('error', 'Error deleting supplier: ' . $e->getMessage());
        }
    }


    function getsupplier($id)
    {
        // Find the supplier by id
        $supplier = Supplier::find($id);

        // Find the purchase orders for the supplier
        $perchase = PurchaseOrder::find($id);

        return view('supplier.updatebalance', ['supplier' => $supplier, 'perchase' => $perchase]);
    }


    function updatesuppliercredits(Request $request, Supplier $supplier)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            $supplier = Supplier::find($request->input('supplier_id'));

            // Check if the supplier exists
            if (!$supplier) {
                return redirect()->route('useradmin.supplier.view')->with('error', 'Supplier not found!');
            }

            // Get current credit_balance and payment_amount from the request
            $name = $request->input('supplier_name');
            $credit_balance = $supplier->credit_balance;
            $payment_amount = $request->input('payment_amount');
            $date = $request->input('date');

            // Calculate the new credit balance
            $new_credit_balance = $credit_balance - $payment_amount;

            // Update supplier's credit balance
            $supplier->credit_balance = $new_credit_balance;
            $supplier->save();

            // Update the cash flow record
            $is_cashflow_updated = CashFlowHelper::create(
                'Supplier ' . $name,
                $payment_amount,
                $date,
                $supplier->id,
                Supplier::getTableName(),
                'EXPENSE'
            );

            // If any of the updates fail, throw an exception to trigger rollback
            if (!$is_cashflow_updated) {
                throw new \Exception('Failed to update cash flow record.');
            }

            // Commit transaction if all updates are successful
            DB::commit();

            return redirect()->route('useradmin.supplier.view')->with('success', 'Supplier credits updated successfully! Payment amount: ' . $payment_amount);

        } catch (\Exception $e) {

            // Rollback all changes if an error occurs
            DB::rollBack();
            return redirect()->route('useradmin.supplier.view')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
