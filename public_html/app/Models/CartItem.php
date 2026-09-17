<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cart_id',
        'item_id',
        'quantity',
        'price',
       
    ];
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
