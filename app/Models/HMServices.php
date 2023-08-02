<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CityServices;


class HMServices extends Model
{
    protected $table = 'services';
    protected $fillable = [

        'id',
        'service_name',
];
public function service_city() {
    return $this->hasMany(CityServices::class, 'service_id', 'id')
    ->select('city_id','service_id');
}
}
