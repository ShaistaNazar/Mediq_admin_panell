<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    protected $table = 'orders';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [

        'id',
        'order_id',
        'order_number',
        'order_model',
        'model_id',
        'quantity',
        'delivery_id',
        'status'
];
}
