<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditOrder extends Model
{
    use HasFactory;
    public $table = 'credit_orders';
    public $primaryKey = 'credit_order_id';

    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_name',
        'total_amount',
        'credit_amount',
        'booking_date'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

  
}
