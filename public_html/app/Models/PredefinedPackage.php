<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PredefinedPackage
 *
 * @property int $package_id
 * @property string $package_name
 * @property string|null $category
 *
 * @property Collection|PredefinedPackageItem[] $predefined_package_items
 *
 * @package App\Models
 */
class PredefinedPackage extends Model
{
	protected $table = 'predefined_package';
	protected $primaryKey = 'package_id';
	public $timestamps = false;

	protected $fillable = [
		'package_name',
		'category',
        'package_status',
        'order_id'
	];

	public function predefined_package_items()
	{
		return $this->hasMany(PredefinedPackageItem::class);
	}
}
