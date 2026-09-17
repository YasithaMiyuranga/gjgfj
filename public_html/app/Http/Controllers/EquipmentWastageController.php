<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\EquipmentWastage;
use Illuminate\Support\Facades\Validator;

class EquipmentWastageController extends Controller
{
    /**
     * Show the list of equipment wastages
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wastages = EquipmentWastage::with('item')->get();
        return view('Equipment.wastage.index', compact('wastages'));
    }
    /**
     * Show the form for creating a new equipment wastage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipments = Item::all();
        return view('Equipment.wastage.create', compact('equipments'));
    }
    /**
     * Store a newly created equipment wastage record in the database.
     *
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'equipment_id' => 'required|integer|exists:item,item_id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'wasted_on' => 'required|date',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
         }
        $data = [
            'item_id' => $request->equipment_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'wasted_on' => $request->wasted_on
        ];
        // Get the item
        $item = Item::find($request->equipment_id);

        // Check if item is in_stock > entered quantity
        if ( $item->in_stock >= $request->quantity ) {
            // Decerement the quantity of the item
            $item->update([
                'in_stock' => $item->in_stock - $request->quantity
            ]);
        }
        else{
            return response()->json(['message' => 'Out of stock'], 500);
        }
        // Create wastage
        $wastage = EquipmentWastage::create($data);
        if ( $wastage ) {
            if($request->ajax()) {
                return response()->json(['message' => 'Wastage updated successfully!'], 200);
            }
        }
    }
    /**
     * Show the form for editing the specified equipment wastage.
     *
     */

    public function edit($id)
    {
        $wastage = EquipmentWastage::with('item')->find($id);
        $equipments = Item::all();
        return view('Equipment.wastage.edit', compact('wastage', 'equipments'));
    }
    /**
     * Updates the specified equipment wastage.
     *
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'equipment_id' => 'required|integer|exists:item,item_id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'wasted_on' => 'required|date',
        ]);
        // If validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
         }
        $data = [
            'item_id' => $request->equipment_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'wasted_on' => $request->wasted_on
        ];

        // Get the wastage
        $equipmentWastage = EquipmentWastage::find($id);

        if (!$equipmentWastage) {
            return response()->json(['message' => 'Wastage not found'], 500);
        }

        $equipment = Item::find($request->equipment_id);

        if ($equipment->item_id != $equipmentWastage->item_id ) {
            return response()->json(['message' => 'Item not found'], 500);
        }

        // If the new quantity is larger than the existing quantity
        if ( $equipmentWastage->quantity < $request->quantity ) {
            // Calculate the difference between the new and old quantity
            $diff = $request->quantity - $equipmentWastage->quantity;

            // Check difference less than in_stock
            if( $equipment->in_stock < $diff ) {
                return response()->json(['message' => 'Out of stock'], 500);
            }

            // Update the in_stock value of the equipment item
            $equipment->update([
                // subtract the difference from the in_stock value
                'in_stock' => $equipment->in_stock - $diff
            ]);
        }
        else{
            // If the new quantity is smaller than the existing quantity
            // Calculate the difference between the new and old quantity
            $diff = $equipmentWastage->quantity - $request->quantity;

            // Update the in_stock value of the equipment item
            $equipment->update([
                // add the difference to the in_stock value
                'in_stock' => $equipment->in_stock + $diff
            ]);
        }
        $equipmentWastage->update([
            'item_id' => $request->equipment_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'wasted_on' => $request->wasted_on
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Wastage updated successfully!'], 200);
        }

        return redirect()->back()->with('success', 'Wastage updated successfully!');
    }
    /**
     * Delete the specified equipment wastage.
     *
     */
    public function destroy($id)
    {
        $wastage = EquipmentWastage::find($id);
        if( !$wastage ) {
            return back()->with('error', 'Wastage not found!');
        }
        $wastage->delete();
        return back()->with('success', 'Wastage deleted successfully!');
    }

}
