<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Http\Helper\CashFlowHelper;
use FontLib\Table\Type\name;
use App\Models\ItemUpdateHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    function addpurchaseorder(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'invoice_number' => 'required|string|max:255',
            'purchase_date' => 'required|date'
        ]);

        DB::BeginTransaction();
        try{

            if($request->cash_payment == null)
            {
                $request->cash_payment = 0;
            }
            if($request->grand_total == null)
            {
                $request->grand_total = 0;
            }
            $gTotal = $request->grand_total;
            $gTotal = (float) $gTotal;
            $cPayment = $request->cash_payment;
            $cPayment = (float) $cPayment;

            $credit_balance = $gTotal - $cPayment;

            $purchaseorder = new PurchaseOrder;
            $purchaseorder->supplier_id = $request->supplier_id;
            $purchaseorder->invoice_number = $request->invoice_number;
            $purchaseorder->purchase_date = $request->purchase_date;
            $purchaseorder->total_price = $request->total_price;
            $purchaseorder->pay_type = $request->pay_type;
            $purchaseorder->payment_amount = $request->cash_payment;
            $purchaseorder->balance = $request->balance;
            $purchaseorder->discount_percentage = $request->discount_percentage;
            $purchaseorder->discount_amount = $request->discount_amount;
            $purchaseorder->grand_total = $request->grand_total;
            $purchaseorder->save();


            $selected_items = $request->selected_items;
            $selected_items = json_decode($selected_items);

            foreach($selected_items as $selected_item)
            {
                $purchaseorder_items = new PurchaseOrderItem;
                $purchaseorder_items->purchase_order_id = $purchaseorder->id;
                $purchaseorder_items->item_id = $selected_item->itemId;
                $purchaseorder_items->quantity = $selected_item->quantity;
                $purchaseorder_items->purchased_price = $selected_item->price;
                $purchaseorder_items->discount = $selected_item->discount??0;
                $purchaseorder_items->save();

                // Add to the record  update_item_history
                $update_item_history = new ItemUpdateHistory;
                $update_item_history->item_id = $selected_item->itemId;
                $update_item_history->previous_stock = Item::where('item_id', $selected_item->itemId)->pluck('total_stock')->first();
                $update_updated_stock = $update_item_history->previous_stock + $selected_item->quantity;
                $update_item_history->updated_stock = $update_updated_stock;
                $update_item_history->updated_by = $selected_item->quantity;
                $update_item_history->save();

                $item = Item::find($selected_item->itemId);
                $item->total_stock = $item->total_stock + $selected_item->quantity;
                $item->in_stock = $item->in_stock + $selected_item->quantity;
                $item->product_amount =$selected_item->price;
                $item->save();



            }


            $supplier = Supplier::find($request->supplier_id);
            $supplier->credit_balance = $credit_balance;
            $supplier->save();

            // Create a new CashFlow entry using the helper
            $is_cashflow_saved = CashFlowHelper::create(
                $name = 'Purchase Order ' . $request->purchase_date.' '.$supplier->supplier_name.' '.$request->invoice_number,
                $amount = $request->cash_payment,
                $date = $request->purchase_date,
                $ref_id = $purchaseorder->id,
                $ref_name = PurchaseOrder::getTableName(),
                $incomeOrExpense = 'EXPENSE'
            );

            DB::commit();
            return redirect()->route('useradmin.purchaseorder.view')->with('success', 'Purchase Order added successfully!');

        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('useradmin.purchaseorder.addform')->with('error', 'Purchase Order could not be added!');
        }

    }

    function addpurchaseorderform()
    {
        $suppliers = Supplier::all();
        $items = Item::all();
        return view('purchaseorder.addpurchase', ['suppliers' => $suppliers, 'items' => $items]);
    }

    function viewpurchaseorder()
    {
        $purchaseorders = PurchaseOrder::all();
        foreach($purchaseorders as $purchaseorder)
        {
            $supplier = Supplier::find($purchaseorder->supplier_id);
            $purchaseorder->supplierName = $supplier ? $supplier->supplier_name : 'N/A';
        }
        return view('purchaseorder.index', ['purchaseorders' => $purchaseorders]);
    }

    function purchaseorderdetails($id)
    {
        $purchaseorder = PurchaseOrder::find($id);
        $supplier = Supplier::find($purchaseorder->supplier_id);
        $purchaseorder->supplierName = $supplier->supplier_name;
        $purchaseorder_items = PurchaseOrderItem::where('purchase_order_id', $id)->get();
        foreach($purchaseorder_items as $purchaseorder_item)
        {
            $item = Item::find($purchaseorder_item->item_id);
            $purchaseorder_item->itemName = $item->item_name;
        }
        return view('purchaseorder.viewpurchaseorder', ['purchaseorder' => $purchaseorder, 'purchaseorder_items' => $purchaseorder_items]);
    }
}
