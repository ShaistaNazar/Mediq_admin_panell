<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tests extends Model
{
    protected $table = 'tests';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [];
public function testCategory() {
    return $this->hasMany(TestsCategory::class, 'id', 'testcategory_id');
}
public function labs() {
    return $this->hasOne(Laboratories::class, 'id', 'lab_id');
}


}
