<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketOrderList extends Model
{
    use HasFactory;

    protected $table = 'ticket_order_lists';
    protected $primaryKey = 'id';
    protected $fillable = [
        'owner_id',
        'ticket_user_id',
        'coupon_id',
        'name',
        'quantity',
        'discount',
        'amount',
        'coupon_code'
    
    
    
    ];

    public function ticketOwner()
	{
		return $this->belongsTo(TicketOwner::class);
	}
}
