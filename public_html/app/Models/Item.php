<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use App\Models\EquipmentWastage;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 *
 * @property int $item_id
 * @property string|null $item_name
 * @property int $total_stock
 * @property int $in_stock
 * @property int $out_stock
 * @property float|null $rent_price
 * @property float|null $product_amount
 * @property string|null $category
 * @property string|null $status
 * @property string|null $description
 * @property string $visible_to_customer
 * @property string|null $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Item extends Model
{
	protected $table = 'item';
	protected $primaryKey = 'item_id';

	protected $casts = [
		'total_stock' => 'int',
		'in_stock' => 'int',
		'out_stock' => 'int',
		'rent_price' => 'float',
		'product_amount' => 'float'
	];

	protected $fillable = [
		'item_name',
		'total_stock',
		'in_stock',
		'out_stock',
		'rent_price',
		'product_amount',
		'category',
		'status',
		'description',
		'visible_to_customer',
		'image',
        'item_type'
	];

    public function  rent_items()
    {
        return $this->hasMany(RentItem::class);
    }

    public function rent_items_packages_items()
    {
        return $this->hasMany(RentItemPackageItem::class);
    }
    public function equipment_wastages()
    {
        return $this->hasMany(EquipmentWastage::class);
    }
}
