<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementTerm extends Model
{
    use HasFactory;

    protected $table = 'agreement_terms';

    protected $fillable = [
        'agreement_id',
        'order_number',
        'title',
        'description',
    ];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    public function agreementSubTerms()
    {
        return $this->hasMany(AgreementSubTerm::class);
    }
}
