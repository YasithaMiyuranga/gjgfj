<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseOrder
 *
 * @property int $id
 * @property int $supplier_id
 * @property float|null $total_price
 * @property string $invoice_number
 * @property string|null $pay_type
 * @property float|null $payment_amount
 * @property float|null $balance
 * @property float|null $discount_percentage
 * @property float|null $discount_amount
 * @property float|null $grand_total
 * @property Carbon $purchase_date
 *
 * @property Collection|PurchaseOrderItem[] $purchase_order_items
 *
 * @package App\Models
 */
class PurchaseOrder extends Model
{
	protected $table = 'purchase_order';
	public $timestamps = false;

	protected $casts = [
		'supplier_id' => 'int',
		'total_price' => 'float',
		'payment_amount' => 'float',
		'balance' => 'float',
		'discount_percentage' => 'float',
		'discount_amount' => 'float',
		'grand_total' => 'float',
		'purchase_date' => 'datetime'
	];

	protected $fillable = [
		'supplier_id',
		'total_price',
		'invoice_number',
		'pay_type',
		'payment_amount',
		'balance',
		'discount_percentage',
		'discount_amount',
		'grand_total',
		'purchase_date'
	];

	public function purchase_order_items()
	{
		return $this->hasMany(PurchaseOrderItem::class);
	}

	public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
