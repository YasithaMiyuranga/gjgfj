<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = [
        'task_template_id',
        'task_name',
        'prev_task_id',
        'next_task_id',
        'task_duration',
        'status',
        'priority',
        'status_id',
    ];

    public function template()
    {
        return $this->belongsTo(TaskTemplate::class, 'task_template_id');
    }

    public function teamAssignments()
    {
        return $this->hasMany(TaskTeam::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
