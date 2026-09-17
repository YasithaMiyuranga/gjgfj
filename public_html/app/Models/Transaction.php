<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'event_id',
        'user_id',
        'agent_id',
        'transaction_id',
        'amount',
        'buyer_phone_number',
        'nic',
    ];

    // Define the relationship to the Agent model (assuming there's an Agent model)
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }


    public function event(): BelongsTo
    {
        return $this->belongsTo(AdminEvent::class, 'event_id', 'eid');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
    

}   

