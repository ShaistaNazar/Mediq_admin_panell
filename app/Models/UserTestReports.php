<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Util\Test;
use App\Models\Laboratories;

class UserTestReports extends Model
{
    protected $table = 'user_test_reports';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [

        'id',
        'user_id',
        'test_id',
        'file',
        'deleted_at'
];
public function users() {
    return $this->hasOne(User::class, 'id', 'user_id');
}
public function tests() {
    return $this->hasOne(Tests::class, 'id', 'test_id');
}

}
