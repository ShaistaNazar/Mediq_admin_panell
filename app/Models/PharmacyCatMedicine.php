<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\models\MedicinesCategory;

class PharmacyCatMedicine extends Model
{
    protected $table = 'pharmacy_medicine_categories';

    protected $fillable = [

        'pharmacy_id',
        'medicine_category_id'
];



}
