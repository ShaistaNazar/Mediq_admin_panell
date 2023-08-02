<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingDetails extends Model
{
    use SoftDeletes;
    protected $table = 'shipping_details';
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}
