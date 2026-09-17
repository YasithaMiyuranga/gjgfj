<?php

namespace App\Models;

use App\Models\AdminEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artists extends Model
{
    use HasFactory;
    protected $table = 'artist';
    protected $primaryKey = 'aid';
    protected $fillable = [
        'artist_name',
        'phone_no',
        'image',
        'visible',
        'status',
    ];
    public function events()
    {
        return $this->belongsToMany(AdminEvent::class, 'event_artist', 'artist_id', 'event_id')->withTimestamps();
    }
}
