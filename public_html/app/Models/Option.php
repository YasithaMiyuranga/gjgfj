<?php

namespace App\Models;

use App\Models\Strategy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;
    protected $table = 'options';
    protected $fillable = [
        'strategy_id',
        'name',
    ];
    public function strategies()
    {
        return $this->belongsToMany(Strategy::class, 'strategy_option')->withTimestamps();
    }

    public function strategyOptions() // To access pivot records
    {
        return $this->hasMany(StrategyOption::class);
    }
}
