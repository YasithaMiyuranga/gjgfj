<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPackageItem extends Model
{
    use HasFactory;
    protected $table = 'customer_package_item';
    protected $primaryKey = 'package_item_id';
    public $timestamps = false;
    protected $fillable = [
        'package_id',
        'image',
        'item_id',
        'item_name',
        'quantity',
        'price',
        'amount',
        // Add any other attributes you want to allow for mass assignment
    ];

    PUBLIC function customerPackage()
    {
        return $this->belongsTo(CustomerPackage::class, 'package_id');
    }
}
