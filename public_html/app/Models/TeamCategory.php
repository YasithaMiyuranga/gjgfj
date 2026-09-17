<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class TeamCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'team_name',
    ];

    public function event()
    {
        return $this->belongsTo(AdminEvent::class, 'event_id','eid');
    }
    public function teams()
    {
        return $this->hasMany(Team::class, 'team_category_id', 'id');
    }
}
