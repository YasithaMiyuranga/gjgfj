<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCredit extends Model
{
    use HasFactory;
    protected $table = 'employee_credits';
    protected $primaryKey = 'Employee_credit_id';

    protected $fillable = [
        'employee_id',
        'credit_amount',
        'credit_date',
        'credit_status',
        'paid_date',
        'payment_type',

    ];

    public function employee()
    {
        return $this->belongsTo(Employe::class, 'employee_id');
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
