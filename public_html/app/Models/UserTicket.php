<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTicket extends Model
{
    use HasFactory;

    protected $table = 'user_tickets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ticket_id',
        'event_id',
        'user_id',
        'event_name',
        'user_name',
        'user_phone_number',
        'qr_code',
        'bar_code',
        'buy_date',
        'ticket_status',
        'price'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class); // Adjust if your model name or foreign key differs
    }

}
