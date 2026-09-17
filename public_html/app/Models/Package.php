<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Package
 *
 * @property int $package_id
 * @property string $package_name
 * @property string|null $image
 * @property string $category
 * @property float $price
 * @property string|null $description
 * @property string $status
 * @property string $type
 *
 * @property Collection|Item[] $items
 *
 * @package App\Models
 */
class Package extends Model
{
	protected $table = 'package';
	protected $primaryKey = 'package_id';
	public $timestamps = false;

	protected $casts = [
		'price' => 'float'
	];

	protected $fillable = [
		'package_name',
		'image',
		'category',
		'price',
        'price_visible',
		'description',
		'status',
		'type'
	];

	public function items()
	{
		return $this->belongsToMany(Item::class, 'package_item')
					->withPivot('package_item_id', 'item_name');
	}

    public function packageImages()
    {
        return $this->hasMany(PackageImage::class, 'package_id', 'package_id');
    }
}
