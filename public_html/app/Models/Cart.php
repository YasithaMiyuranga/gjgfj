<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'cart_id';
    protected $fillable = [
        'user_id',
       
    ];
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public static function getCartAllData($userId)
    {
        return Cart::select('carts.*', 'cart_items.*', 'item.image', 'item.item_name', 'item.rent_price')
            ->join('cart_items', 'carts.cart_id', '=', 'cart_items.cart_id')
            ->join('item', 'cart_items.item_id', '=', 'item.item_id')
            ->where('user_id', $userId)
            ->get();
    }

}
