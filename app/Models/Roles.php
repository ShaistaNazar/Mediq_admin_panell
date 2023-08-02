<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = [

        'name',
        'guard_name',
];
// public function user_permissions()
// {
//     return $this->hasOne('App\Models\UserPermissions','role_id', 'id');
// }

}