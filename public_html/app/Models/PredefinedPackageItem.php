<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PredefinedPackageItem
 *
 * @property int $predefined_item_id
 * @property int $predefined_package_id
 * @property int $item_id
 * @property int|null $item_name
 * @property int $quantity
 *
 * @property PredefinedPackage $predefined_package
 *
 * @package App\Models
 */
class PredefinedPackageItem extends Model
{
	protected $table = 'predefined_package_item';
	protected $primaryKey = 'predefined_item_id';
	public $timestamps = false;

	protected $casts = [
		'predefined_package_id' => 'int',
		'item_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'predefined_package_id',
		'item_id',
		'item_name',
        'item_price',
		'quantity'
	];

	public function predefined_package()
	{
		return $this->belongsTo(PredefinedPackage::class);
	}
}
