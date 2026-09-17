<?php

namespace App\Http\Controllers;

use App\Models\DamageItem;
use App\Models\Item;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rent;

class DamageItemController extends Controller
{
    /**
     *  FUNCTION TO VIEW ALL DAMAGE ITEMS
     */
    public function damageItems()
    {
        // Get all damage items with their respective rent items
        $damageItems = DamageItem::with('rentitem')->get();

        // Loop through each damage item and get corresponding item details
        foreach ($damageItems as $damageItem) {
            // Get the associated rent item and retrieve the item_id
            $item = DB::table('rent_items')
                ->join('damage_items', 'rent_items.rent_item_id', '=', 'damage_items.rent_item_id')
                ->where('rent_items.rent_item_id', $damageItem->rent_item_id)
                ->select('rent_items.item_id')
                ->first();  // Fetch the first record since rent_item_id should return a single item

            if ($item) {
                // Fetch the actual item details from the Item model using the item_id
                $damageItem->item_name = Item::where('item_id', $item->item_id)->value('item_name');
            } else {
                $damageItem->item_name = '';  // Fallback if no item found
            }
        }

        return view('rentitems.damageitems', ['damageItems' => $damageItems]);
    }

    public function editDamageItem($id)
    {
        // Get this damage item details
        $damageItem = DamageItem::findOrFail($id);
        $rentitem = DB::table('rent_items')->where('rent_item_id', $damageItem->rent_item_id)->first();
        $item = DB::table('item')->where('item_id', $rentitem->item_id)->first();
        $damageItem->item_name = $item->item_name;
        return view('rentitems.damageitemedit', ['damageItem' => $damageItem]);

    }

    public function updateDamageItem(Request $request, DamageItem $damageItem)
    {
        // check validate
        $validator = Validator::make($request->all(), [
            'damage_status' => 'required|in:Fixed,Fixing',
            'damage_note' => 'nullable|string|max:255',
            'damage_id' => 'required|exists:damage_items,id',
            'quantity' => 'required| min:1',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // For non-AJAX requests, redirect back with errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //starting the transaction
        DB::beginTransaction();

        // Process your form submission
        try {

            // Retrieve the DamageItem record from the database
            $damageItem = DamageItem::where('id', '=', $request->damage_id)->with('rentitem')->first();

            if (!$damageItem) {
                return redirect()->route('useradmin.rent.damage')->with('error', 'Damage Item Not Found');
            }

            if ($request->damage_status == 'Fixed') {

                // Get the damage item quantity
                $existDamageQuantity = $damageItem->quantity;

                // Check if the quantity is equal to the existing quantity
                if ($request->quantity != $existDamageQuantity && $existDamageQuantity > 1) {
                    // Damage details update
                    $damageItem->update([
                        'quantity' => $existDamageQuantity - $request->quantity,
                        'damage' => $request->damage_note,
                    ]);

                    // Update Item table instock
                    DB::table('item')->where('item_id', $damageItem->rentitem->item_id)->increment('in_stock', $request->quantity);
                    // Now check if the item is still in stock
                    if ( DB::table('item')->where('item_id', $damageItem->rentitem->item_id)->value('in_stock') > 0) {
                        DB::table('item')->where('item_id', $damageItem->rentitem->item_id)->update(['status' => 'Available']);
                    }
                    DB::commit();
                   return redirect()->route('useradmin.rent.damage')->with('success',  $request->quantity . ' Damage Item fixed successfully and it added to stock');

                }

                // Update Item table instock
                DB::table('item')->where('item_id', $damageItem->rentitem->item_id)->increment('in_stock', $damageItem->quantity);

                // Now check if the item is still in stock
                if (DB::table('item')->where('item_id', $damageItem->rentitem->item_id)->value('in_stock') > 0) {
                    DB::table('item')->where('item_id', $damageItem->rentitem->item_id)->update(['status' => 'Available']);
                }

                    // Get rent details received status
                    $rentReceivedStatus = Rent::where('rent_id', $damageItem->rent_id)->value('received_status');
                    if( $rentReceivedStatus == 'Damage/Missing'){
                        // Update rent received status
                        DB::table('rent')->where('rent_id', $damageItem->rent_id)->update(['received_status' => 'Missing']);
                    }
                    else{

                        DB::table('rent')->where('rent_id', $damageItem->rent_id)->update(['received_status' => 'Good']);

                    }
                // Delete the DamageItem record from the database
                if ($damageItem->delete()) {
                    DB::commit();
                    return redirect()->route('useradmin.rent.damage')->with('success', 'Damage Item fixed successfully and it added to stock');
                }


            } else if ($request->damage_status == 'Fixing') {


                $damageItem->status = $request->damage_status;
                $damageItem->damage = $request->damage_note;
                $damageItem->save();
                DB::commit();
                return redirect()->route('useradmin.rent.damage')->with('success', 'Damage Item  details Updated not fixed');

            }

        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurred
            DB::rollBack();
            return redirect()->route('useradmin.rent.damage')->with('error', 'An error occurred while fixing the damage item.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DamageItem $damageItem)
    {
        //
    }
}
