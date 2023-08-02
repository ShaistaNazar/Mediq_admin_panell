<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    protected $fillable = [

        'id',
        'city_names',
        'is_show',
        'province_name'
];
}
