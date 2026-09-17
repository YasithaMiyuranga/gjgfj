<?php

namespace App\Models;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageImage extends Model
{
    use HasFactory;
    protected $table = 'package_images';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'package_id',
        'image_path'
    ];
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }
}
