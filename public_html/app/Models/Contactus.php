<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    use HasFactory;
    protected $table = 'contactus';
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'customer_name',
        'telephone',
        'email',
        'comment',
        'status',
    ];
}
