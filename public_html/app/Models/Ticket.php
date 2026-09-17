<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'eid',
        'tickets_category',
        'price',
        'currency',
        'number_of_tickets',
        'baught_tickets_count',
        'initial_tickets_count'
    ];

    public function event()
	{
		return $this->belongsTo(AdminEvent::class, 'eid', 'eid');
	}
}
