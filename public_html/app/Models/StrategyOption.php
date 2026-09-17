<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategyOption extends Model
{
    use HasFactory;

    protected $table = 'strategy_option';

    protected $fillable = ['strategy_id', 'option_id'];
    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    public function subOptions()
    {
        return $this->belongsToMany(SubOption::class, 'strategy_option_sub')
                    ->withTimestamps()
                    ->withPivot(['previous', 'next']);
    }
}
