<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryTypes extends Model
{
    protected $table = 'delivery_types';

    protected $fillable = [

        'id',
        'delivery_types',
];
}
