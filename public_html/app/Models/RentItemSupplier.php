<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentItemSupplier extends Model
{
    use HasFactory;
    protected $table = 'rent_item_supplier';
    protected $fillable = [
        'rent_item_id',
        'supplier_id',
        'quantity',
        'price',
    ];
    public function rentItem(): BelongsTo
    {
        return $this->belongsTo(RentItem::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

}
