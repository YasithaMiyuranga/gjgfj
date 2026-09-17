<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

/**
 * Class Employe
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $code
 * @property string|null $active
 * @property string|null $emp_type
 * @property float|null $basic_amount
 * @property float|null $etf
 * @property float|null $epf
 * @property int|null $emp_id
 * @property Carbon|null $regdate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Employe extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

	protected $table = 'employes';
    protected $primaryKey = 'emp_id';
    protected $guarded = [];
	protected $casts = [
		'email_verified_at' => 'datetime',
		'regdate' => 'datetime'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'email',
        'address',
		'email_verified_at',
		'password',
		'code',
		'active',
        'mobile',
        'nic',
		'regdate',
        'emp_type',
        'basic_amount',
        'etf',
        'epf',
        'employer_con_etf_amount',
        'employer_con_epf_amount',
        'employee_epf',
        'employee_con_epf_amount',
        'employer_con_total_amount',
        'net_salary'

	];


	public function monthly_salaries()
    {
        return $this->hasMany(MonthlySalary::class, 'emp_id');
    }

    public function employeeCredits()
    {
        return $this->hasMany(EmployeeCredit::class, 'employee_id');
    }
    public function jobamounts()
    {
        return $this->hasMany(JobAmount::class, 'emp_id');
    }


}
