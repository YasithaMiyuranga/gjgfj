<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashFlow extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'cash_flows';
    protected $fillable = [
        'name',
        'amount',
        'date',
        'is_income',
        'is_expense',
        'ref_id',
        'ref_name',
    ];
}
