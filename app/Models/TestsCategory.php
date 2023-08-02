<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestsCategory extends Model
{
    protected $table = 'test_categories';

    protected $fillable = [

        'id',
        'category_name',
];
public function testCategory() {
    return $this->belongsTo(TestsInLabCategory::class, 'id', 'testcategory_id');
}

public function cats() {
    return $this->belongsToMany(TestsCategory::class, 'id', 'testcategory_id');
}

}
