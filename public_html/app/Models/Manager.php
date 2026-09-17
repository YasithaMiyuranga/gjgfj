<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

/**
 * Class Employe
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property string|null $active
 * @property Carbon|null $regdate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */

class Manager extends Authenticatable implements MustVerifyEmail
{ 
    use Notifiable;

    protected $table='managers';
    protected $primaryKey='manager_id';

    protected $casts=[
        'regdate'=>'datetime'
    ];

    protected $hidden = [
		'password'
	];

    protected $fillable=[
        'name',
        'email',
        'mobile',
        'password',
        'status',
        'regdate',
        'profile_image'
    ];


    public function events()
    {
        return $this->hasMany(AdminEvent::class, 'event_manager_id', 'manager_id');
    }
    
    
}
