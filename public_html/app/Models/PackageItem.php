<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PackageItem
 * 
 * @property int $package_item_id
 * @property int $package_id
 * @property int $item_id
 * @property string|null $item_name
 * @property int $quantity
 * 
 * @property Item $item
 * @property Package $package
 *
 * @package App\Models
 */
class PackageItem extends Model
{
	protected $table = 'package_item';
	protected $primaryKey = 'package_item_id';
	public $timestamps = false;

	protected $casts = [
		'package_id' => 'int',
		'item_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'package_id',
		'item_id',
		'item_name',
		'quantity'
	];

	public function item()
	{
		return $this->belongsTo(Item::class);
	}

	public function package()
	{
		return $this->belongsTo(Package::class);
	}
}
