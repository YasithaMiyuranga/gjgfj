<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AlbumImage
 * 
 * @property int $aid
 * @property int|null $album_id
 * @property string|null $image
 * @property string|null $status
 * 
 * @property Album|null $album
 *
 * @package App\Models
 */
class AlbumImage extends Model
{
	protected $table = 'album_images';
	protected $primaryKey = 'aid';
	public $timestamps = false;

	protected $casts = [
		'album_id' => 'int'
	];

	protected $fillable = [
		'album_id',
		'image',
		'status'
	];

	public function album()
	{
		return $this->belongsTo(Album::class);
	}

	public function meta()
    {
        return $this->hasOne(ImageMeta::class, 'album_image_id', 'aid');
    }
}
