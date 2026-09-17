<?php

// app/Models/ImageMeta.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageMeta extends Model
{
    protected $fillable = ['album_image_id', 'image_name', 'image_alt'];

    // Define the inverse relationship with AlbumImage
    public function image()
    {
        return $this->belongsTo(AlbumImage::class, 'album_image_id', 'aid');
    }
}
