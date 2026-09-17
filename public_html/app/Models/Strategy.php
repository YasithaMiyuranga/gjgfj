<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Strategy extends Model
{
    use HasFactory;

    protected $table = 'strategies';
    protected $fillable = [
        'category_id',
        'name',
        'is_default',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function options()
    {
        return $this->belongsToMany(Option::class, 'strategy_option')->withTimestamps();
    }
    public function strategyOptions()
    {
        return $this->hasMany(StrategyOption::class);
    }
}
