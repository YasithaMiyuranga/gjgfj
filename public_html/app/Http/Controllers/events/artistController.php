<?php

namespace App\Http\Controllers\events;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Artists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class artistController extends Controller
{
    function artist_list()
    {
        $artists = Artists::all();
        return view('Admin_events.artists.index', compact('artists'));
    }

    function add_artist()
    {
        return view('Admin_events.artists.add');
    }
    function store_artist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_name' => 'required|string|max:255',
            'phone_no' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:5120',
            'visible' => 'required|string|in:yes,no',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // HTTP status code for unprocessable entity
            }
            // For non-AJAX requests, redirect back with errors
            return redirect()->back()->withErrors($validator)->withInput();

        }
        if ($request->hasFile('image')) {

            $fileName = rand(10, 100) . '_' . time() . "_" . $request->image->getClientOriginalName();
            $path = Helper::getFileUrl($request->image, 'uploads/artists/');
        }

        $artist = new Artists;
        $artist->artist_name = $request->artist_name;
        $artist->phone_no = $request->phone_no;
        $artist->visible = $request->visible;
        $artist->status = $request->status;
        $artist->image = $path;

        if ($artist->save()) {

            // For AJAX requests, return success response
            if ($request->ajax()) {
                return response()->json(['message' => 'Artist Added Successfully'], 200);
            }
        } else {

            // For AJAX requests, return error response
            if ($request->ajax()) {
                return response()->json(['message' => 'Artist Not Added'], 500);
            }
        }
    }

    function edit_artist($aid)
    {
        $artist = Artists::where('aid', '=', $aid)->first();
        return view('Admin_events.artists.edit', compact('artist'));
    }

    //*** FUNCTION TO UPDATE A SPECIFIC ARTIST IN THE SYSTEM ***/
    function update_artist(Request $request, $aid)
    {
        $validator = Validator::make($request->all(), [
            'artist_name' => 'required|string|max:255',
            'phone_no' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:5120',
            'visible' => 'required|string|in:yes,no',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                // Return errors in JSON format for AJAX requests
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            // For non-AJAX requests, redirect back with errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the artist record from the database
        $artist = Artists::where('aid', '=', $aid)->first();

        if (!$artist) {
            return redirect()->route('useradmin.events.artist')->with('error', 'Artist not found.');
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            //check artist image included in image column
            if ($artist->image) {
                $image_path = public_path($artist->image);

                if (file_exists($image_path)) {

                    //remove exist image
                    unlink($image_path);
                }
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $path = Helper::getFileUrl($request->image, 'uploads/artists/');
            $artist->image = $path;
        }

        // Update the artist record with the validated data
        $artist->update([
            'artist_name' => $request->artist_name,
            'phone_no' => $request->phone_no,
            'visible' => $request->visible,
            'status' => $request->status,
        ]);

        if ($artist->save()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Artist Updated Successfully'], 200);
            }

        }
    }
    function delete_artist_view($id)
    {
        return view('Admin_events.artists.delete', compact('id'));
    }

    //*** FUNCTION TO DELETE ARTIST IN THE SYSTEM ***/
    function delete_artist($aid)
    {
        // Find the artist record from the database
        $data = Artists::find($aid);

        if (!$data) {
            return redirect()->route('useradmin.events.artist')->with('error', 'Artist not found.');
        }

        if ($data->image) {

            $image_path = public_path($data->image);

            if (file_exists($image_path)) {

                unlink($image_path);
            }
        }

        if ($data->delete()) {
            return redirect()->route('useradmin.events.artist')->with('success', 'Artist deleted successfully!');
        } else {

            return redirect()->route('useradmin.events.artist')->with('error', 'Artist not deleted.');
        }
    }
}
