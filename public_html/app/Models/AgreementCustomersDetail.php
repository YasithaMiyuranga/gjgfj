<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementCustomersDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_id',
        'customer_id',
        'customer_name',
        'nic',
        'location',
        'company_name',
        'customer_phone',
    ];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }
}
