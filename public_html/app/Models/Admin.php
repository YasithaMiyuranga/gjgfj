<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Admin
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property string|null $profile_image
 * @property string|null $type
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $mobile
 * @property string $register_type
 * @property string|null $theme_id
 * @property int|null $created_by
 * @property int|null $current_store
 * @property string|null $lang
 * @property int $plan
 * @property Carbon|null $plan_expire_date
 * @property int $plan_is_active
 * @property int $requested_plan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Admin extends Authenticatable
{
	protected $table = 'admins';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'created_by' => 'int',
		'current_store' => 'int',
		'plan' => 'int',
		'plan_expire_date' => 'datetime',
		'plan_is_active' => 'int',
		'requested_plan' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'email',
		'profile_image',
		'type',
		'email_verified_at',
		'password',
		'mobile',
		'register_type',
		'theme_id',
		'created_by',
		'current_store',
		'lang',
		'plan',
		'plan_expire_date',
		'plan_is_active',
		'requested_plan'
	];
}
