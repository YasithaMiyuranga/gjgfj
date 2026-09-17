<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCouponList extends Model
{
    use HasFactory;

    protected $table = 'event_coupon_lists';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'coupon_no',
        'name',
        'event_date',
        'discount_percentage',
        'status',

    ];

    // Event coupon list belongs to an event
    public function event()
    {
        return $this->belongsTo(AdminEvent::class, 'event_id');
    }

}
