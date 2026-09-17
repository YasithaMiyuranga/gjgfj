<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\TermsAndConditions;

/**
 * Class Order
 *
 * @property int $order_id
 * @property string|null $customer_name
 * @property Carbon|null $booking_date
 * @property Carbon|null $inv_date
 * @property string|null $order status
 * @property float|null $net_amount
 * @property float|null $discount
 * @property float|null $discount_amount
 * @property float|null $grand_total
 * @property float|null $tax
 * @property float|null $transport
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|OrderItem[] $order_items
 *
 * @package App\Models
 */
class Order extends Model
{
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    protected $table = 'order';
	protected $primaryKey = 'order_id';

	protected $casts = [
		'booking_date' => 'datetime',
		'inv_date' => 'datetime',
		'net_amount' => 'float',
		'total_discount' => 'float',
		'grand_total' => 'float',
        'pay_amount'=> 'float',
        'final_amount'=> 'float',
        'additional_price' => 'float',
		'tax' => 'float',
		'transport' => 'float',
        'start_time' =>'datetime',
        'end_time' =>'datetime',
	];

	protected $fillable = [
		'event_id',
        'bank_id',
		'customer_name',
        'name',
        'order_type',
		'booking_date',
        'location',
        'event_name',
        'start_time',
        'end_time',
        'customer_phone',
		'inv_date',
		'order_status',
        'category',
		'net_amount',
		'total_discount',
		'grand_total',
        'pay_amount',
        'final_amount',
        'additional_price',
		'tax',
		'transport',
        'special_note'

	];

	public function order_items()
	{
		return $this->hasMany(OrderItem::class, 'order_id');
	}

	public function credit_order()
	{
		return $this->hasMany(CreditOrder::class, 'order_id');
	}

	public function additional_expenses()
	{
		return $this->hasMany(AdditionalExpense::class, 'order_id');
	}

	//*** Function to get table name ***//
	public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function termsAndConditions()
    {
        return $this->belongsTo(TermsAndConditions::class, 'id');
    }
    public function termsConditions()
    {
        return $this->hasMany(OrderTermsCondition::class);
    }
    public function event()
    {
        return $this->belongsTo(AdminEvent::class , 'event_id');
    }

}
