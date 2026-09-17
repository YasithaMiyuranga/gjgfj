<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTermsCondition extends Model
{
    use HasFactory;

    protected $table = 'order_terms_conditions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'terms_and_conditions_id',
        'terms_description',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function termsAndConditions()
    {
        return $this->belongsTo(TermsAndConditions::class);
    }
}
