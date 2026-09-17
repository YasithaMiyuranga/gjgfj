<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlowLog extends Model
{
    use HasFactory;
    protected $table = 'cash_flow_logs';

    protected $fillable = [
        'cashflow_id',
        'action',
        'date',
        'previous_amount',
        'current_amount',
        'type',
    ];

    public function cashFlow()
    {
        return $this->belongsTo(CashFlow::class, 'cashflow_id');
    }
}
