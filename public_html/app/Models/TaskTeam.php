<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\TeamCategory;

class TaskTeam extends Model
{
    use HasFactory;

    protected $table = 'task_teams';
    protected $fillable = [
        'task_id',
        'team_category_id',
        'team_member_id',
        'member_name',
        'role',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function teamCategory()
    {
        return $this->belongsTo(TeamCategory::class);
    }


}
