<?php

namespace App\Models;

use App\Models\Agenda;
use App\Models\Artists;
use App\Models\Sponsor;
use App\Models\TaskTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminEvent extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $primaryKey = 'eid';
    protected $fillable = [
        'customer_id',
        'task_template_id',
        'event_name' ,
        'contact_no',
        'location',
        'margin',
        'event_date',
        'setup_time',
        'start_datetime',
        'end_datetime',
        'type',
        'category_id',
        'status',
        'des',
        'logo',
        'banner',
        'event_manager',
        'event_manager_id'
    ];

    protected $casts = [
        'category_id'=> 'int'
    ];

    public function artists()
    {
        return $this->belongsToMany(Artists::class, 'event_artist', 'event_id', 'artist_id')->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agents::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the sponsors associated with the event.
    */
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsor', 'event_id', 'sponsor_id')->withTimestamps();
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'event_manager_id', 'manager_id');
    }


    /**
     * Get the agendas associated with the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class, 'event_id', 'eid');
    }

    // Event belongs to event coupon list
    public function event_coupon_list()
    {
        return $this->hasMany(EventCouponList::class, 'event_id');
    }
    // Event dates belongs to event
    public function event_dates()
    {
        return $this->hasMany(EventDate::class, 'event_id');
    }
   public function orders()
   {
       return $this->hasMany(Order::class, 'event_id', 'eid');
   }
   public function agreement()
    {
        return $this->hasOne(Agreement::class, 'event_id', 'eid');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'event_id', 'eid');
    }

    public function taskTemplate()
    {
        return $this->belongsTo(TaskTemplate::class, 'task_template_id');
    }

}
