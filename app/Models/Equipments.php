<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CityRentalEquipments;



class Equipments extends Model
{
    protected $table = 'equipments';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [

        'id',
        'equipment_name',
        'brand',
        'image',
        'price',
        'quantity',
        'status'
];
public function city_equipment() {
    return $this->hasMany(CityRentalEquipments::class, 'rental_equipment_id', 'id')
    ->select('city_id','rental_equipment_id');
}
}
