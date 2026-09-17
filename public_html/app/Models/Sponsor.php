<?php

namespace App\Models;

use App\Models\AdminEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsor extends Model
{
    use HasFactory;

    protected $table = 'sponsors';
    protected $primaryKey = 'sponsor_id';

    const TYPE_STATUSES_ACTIVE = "active";
    const TYPE_STATUSES_INACTIVE = "inactive";

    protected $fillable = [
        'sponsor_name',
        'sponsor_phone',
        'sponsor_logo',
        'sponsor_link',
        'status',
    ];

    /**
     * Get the sponsors associated with the event.
    */
    public function events()
    {
        return $this->belongsToMany(AdminEvent::class, 'event_sponsor', 'event_id', 'sponsor_id')->withTimestamps();
    }

    public static function getStatuses()
    {
        return [
            self::TYPE_STATUSES_ACTIVE => 'active',
            self::TYPE_STATUSES_INACTIVE => 'inactive',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           if(!in_array($model->status, self::getStatuses())) {
               throw new \Exception("Status is not valid");
           }
        });
    }
}
