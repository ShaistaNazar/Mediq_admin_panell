<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PharmacyCatMedicine;

class MedicinesCategory extends Model
{
    protected $table = 'medicines_categories';
    protected $fillable = [

        'id',
        'category_name',
        'created_at',
        'updated_at',
];

public function categories() {
    return $this->belongsTo(PharmacyCatMedicine::class, 'id','medicine_category_id');
}


}
