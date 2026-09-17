<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaDetail extends Model
{
    use HasFactory;

    protected $table = 'agenda_details';

    protected $fillable = [
        'agenda_id',
        'title',
        'description',
        'time',
        'is_active',
    ];

    /**
     * The agenda that this agenda detail belongs to.
     *
     * @return BelongsTo
     */
    public function agenda(): BelongsTo
    {
        return $this->belongsTo(Agenda::class);
    }
}
