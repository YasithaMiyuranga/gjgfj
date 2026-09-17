<?php

namespace App\Models;

use App\Models\AdminEvent;
use App\Models\AgendaDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas';

    protected $fillable = [
       'event_id',
       'date',
       'date_name',
       'is_active',
    ];



    /**
     * Get the event that the agenda belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function event(): BelongsTo
    {
        return $this->belongsTo(AdminEvent::class, 'event_id', 'eid');
    }

    /**
     * Get the agenda details associated with the agenda.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agendaDetails(): HasMany
    {
        return $this->hasMany(AgendaDetail::class);
    }

}
