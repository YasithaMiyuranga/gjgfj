<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RentItem
 *
 * @property int $rent_item_id
 * @property int $rent_id
 * @property int $item_id
 * @property int|null $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Rent $rent
 *
 * @package App\Models
 */
class RentItem extends Model
{
	protected $table = 'rent_items';
	protected $primaryKey = 'rent_item_id';

	protected $casts = [
		'rent_id' => 'int',
		'item_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'rent_id',
		'item_id',
		'quantity'
	];

	public function rent()
	{
		return $this->belongsTo(Rent::class);
	}

	public function damageItems()
	{
		return $this->hasMany(DamageItem::class, 'rent_item_id');
	}
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function suppliers(): HasMany
    {
        return $this->hasMany(RentItemSupplier::class);
    }

}
