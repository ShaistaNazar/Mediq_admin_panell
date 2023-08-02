<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TestsInLabCategory;

class Laboratories extends Model
{
    protected $table = 'labs';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [

        'id',
        'lab_name',
        'deleted_at'
];
public function TestSyncCat()
    {
        return $this->belongsToMany(TestsInLabCategory::class, 'labs_test_categories', 'lab_id', 'testcategory_id');
    }

}
