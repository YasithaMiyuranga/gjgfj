<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementCategory extends Model
{
    use HasFactory;

    protected $table = 'agreement_categories';

    protected $fillable = [
        'name',
        'description',
    ];
}
