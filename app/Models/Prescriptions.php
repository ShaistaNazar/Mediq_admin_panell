<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescriptions extends Model
{
    protected $dates = ['prescriptions'];

    protected $fillable = [

        'id',
        'prescription_path',
        'prescription_for',
        'product_id',
];
}
