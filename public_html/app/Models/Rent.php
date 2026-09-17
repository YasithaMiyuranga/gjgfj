<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rent
 *
 * @property int $rent_id
 * @property int $employee_id
 * @property int $customer_id
 * @property string $rent_status
 * @property string|null $received_status
 * @property string|null $note
 * @property string|null $employee_name
 * @property string|null $customer_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|RentItem[] $rent_items
 *
 * @package App\Models
 */
class Rent extends Model
{
	protected $table = 'rent';
	protected $primaryKey = 'rent_id';

	protected $casts = [
		'employee_id' => 'int',
		'customer_id' => 'int'
	];

	protected $fillable = [
		'employee_id',
        'event_id',
        'order_id',
        'rent_item_package_id',
		'customer_id',
		'rent_status',
		'received_status',
		'note',
		'employee_name',
		'customer_name'
	];

	public function rent_items()
	{
		return $this->hasMany(RentItem::class);
	}

	public function damage_items()
	{
		return $this->hasMany(DamageItem::class);
	}
}
