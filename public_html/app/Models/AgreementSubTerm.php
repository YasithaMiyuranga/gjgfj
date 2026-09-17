<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementSubTerm extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_id',
        'agreement_term_id',
        'SubTerm_title',
        'SubTerm_description',
    ];

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    public function term()
    {
        return $this->belongsTo(AgreementTerm::class);
    }
}
