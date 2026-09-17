<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Loan
 *
 * @property int $id
 * @property int $emp_id
 * @property string $name
 * @property Carbon $date
 * @property float $loan_amount
 * @property string $status
 * @property string $payment_methods
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Loan extends Model
{
    protected $fillable = [
        'emp_id',
        'name',
        'date',
        'loan_amount',
        'status',
        'payment_methods',
    ];

    protected $dates = [
        'date',
    ];

}

