<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    use HasFactory;

    protected $table = 'event_dates';

    protected $fillable = [
        'event_id',
        'start_time',
        'end_time',
        'date',
    ];

    public function event()
    {
        return $this->belongsTo(AdminEvent::class);
    }
}
