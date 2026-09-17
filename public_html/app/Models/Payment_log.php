<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_log extends Model
{
    use HasFactory;
    public $table = 'payment_logs';
    public $primaryKey = 'payment_log_id';

    protected $fillable = [
        'credit_order_id',
        'order_id',
        'paid_amount',
        'paid_date',
        'payment_type',
    ];
}
