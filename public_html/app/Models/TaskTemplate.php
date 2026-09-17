<?php

namespace App\Models;

use App\Models\AdminEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskTemplate extends Model
{
    use HasFactory;

    protected $table = 'task_templates';

    protected $fillable = [
        'category_id',
        'template_name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function events()
    {
        return $this->hasMany(AdminEvent::class, 'task_template_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_template_id');
    }

    public function statuses()
    {
        return $this->belongsToMany(Status::class, 'task_template_status');
    }

}
