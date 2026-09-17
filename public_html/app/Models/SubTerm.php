<?php

namespace App\Models;

use App\Models\Term;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTerm extends Model
{
    use HasFactory;

    protected $table = 'sub_terms';

    protected $fillable = [
        'term_id',
        'title',
        'description',
    ];

    public function Term()
    {
        return $this->belongsTo(Term::class);
    }
}
