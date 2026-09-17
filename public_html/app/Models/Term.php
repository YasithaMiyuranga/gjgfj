<?php

namespace App\Models;

use App\Models\SubTerm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Term extends Model
{
    use HasFactory;

    protected $table = 'terms';

    protected $fillable = [
        'agreement_template_id',
        'title',
        'description',
    ];

    public function subterms(){
        return $this->hasMany(SubTerm::class);
    }

    public function agreementTemplate(){
        return $this->belongsTo(AgreementTemplate::class);
    }
}
