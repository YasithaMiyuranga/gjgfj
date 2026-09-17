<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemUpdateHistory
 *
 * @property int $id
 * @property int $item_id
 * @property int $previous_stock
 * @property int $updated_stock
 * @property int $updated_by
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class ItemUpdateHistory extends Model
{
	protected $table = 'item_update_history';
	public $timestamps = false;

	protected $casts = [
		'item_id' => 'int',
		'previous_stock' => 'int',
		'updated_stock' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'item_id',
		'previous_stock',
		'updated_stock',
		'updated_by'
	];
}
