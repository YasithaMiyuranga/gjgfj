<?php

namespace App\Models;

use App\Models\RentItemPackageItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentItemPackage extends Model
{
    use HasFactory;

    protected $table = 'rent_item_packages';
    protected $primaryKey = 'id';

    protected $fillable = [
        'event_id',
        'name',
        'description',
    ];

   public function rent_item_packages_items()
   {
       return $this->hasMany(RentItemPackageItem::class);
   }
    public function event()
    {
        return $this->belongsTo(AdminEvent::class);
    }
}
