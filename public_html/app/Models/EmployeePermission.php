<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePermission extends Model
{
    use HasFactory;

    protected $table = 'employee_permissions';

    protected $fillable = [
        'admin_id',
        'employee_id',
        'permission_id',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function employee(){
        return $this->belongsTo(Employe::class);
    }

    public function permission(){
        return $this->belongsTo(Permission::class);
    }
}
