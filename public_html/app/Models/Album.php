<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Album
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $tags
 * @property string|null $album_images
 * @property Carbon|null $date
 * @property string|null $event
 * 
 *
 * @package App\Models
 */
class Album extends Model
{
	protected $table = 'album';
	public $timestamps = false;

	protected $casts = [
		'date' => 'datetime'
	];

	protected $fillable = [
		'name',
		'description',
		'tags',
		'album_images',
		'date',
		'event'
	];

	public function album_images()
	{
		return $this->hasMany(AlbumImage::class);
	}
}
