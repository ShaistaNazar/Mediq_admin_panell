<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPromotions extends Model
{
    protected $table='promotion';
    protected $fillable=['id','user_id', 'code', 'created_at', 'updated_at','percentage','order_ratio','total_users'];
}
