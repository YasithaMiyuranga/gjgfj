<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';
    protected $fillable = [
        'event_id',
        'team_category_id',
        'team_name',
        'member_name',
        'mobile',
        'status',
        'role'
    ];

    public function event()
    {
        return $this->belongsTo(AdminEvent::class, 'event_id', 'eid');
    }

    public function teamCategory()
    {
        return $this->belongsTo(TeamCategory::class, 'team_category_id', 'id');
    }


}
