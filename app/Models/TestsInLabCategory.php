<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestsInLabCategory extends Model
{
    protected $table = 'labs_test_categories';

    protected $fillable = [

        'id',
        'lab_id',
        'testcategory_id'
];
public function testCategory() {
    return $this->belongsTo(TestsCategory::class, 'testcategory_id', 'id');
}
}
