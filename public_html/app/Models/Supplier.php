<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 *
 * @property int $id
 * @property string $supplier_name
 * @property string $contact_number
 * @property string|null $city
 * @property string|null $address
 * @property float|null $credit_balance
 * @package App\Models
 */
class Supplier extends Model
{
	protected $table = 'suppliers';
	public $timestamps = false;

    protected $casts = [
        'credit_balance' => 'float'
    ];

	protected $fillable = [
		'supplier_name',
		'contact_number',
		'city',
		'address',
        'credit_balance'
	];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
    public function rentItems(): HasMany
    {
        return $this->hasMany(RentItemSupplier::class);
    }
}
