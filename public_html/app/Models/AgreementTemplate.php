<?php

namespace App\Models;

use App\Models\Term;
use App\Models\SubTerm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgreementTemplate extends Model
{
    use HasFactory;
    protected $table = 'agreement_templates';

    protected $fillable = [
        'agreement_category_id',
        'name',
        'content',
        'is_default',
    ];

    public function agreementCategory()
    {
        return $this->belongsTo(AgreementCategory::class);
    }

    public function terms(){
        return $this->hasMany(Term::class, 'agreement_template_id');
    }


}
