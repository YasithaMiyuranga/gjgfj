<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldOutSeats extends Model
{
    protected $table = 'soldout_seats';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ticket_id',
        'seat_number',
        'baught_date',
        'user_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
