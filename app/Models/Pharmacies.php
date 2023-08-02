<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\models\Cities;

class Pharmacies extends Model
{
    protected $table = 'pharmacies';
    protected $fillable = [

        'pharmacy_name',
        'city_id',
        'lat',
        'long'
];

public function allCities() {
    return $this->hasMany(Cities::class, 'id', 'city_id');
}
public function allCitiesDropdown() {
    return $this->hasMany(Cities::class);
}

}
