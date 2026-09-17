<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPackage extends Model
{
    use HasFactory;

    protected $table = 'customer_packages';
    public $timestamps = false;
    protected $primaryKey = 'package_id'; 
    protected $fillable = [
		'customer_name',
		'mobile_no',
		'location',
		'category',
		'starttime',
		'endtime',
		'price',
		'detail',
        'status',
        'type'
	];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerPackageItem()
    {
        return $this->hasMany(CustomerPackageItem::class, 'package_id');
    }
}
