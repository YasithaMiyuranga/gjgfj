<?php

namespace App\Http\Controllers;

use App\Http\Helper\Helper;
use App\Models\AdditionalExpense;
use App\Models\AdminEvent;
use App\Models\Artists;
use App\Models\Category;
use App\Models\CreditOrder;
use App\Models\JobAmount;
use App\Models\Manager;
use App\Models\OrderBook;
use App\Models\OrderItem;
use App\Models\Payment_log;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ManagerEventsController extends Controller
{
    public function event_create()
    {
        // Get all categories
        $categoryNames = Category::all();

        // Get all active sponsors
        $sponsors = Sponsor::where('status', 'active')->get();
        $manager = Auth::guard('manager')->user();
        $artists = Artists::all();
        return view('manager.events.add', compact('categoryNames', 'artists', 'sponsors', 'manager'));
    }



    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'event_name' => 'required|string|max:100|unique:events,event_name',
            'phone_no' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location'  => 'required|string|max:100',
            'event_manager_id' => 'required|exists:managers,manager_id',
            'eventdate' => 'required|date',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'event_type'  => 'required|string',
            'category'  => 'required|string',
            'state' => 'required|string|max:20|in:Ongoing,Completed',
            'is_public' => 'required|string|max:20|in:1,0',
            'description' => 'required|string|max:200',
            'Logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'details_docs' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,jfif,pdf,docx,doc|max:2048',
            'artistname' => 'nullable|array',
            'artistname.*' => 'exists:artist,artist_name',
            'sponsor' => 'nullable|array',
            'sponsor.*' => 'exists:sponsors,sponsor_id',

        ]);

        DB::beginTransaction();
        try {
            // LOGO fillname
            $fileNameLogo = rand(10, 100) . '_' . time() . "_" . $request->Logo->getClientOriginalName();
            $pathLogo = Helper::getFileUrl($request->Logo, 'uploads/events/logo/');

            // Banner fillname
            $fileNameBanner = rand(10, 100) . '_' . time() . "_" . $request->banner->getClientOriginalName();
            $pathBanner = Helper::getFileBannerUrl($request->banner, 'uploads/events/banner/');

            // Details docs fillname
            $detailsDocsPath = null;
            if ($request->hasFile('details_docs')) {
                $detailsDocs = $request->file('details_docs');
                $detailsDocsName = rand(10, 100) . '_' . time() . "_" . $detailsDocs->getClientOriginalName();
                $detailsDocsPath = $detailsDocs->storeAs('uploads/events/details_docs', $detailsDocsName, 'public');
            }

            $event = new AdminEvent();



            $event->event_name = $request->event_name;
            $event->contact_no = $request->phone_no;
            $event->location = $request->location;
            $event->event_manager_id = $request->event_manager_id;
            $event->event_date = $request->eventdate;
            $event->start_datetime = $request->start_time;
            $event->end_datetime = $request->end_time;
            $event->type = $request->event_type;
            $event->category_id = $request->category;
            $event->status = $request->state;
            $event->is_public = $request->is_public;
            $event->des = $request->description;
            $event->logo = $pathLogo;
            $event->banner = $pathBanner;
            $event->details_docs = $detailsDocsPath;





            if ($event->save()) {
                // Attach the selected sponsorsId and event_id to the event_sponsors table
                $event->sponsors()->attach($request->sponsor);
                if ($request->has('artistname')) {
                    // Attach the selected artists to the event
                    $artistIds = Artists::whereIn('artist_name', $request->input('artistname'))->pluck('aid');
                    $event->artists()->attach($artistIds);
                }
                // Commit the transaction
                DB::commit();
                return redirect()->route('manager.events.event_create')->with('success', 'Event added successfully.');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'An error occurred while adding the event.' . $e->getMessage());
        }
    }
    
    public function delete_event($eid)
    {

        DB::beginTransaction();

        try {
            // Find event details
            $data = AdminEvent::find($eid);

            if (!$data) {
                return redirect()->route('manager.events.events_list')->with('error', 'Event not found.');
            }

            // Handle logo and banner deletion
            if ($data->logo) {
                $logoPath = public_path($data->logo);
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
            }

            if ($data->banner) {
                $bannerPath = public_path($data->banner);
                if (file_exists($bannerPath)) {
                    unlink($bannerPath);
                }
            }


            // Find all related order IDs
            $orderIds = DB::table('order')->where('event_id', $eid)->pluck('order_id');

            if ($orderIds->isNotEmpty()) {
                // Delete related records in other tables
                OrderBook::whereIn('order_id', $orderIds)->delete();
                OrderItem::whereIn('order_id', $orderIds)->delete();
                JobAmount::whereIn('order_id', $orderIds)->delete();
                AdditionalExpense::whereIn('order_id', $orderIds)->delete();
                CreditOrder::whereIn('order_id', $orderIds)->delete();
                Payment_log::whereIn('order_id', $orderIds)->delete();
                // CashFlowHelper::delete(
                //     $ref_id = $orderIds,
                //     $ref_name = Order::getTableName()
                // );
                // Delete orders
                DB::table('order')->where('event_id', $eid)->delete();
            }

            // Delete event record
            $data->delete();

            // Commit transaction
            DB::commit();

            return redirect()->route('manager.events.events_list')->with('success', 'Event deleted successfully!');

        } catch (\Exception $e) {
            // Rollback on error
            DB::rollback();

            return redirect()->route('manager.events.events_list')->with('error', 'Failed to delete event: ' . $e->getMessage());
        }
    }
    public function delete_event_view($eid)
    {
        return view('manager.events.delete', compact('eid'));
    }
    public function edit_event($eid)
    {
        // Get all categories
        $categoryNames=Category::all();
        // Get event associate artists and sponsors
        $event = AdminEvent::with('artists','sponsors')->find($eid);
        // Get all artists
        $artists = Artists::all();
        // Get all active sponsors
        $sponsors = Sponsor::all();

        //Get all active managers
        $manager = Auth::guard('manager')->user();

        return view('manager.events.edit', compact('event','categoryNames','artists','sponsors','manager'));
    }
    public function downloadPdf($eid)
    {
        // Fetch the event details based on $eid
        $event = AdminEvent::findOrFail($eid);
 
        // Get the file path from the event details
        $filePath = $event->details_docs;
 
        // Check if the file exists
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }
 
         // Return the file as a download response
         $fileName = $event->event_name . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
         return Storage::disk('public')->download($filePath, $fileName, [
             'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
         ]);
    }

    public function events_list()
    {
        $manager = Auth::guard('manager')->user();

        $events = AdminEvent::with('artists', 'sponsors', 'manager')
            ->where('event_manager_id', $manager->manager_id)
            ->orderBy('eid', 'desc')
            ->get();

        return view('manager.events.list', [
            'events' => $events,
            'downloadable' => true
        ]);
    }


    public function update_event(Request $request,$eid)
    {
        //  Validate the form data
        $request->validate([
            'event_name' => 'required|string|max:100|unique:events,event_name,'.$eid.',eid',
            'phone_no' =>'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location'  => 'required|string|max:100',
            'event_manager_id'  => 'required|exists:managers,manager_id',
            'event_date' => 'required|date',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'event_type'  => 'required|string',
            'category'  => 'required|string',
            'status' => 'required|string|max:20|in:Ongoing,Completed',
            'is_public' => 'required|string|max:20|in:1,0',
            'description' => 'required|string|max:200',
            'Logo' => 'image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'details_docs' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,jfif,pdf,docx,doc|max:2048',

        ]);
        // Get this event details
        $event =AdminEvent::where('eid','=',$eid)->first();

        // Handle image upload if a new logo is provided
        if ($request->hasFile('Logo')) {
            // Check logo included in logo column
            if($event->logo){

                $image_path_logo = public_path($event->logo);
                //  Check include exist  logo
                if (file_exists($image_path_logo)) {

                    //  Remove exist logo
                    unlink($image_path_logo);
                }

            }
            $imageLogo = $request->file('Logo');
            $name = time() . '.' . $imageLogo->getClientOriginalExtension();
            $pathLogo = Helper::getFileUrl($request->Logo, 'uploads/events/logo/');
            $event->logo = $pathLogo ;
        }

        // Handle image upload if a new banner is provided
        if ($request->hasFile('banner')) {
            //  Check banner included in banner column
            if($event->banner){

                $image_path_banner = public_path($event->banner);
                // Check include exist  banner
                if (file_exists($image_path_banner)) {

                    // Remove exist banner
                    unlink($image_path_banner);
                }

            }
            // Create the new banner path
            $imageBanner = $request->file('banner');
            $nameLogo = time() . '.' . $imageBanner->getClientOriginalExtension();
            $pathBanner = Helper::getFileBannerUrl($request->banner, 'uploads/events/banner/');
            $event->banner = $pathBanner ;
        }
        // Handle the details_docs upload
        if ($request->hasFile('details_docs')) {
            $detailsDocs = $request->file('details_docs');
            $detailsDocsName = rand(10, 100) . '_' . time() . "_" . $detailsDocs->getClientOriginalName();
            $detailsDocsPath = $detailsDocs->storeAs('uploads/events/details_docs', $detailsDocsName, 'public');
            $event->details_docs = $detailsDocsPath;
        }

        // Update the artist record with the validated data
        $event->event_name = $request->event_name;
        $event->contact_no = $request->phone_no;
        $event->location = $request->location;
        $event->event_manager_id = $request->event_manager_id;
        $event->event_date = $request->event_date;
        $event->start_datetime = $request->start_time;
        $event->end_datetime = $request->end_time;
        $event->is_public = $request->is_public;
        $event->type = $request->event_type;
        $event->category_id = $request->category;
        $event->status = $request->status;
        $event->des = $request->description;

        // Save the event
        if ($event->save()) {
            if ($request->has('artistname')) {
                // Attach the selected artists to the event
                $artistIds = Artists::whereIn('artist_name', $request->input('artistname'))->pluck('aid');
                $event->artists()->sync($artistIds);
            }

            // Attach the selected sponsors to the event
            $event->sponsors()->sync($request->input('sponsor'));

        }

        // Check if the update was successful
        if ($event) {
            return redirect()->route('manager.events.events_list')->with('success', 'Event updated successfully.');
        } else {
            // Handle the case where the update failed (optional)
            return redirect()->route('manager.events.events_list')->with('error', 'Failed to update event.');
        }
    }
}
