<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permissions extends Model
{
    protected $table = 'permissions';
    protected $fillable = [

        'emp_id',
        'Read',
        'Write',
        'Delete',
];

public function employeesNames() {

    return $this->hasMany(User::class, 'id', 'Emp_id');

}
}