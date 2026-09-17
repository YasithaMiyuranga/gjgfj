<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EquipmentWastage extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'quantity',
        'reason',
        'wasted_on',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
