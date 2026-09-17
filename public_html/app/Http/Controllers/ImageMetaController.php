<?php

// app/Http/Controllers/ImageMetaController.php
namespace App\Http\Controllers;

use App\Models\ImageMeta;
use App\Models\AlbumImage;
use Illuminate\Http\Request;

class ImageMetaController extends Controller
{
    // Store or update image metadata
    public function storeOrUpdate(Request $request, $aid ,$id)
    {
        $validated = $request->validate([
            'image_name' => 'required|string|max:255',
            'image_alt'  => 'required|string|max:255',
        ]);

        // Find the album image (this will fail if not found)
        $image = AlbumImage::findOrFail($aid);

        // Update or create the image meta
        ImageMeta::updateOrCreate(
            ['album_image_id' => $aid],  // Find by album_image_id
            [                             // Data to update/create
                'image_name' => $validated['image_name'],
                'image_alt'  => $validated['image_alt'],
            ]
        );

           return redirect()->route('useradmin.gallery.albumview', ['id' => $id])
        ->with('success', 'Meta Data Saved');
    }
}
