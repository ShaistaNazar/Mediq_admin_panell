<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table='service_order';
    protected $fillable=['id','service_id', 'comments', 'status', 'order_from_user','provider_id','payment_method_id'];
}
