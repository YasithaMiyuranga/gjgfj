<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;
    protected $table = 'agreements';

    protected $fillable = [
        'emp_id',
        'event_id',
        'template_id',
    ];

    public function agreementTerms()
    {
        return $this->hasMany(AgreementTerm::class);
    }

    public function agreementSubTerms()
    {
        return $this->hasMany(AgreementSubTerm::class);
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
    public function template()
    {
        return $this->belongsTo(AgreementTemplate::class);
    }
    public function event()
    {
        return $this->belongsTo(AdminEvent::class, 'event_id', 'eid');
    }
    public function agreementCustomersDetail()
    {
        return $this->hasOne(AgreementCustomersDetail::class);
    }
}

