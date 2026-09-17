<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseOrderItem
 * 
 * @property int $id
 * @property int $purchase_order_id
 * @property int $item_id
 * @property int $quantity
 * @property float $purchased_price
 * @property float|null $discount
 * 
 * @property PurchaseOrder $purchase_order
 *
 * @package App\Models
 */
class PurchaseOrderItem extends Model
{
	protected $table = 'purchase_order_items';
	public $timestamps = false;

	protected $casts = [
		'purchase_order_id' => 'int',
		'item_id' => 'int',
		'quantity' => 'int',
		'purchased_price' => 'float',
		'discount' => 'float'
	];

	protected $fillable = [
		'purchase_order_id',
		'item_id',
		'quantity',
		'purchased_price',
		'discount'
	];

	public function purchase_order()
	{
		return $this->belongsTo(PurchaseOrder::class);
	}
}
