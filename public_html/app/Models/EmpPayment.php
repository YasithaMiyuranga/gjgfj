<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class EmpPayment
 *
 * @property int $id
 * @property int $emp_id
 * @property string $name
 * @property float $pay_amount
 * @property Carbon $date
 * @property string $emp_type
 * @property string $payment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmpPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'name',
        'pay_amount',
        'credit_amount',
        'date',
        'emp_type',
        'payment_status',
    ];

    protected $dates = [
        'date',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
