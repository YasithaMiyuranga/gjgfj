<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class MonthlySalary
 *
 * @property int $id
 * @property int $emp_id
 * @property string $name
 * @property string $emp_type
 * @property float $basic_amount
 * @property float $allowance_amt
 * @property float $etf
 * @property float $epf
 * @property int $job_count
 * @property float $work_payment
 * @property float $loan_amount
 * @property float $extra_payment
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property float $monthly_total
 * @property string $salary_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MonthlySalary extends Model
{
    protected $table = 'monthly salary';
    protected $primaryKey = 'id';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'basic_amount' => 'float',
        'allowance_amt' => 'float',
        'etf' => 'float',
        'epf' => 'float',
        'net_salary' => 'float', // Add this line to the original code
        'work_payment' => 'float',
        'loan_amount' => 'float',
        'extra_payment' => 'float',
        'monthly_total' => 'float',
    ];

    protected $fillable = [
        'emp_id',
        'name',
        'emp_type',
        'basic_amount',
        'allowance_amt',
        'etf',
        'epf',
        'net_salary', // Add this line to the original code
        'job_count',
        'work_payment',
        'loan_amount',
        'extra_payment',
        'start_date',
        'end_date',
        'monthly_total',
        'salary_status',
    ];

    /**
     * Get the employee associated with the monthly salary.
     */
    public function employee()
    {
        return $this->belongsTo(Employe::class, 'emp_id');
    }
}
