<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualExpensesIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'name',
        'amount',
        'type',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
