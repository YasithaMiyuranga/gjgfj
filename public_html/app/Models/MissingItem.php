<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MissingItem
 *
 * @property int $missing_id
 * @property int $item_id
 * @property int $quantity
 * @property int $rent_item_id
 * @property int $rent_id
 * @property RentItem $rent_item
 *
 * @package App\Models
 */
class MissingItem extends Model
{
	protected $table = 'missing_item';
	protected $primaryKey = 'missing_id';
	public $timestamps = false;

	protected $casts = [
		'item_id' => 'int',
		'quantity' => 'int',
		'rent_item_id' => 'int',
        'rent_id' => 'int'
	];

	protected $fillable = [
		'item_id',
		'quantity',
		'rent_item_id',
        'rent_id'
	];

	public function rent_item()
	{
		return $this->belongsTo(RentItem::class);
	}
}
