<?php

namespace App\Http\Controllers\events;

use App\Models\Sponsor;
use App\Models\AdminEvent;
use App\Http\Helper\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SponsorController extends Controller
{

    /**
     * Get all sponsors
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsor_list()
    {
        $sponsors = Sponsor::all();

        return view('Admin_events.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new sponsor
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsor_create()
    {
        return view('Admin_events.sponsors.add');
    }

    /**
     * Store a newly created sponsor in storage
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sponsor_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sponsor_name' => 'required|string|max:255',
            'phone_no' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:5120',
            'status' => 'required|string|in:active,inactive',
            'website_url' => 'nullable|string|url',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
        }

        // Upload the sponsor image
        if ($request->hasFile('image')) {
            $fileName = rand(10, 100) . '_' . time() . "_" . $request->image->getClientOriginalName();
            $path = Helper::getFileUrl($request->image, 'uploads/sponsors/');
        }

        $data = [
            'sponsor_name' => $request->sponsor_name,
            'sponsor_phone' => $request->phone_no,
            'sponsor_logo' => $path,
            'status' => $request->status,
            'sponsor_link' => $request->website_url,
        ];

        $sponsor = Sponsor::create($data);

        if ($sponsor) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Sponsor Added Successfully'], 200);
            }
        } else {
            // For AJAX requests, return error response
            if ($request->ajax()) {
                return response()->json(['message' => 'Sponsor Not Added'], 500);
            }
        }
    }

    /**
     * Show the form for editing the specified sponsor
     *
     * @param  \App\Models\Sponsor $sponsor
     * @return \Illuminate\Http\Response
     */
    public function sponsor_edit(Sponsor $sponsor)
    {
        return view('Admin_events.sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified sponsor in storage
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Sponsor $sponsor
     * @return \Illuminate\Http\Response
     */
    public function sponsor_update(Request $request, Sponsor $sponsor)
    {
        $validator = Validator::make($request->all(), [
            'sponsor_name' => 'required|string|max:255',
            'phone_no' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:5120',
            'status' => 'required|string|in:active,inactive',
            'website_url' => 'nullable|string|url',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            //check sponsor image included in sponsor_logo column
            if ($sponsor->sponsor_logo) {
                $image_path = public_path($sponsor->sponsor_logo);

                if (file_exists($image_path)) {
                    //remove exist image
                    unlink($image_path);
                }
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $path = Helper::getFileUrl($request->image, 'uploads/sponsors/');
            $sponsor->sponsor_logo = $path;
        }

        // Update the sponsor
        $isSaved = $sponsor->update([
            'sponsor_name' => $request->sponsor_name,
            'sponsor_phone' => $request->phone_no,
            'status' => ($request->status == 'active')? Sponsor::TYPE_STATUSES_ACTIVE : Sponsor::TYPE_STATUSES_INACTIVE,
            'sponsor_link' => $request->website_url,
        ]);


        if ($isSaved) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Sponsor Updated Successfully'], 200);
            }
        }
    }

    /**
     * Display the form for deleting the specified sponsor
     *
     * @param  \App\Models\Sponsor $sponsor
     * @return \Illuminate\Http\Response
     */
    public function sponsor_delete_view(Sponsor $sponsor)
    {
        return view('Admin_events.sponsors.delete', compact('sponsor'));
    }

    /**
     * Remove the specified sponsor from storage
     *
     * @param  \App\Models\Sponsor $sponsor
     * @return \Illuminate\Http\Response
     */
    public function sponsor_delete(Sponsor $sponsor)
    {
        $sponsor->delete();

        return redirect()->route('useradmin.events.sponsor.list')->with('success', 'Sponsor Deleted Successfully');
    }
    /**
     * Show the form for assigning sponsors to the event
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $eid
     * @return \Illuminate\Http\Response
     */
    public function sponsor_assign(Request $request, $eid)
    {
        $event = AdminEvent::where('eid', $eid)->first();
        if( !$event){
            return redirect()->back()->with('error', 'Event not found.');
        }
        // Get all sponsors that are not assigned to the event
        $sponsors = Sponsor::whereNotIn('sponsor_id', $event->sponsors()->pluck('sponsors.sponsor_id'))->get();
        return view('Admin_events.sponsors.assign', compact('sponsors', 'event'));
    }

    /**
     * Assign the specified sponsor to the event
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $eid
     * @return \Illuminate\Http\Response
     */
    public function sponsor_assign_store(Request $request, $eid)
    {
        $event = AdminEvent::where('eid', $eid)->first();
        $sponsor = Sponsor::find($request->sponsor_id);
        if( !$event){
            return redirect()->back()->with('error', 'Event not found.');
        }
        if( !$sponsor){
            return redirect()->back()->with('error', 'Sponsor not found.');
        }
        // Attach the sponsor to the event
        $event->sponsors()->attach($sponsor);

        if ($request->ajax()) {
            return response()->json(['message' => 'Sponsor Assigned Successfully'], 200);
        }
    }
}
