<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property string $email
 *
 * @package App\Models
 */
class Subscription extends Model
{
	protected $table = 'subscription';
	public $timestamps = false;

	protected $fillable = [
		'email'
	];
}
