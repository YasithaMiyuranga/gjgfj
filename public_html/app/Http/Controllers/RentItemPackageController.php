<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Item;
use App\Models\AdminEvent;
use App\Models\PredefinedPackage;
use Illuminate\Http\Request;
use App\Models\RentItemPackage;
use App\Models\RentItemPackageItem;
use Illuminate\Support\Facades\DB;

class RentItemPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $rentItemPackages = RentItemPackage::all();
        // Find all RentItemPackages event name
        foreach ($rentItemPackages as $rentItemPackage) {
            $eventId = $rentItemPackage->event_id;
            $event = AdminEvent::where('eid', $eventId)->first();
            if ($event) {
                $rentItemPackage->event_name = $event->event_name;
            }
        }
        return view('rentItemPackage.index',compact('rentItemPackages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selectedEvent = null;
        $items = Item::where('status', 'Available')->get();
        $events = AdminEvent::all();
        $predefinedPackages = PredefinedPackage::where('package_status', 'Active')->get();
        return view('rentItemPackage.create', compact('items', 'events', 'predefinedPackages', 'selectedEvent'));
    }

    public function eventCreate(AdminEvent $event)
    {

        $items = Item::where('status', 'Available')->get();
        $events = AdminEvent::all();
        $predefinedPackages = PredefinedPackage::where('package_status', 'Active')->get();
        $selectedEvent = $event;

        // Get previous url
        $previousUrl = url()->previous();
        // Check if previous url is useradmin/order/create or edit        
        if (str_contains($previousUrl, 'useradmin/order/create') || str_contains($previousUrl, 'useradmin/orderitems/view/edit/')) {

            return view('rentItemPackage.eventBaseCreate', compact('selectedEvent', 'items', 'events', 'predefinedPackages'));
        }
        else{
            return view('rentItemPackage.create', compact('selectedEvent', 'items', 'events', 'predefinedPackages'));
        }
    }

    public function eventEdit(RentItemPackage $rentItemPackage, AdminEvent $event)
    {
       return view('rentItemPackage.eventBaseEdit', compact('rentItemPackage', 'event'));
    }

    /**
     * Store a newly created resource in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * */
    public function store(Request $request)
    {
        // validation rules
        $validator = Validator::make($request->all(), [
            'event_id' =>  'required|exists:events,eid',
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'selected_items' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('selected_items', json_encode($request->input('selected_items', [])));
        }

        DB::beginTransaction();

        try {
          $rentItemPackage = RentItemPackage::create([
              'event_id' => $request->event_id,
              'name' => $request->package_name,
              'description' => $request->description?:NULL,
          ]);

          $rentitems = json_decode($request->selected_items);

          foreach ($rentitems as $item) {
               $RentItemPackageItem = RentItemPackageItem::create([
                   'rent_item_package_id' => $rentItemPackage->id,
                   'item_id' => $item->itemId,
                   'quantity' => $item->quantity
               ]);
          }
            DB::commit();

            return redirect()->route('useradmin.event_rent_packages.index')->with('success', 'Package created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create package. Please try again.');
        }
    }


    /**
     * Edit a rent item package.
     *
     * @param RentItemPackage $rentItemPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(RentItemPackage $rentItemPackage)
    {
        $rentItemPackage = RentItemPackage::with('rent_item_packages_items')->find($rentItemPackage->id);
        // Assgn item id matching item name
        foreach ($rentItemPackage->rent_item_packages_items as $rentItemPackageItem) {
            $item = Item::where('item_id', $rentItemPackageItem->item_id)->first();
            if ($item) {
                $rentItemPackageItem->itemName = $item->item_name;
            }

        }
        $items = Item::where('status', 'Available')->get();
        $events = AdminEvent::all();
        $predefinedPackages = PredefinedPackage::where('package_status', 'Active')->get();
        return view('rentItemPackage.edit', compact('rentItemPackage', 'items', 'events', 'predefinedPackages'));
    }


    /**
     * Update the specified rent item package in the database.
     *
     * @param Request $request The HTTP request object containing form data.
     * @param RentItemPackage $rentItemPackage The rent item package to be updated.
     * @return \Illuminate\Http\RedirectResponse Redirect response after updating.
     *
     * Validates the input data and updates the rent item package and its items.
     * If validation fails, returns back with errors.
     * If successful, commits the transaction and redirects with a success message.
     * If any exception occurs during the update, rolls back the transaction and redirects with an error message.
     */

    public function update(Request $request, RentItemPackage $rentItemPackage)
    {
        // validation rules
        $validator = Validator::make($request->all(), [
            'event_id' =>  'required|exists:events,eid',
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'selected_items' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('selected_items', json_encode($request->input('selected_items', [])));
        }

        DB::beginTransaction();

        try {
            $rentItemPackage->update([
                'event_id' => $request->event_id,
                'name' => $request->package_name,
                'description' => $request->description,
            ]);

           $rentitems = json_decode($request->selected_items);
           $existingItems = RentItemPackageItem::where('rent_item_package_id', $rentItemPackage->id)->pluck('item_id')->toArray();
           $itemsToDelete = array_diff($existingItems, array_column($rentitems, 'item_id'));
           RentItemPackageItem::whereIn('item_id', $itemsToDelete)->delete();

           foreach ($rentitems as $item) {
               RentItemPackageItem::updateOrCreate([
                   'rent_item_package_id' => $rentItemPackage->id,
                   'item_id' => $item->item_id,
                   'quantity' => $item->quantity
               ]);
           }
            DB::commit();

            return redirect()->route('useradmin.event_rent_packages.index')->with('success', 'Package updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update package. Please try again.');
        }

    }

    /**
     * Remove the specified rent item package from database.
     *
     * @param RentItemPackage $rentItemPackage
     * @return \Illuminate\Http\RedirectResponse
     */
       public function destroy(RentItemPackage $rentItemPackage)
    {
        $rentItemPackage->delete();

        return redirect()->route('useradmin.event_rent_packages.index')->with('success', 'Package deleted successfully.');
    }
}
