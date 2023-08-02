<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicinesCategory;
use App\Models\Pharmacies;
use App\Models\Prescriptions;

class Medicines extends Model
{
    protected $table = 'medicines';
    protected $fillable = [

        'id',
        'medicine_name',
        'pharmacy_id',
        'category_id',
        'available_quantity',
        'price',
        'expairy_date',
        'medicine_image',
        'brand',
        'is_prescription_req',
];

public function category() {
    return $this->hasMany(MedicinesCategory::class, 'id', 'category_id');
}
public function pharmacy() {
    return $this->hasMany(Pharmacies::class, 'id', 'pharmacy_id');
}
public function MedicineWarning() {
    return $this->hasMany(MedicineWarning::class, 'medicine_id', 'id');
}

}
