<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredefinedPackageCategory extends Model
{
    use HasFactory;
    
    protected $table = 'predefined_package_category';

    protected $primaryKey = 'category_id';

    protected $fillable = ['category_name'];

    
}
