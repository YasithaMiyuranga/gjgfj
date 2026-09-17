<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Album;
use App\Models\AlbumImage;
use App\Models\Utility;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function viewgallery()
    {
        $viewgallery =  Album::orderByDesc('id')->get(); //Get decending orders
        return view('Gallery.gallery', compact('viewgallery'));
    }

    public function addgallery()
    {
        return view('Gallery.addgallery');
    }

    public function store(Request $request)
    {
        $rules = [
            'album_images' => 'required',
        ];
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'date' => 'nullable|string',
            'event' => 'required|string|max:255',
            'album_images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);
        $fileName = rand(10, 100) . '_' . time() . "_" . $request->album_images->getClientOriginalName();
        $path = Helper::getFileUrl($request->album_images, 'uploads/gallery/');
        $album = new Album();
        $album->name = $request->name;
        $album->description = $request->description;
        $album->tags = $request->tags;
        $album->date = $request->date;
        $album->event = $request->event;
        $album->album_images = $path;
        // $album->save();
        if ($album->save()) {

            return redirect()->route('useradmin.gallery.view')->with('success', 'Gallery Added successfully!');
        } else {
            return redirect()->route('useradmin.gallery.view')->with('error', 'Gallery Not Added successfully!');
        }
    }

    public function album_view($id)
    {
        $view_albums =  AlbumImage::where('album_id', $id)->get();
        return view('Gallery.album_view', compact('view_albums'));
    }
    public function addalbum()
    {
        return view('Gallery.addalbum');
    }


    //gallery album
    public function albumstore(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'galleryidtxt' => 'required',
            'album_images' => 'required|array|min:1', // Ensure at least one image is selected
            'album_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000', // Validation for each image
            'status' => 'required|string',
        ]);

        $id = $validatedData['galleryidtxt'];  // Access validated gallery ID
        $status = $validatedData['status'];    // Access validated status

        // Loop through the uploaded images and save each one
        foreach ($request->file('album_images') as $image) {
            $album_images = new AlbumImage();
            $album_images->album_id = $id;
            $album_images->image = Helper::getFileUrl($image, 'uploads/gallery/'); // Assuming Helper::getFileUrl is handling the file storage
            $album_images->status = $status; // Use validated status
            $album_images->save();
        }

        // Return success response
        return redirect()->route('useradmin.gallery.albumview', ['id' => $id])
            ->with('success', 'Gallery Album Added successfully!');
    }



    public function deletegallery($id)
    {

        // get album deatils
        $data = Album::find($id);

        //check and delete album main image
        if ($data->album_images) {

            $image_path = public_path($data->album_images);

            if (file_exists($image_path)) {

                unlink($image_path);
            }
        }


        //delete this gallery included other images

        //find album images
        $albumImages = AlbumImage::where('album_id', '=', $id)->get();


        foreach ($albumImages as $albumImage) {
            $image_path_album = public_path($albumImage->image);



            if (file_exists($image_path_album)) {


                unlink($image_path_album);
            }
            $albumImage->delete();
        }

        $data->delete();
        return redirect()->route('useradmin.gallery.view')->with('success', 'Album Delete successfully!');
    }
    public function deletealbum($id)
    {
        $data = AlbumImage::find($id);

        if ($data->image) {
            $image_path = public_path($data->image);
            if (file_exists($image_path)) {

                unlink($image_path);
            }
        }
        $data->delete();
        return redirect()->back()->with('success', 'Album Delete successfully!');
    }
    // Testing code starts
    //    public function store(Request $request)
    //    {
    //        $imageName = time().'.'.$request->album_images->extension();
    //        $request->album_images->move(public_path('uploads'), $imageName);

    //        $sideterm = new Album;

    //        $sideterm->name = $request->input('name');
    //        $sideterm->description = $request->input('description');
    //        $sideterm->tags = $request->input('tags');
    //        $sideterm->album_images =$imageName;;
    //        $sideterm->date = $request->input('date');
    //        $sideterm->event = $request->input('event');
    //        $sideterm->save();
    //        return back()->with('status', 'Data updated successfully');
    //    }


}
