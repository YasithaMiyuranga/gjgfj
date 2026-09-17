<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerRequirement extends Model
{
    use HasFactory;

    protected $table = 'customer_requirements';

    protected $fillable = [
        'name',
        'description'
    ];

}
