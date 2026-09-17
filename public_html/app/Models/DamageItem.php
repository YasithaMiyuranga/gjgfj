<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageItem extends Model
{
    use HasFactory;

    protected $table = 'damage_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'rent_id',
        'rent_item_id',
        'quantity',
        'damage',
        'status',
    ];

    public function rent()
    {
        return $this->belongsTo(Rent::class, 'rent_id');
    }

    public function rentItem()
    {
        return $this->belongsTo(RentItem::class, 'rent_item_id');
    }



}
