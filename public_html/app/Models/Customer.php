<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 *
 * @property int $customer_id
 * @property string|null $customer_name
 * @property string $nic
 * @property string|null $customer_phone
 * @property string|null $location
 * @property string|null $address
 * @property string|null $city
 * @property string|null $status
 * @property string|null $points
 * @property Carbon|null $register_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Customer extends Model
{
	protected $table = 'customer';
	protected $primaryKey = 'customer_id';

	protected $casts = [
		'register_date' => 'datetime'
	];

	protected $fillable = [
		'customer_name',
        'company_name',
        'customer_phone',
        'location',
		'nic',
		'address',
		'city',
		'status',
		'points',
		'register_date'
	];

    public function events() {
        return $this->hasMany(AdminEvent::class);
    }
}
