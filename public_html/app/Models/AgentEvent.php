<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentEvent extends Model
{
    use HasFactory;

    protected $table = 'agent_event';

    public $timestamps = true;

    public $primaryKey = 'id';

    protected $fillable = [
        'agent_id',
        'event_id',
    ];

    // Store a new agent_event in the database.
    public static function storeAgentEvent($agent_id, $event_id)
    {
        // Create a new agent_event
        $agent_event = new AgentEvent;
        $agent_event->agent_id = $agent_id;
        $agent_event->event_id = $event_id;
        $agent_event->save();

        return $agent_event;
    }

    // Update or create an agent_event in the database.
    public static function updateOrCreateAgentEvent($agent_id, $event_id)
    {
        // Update or create the agent_event
        $agent_event = AgentEvent::updateOrCreate(
            ['agent_id' => $agent_id, 'event_id' => $event_id],
            ['agent_id' => $agent_id, 'event_id' => $event_id]
        );

        return $agent_event;
    }

}
