<?php

namespace App\Models;

use App\Models\AdminEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventCustomerCare extends Model
{
    use HasFactory;

    protected $table = 'event_customer_cares';

    protected $fillable = [
        'event_id',
        'email',
        'address',
        'whatsapp_number',
    ];

   public function AdminEvent()
   {
       return $this->belongsTo(AdminEvent::class, 'event_id', 'eid');
   }
}
