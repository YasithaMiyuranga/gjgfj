<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentUpdateHistory extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'rent_update_history';

    // Primary key
    protected $primaryKey = 'id';

    // Mass assignable attributes
    protected $fillable = [
        'rent_id',
        'employee_id',
        'action',
        'item_id',
        'previous_quantity',
        'current_quantity',
        'updated_quantity',
    ];

    /**
     * Relationship with Rent model.
     */
    public function rent()
    {
        return $this->belongsTo(Rent::class, 'rent_id');
    }

    /**
     * Relationship with Employee model.
     */
    public function employee()
    {
        return $this->belongsTo(Employe::class, 'employee_id');
    }

    /**
     * Relationship with Item model.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
