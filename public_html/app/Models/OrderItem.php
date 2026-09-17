<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $item_id
 * @property string|null $name
 * @property int $quantity
 * @property float|null $unit_price
 * @property float|null $discount
 * @property float|null $amount
 * @property string|null $customer_visible_item
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Order $order
 *
 * @package App\Models
 */
class OrderItem extends Model
{
	protected $table = 'order_item';

	protected $casts = [
		'order_id' => 'int',
		'item_id' => 'int',
		'quantity' => 'int',
		'rent_price' => 'float',
		'discount' => 'float',

	];

	protected $fillable = [
		'order_id',
		'item_id',
        'item_name',
        'description',
		'quantity',
		'rent_price',
		'discount',

	];

	public function order()
	{
		return $this->belongsTo(Order::class, 'order_id', 'order_id');
	}


}
