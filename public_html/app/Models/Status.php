<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function taskTemplates()
    {
        return $this->belongsToMany(TaskTemplate::class, 'task_template_status');
    }

     public function task()
    {
        return $this->hasMany(Task::class, 'status_id');
    }

}
