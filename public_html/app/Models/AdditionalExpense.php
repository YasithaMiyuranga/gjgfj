<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalExpense extends Model
{
    use HasFactory;

    protected $table = "additional_expenses";
    protected $primaryKey = "id";

    protected $fillable = [
        'order_id',
        'event_id',
        'expense_name',
        'amount',
        'description',
        'expense_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
