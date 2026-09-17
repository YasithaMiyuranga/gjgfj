<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOption extends Model
{
    use HasFactory;

     protected $fillable = ['name'];

    public function strategyOptions()
    {
        return $this->belongsToMany(StrategyOption::class, 'strategy_option_sub')
                    ->withTimestamps();
    }
}
