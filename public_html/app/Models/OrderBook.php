<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderBook
 *
 * @property int $id
 * @property Carbon $booking_date
 * @property int $order_id
 * @property string $customer_name
 * @property string $name
 * @property string $order_status
 * @property bool $is_pay
 * @property float $pay_amount
 *
 * @property Order $order
 *
 * @package App\Models
 */
class OrderBook extends Model
{

	protected $table = 'order_book';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'booking_date' => 'datetime',
		'order_id' => 'int',
		'is_pay' => 'bool',
		'pay_amount' => 'float',
        'total_balance' =>'float',
        'payment_amount' =>'float',
        'start_time' =>'datetime',
        'end_time' =>'datetime',
	];

	protected $fillable = [
		'booking_date',
		'order_id',
        'item_name',
		'customer_name',
        'event_name',
        'start_time',
        'end_time',
        'customer_phone',
		'name',
		'order_status',
		'is_pay',
		'pay_amount',
        'total_balance',
        'location',
        'payment_amount'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
