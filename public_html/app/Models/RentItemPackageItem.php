<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentItemPackageItem extends Model
{
    use HasFactory;

    protected $table = 'rent_item_package_items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'rent_item_package_id',
        'item_id',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function rent_item_package()
    {
        return $this->belongsTo(RentItemPackage::class);
    }
}
