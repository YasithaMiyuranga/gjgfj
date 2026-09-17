<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketOwner extends Model
{
    use HasFactory;

    protected $table = 'ticket_owners';
    protected $primaryKey = 'oid';
    protected $fillable = [
        'event_id',
        'user_id',
        'email',
        'name',
        'nic',
        'phone_number',
        'address',
        'city',
        'zipcode',
        'total'
      
       
    ];
    public function ticketOrderLists()
	{
		return $this->hasMany(TicketOrderList::class);
	}
}
