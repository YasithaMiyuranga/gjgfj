<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    use HasFactory;
    protected $table = 'agents';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'address',
        'city',
        'state',
        'zip',
        'status',
        'type',
    ];

    public function events()
    {
        return $this->belongsToMany(AdminEvent::class);
    }
}
