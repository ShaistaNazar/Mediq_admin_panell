<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrders extends Model
{
    protected $table = 'service_orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number','service_id','total_amount', 'order_from_user','comments','status','provider_id','created_at' , 'updated_at', 'by_admin'
    ];
    public function users() {
        return $this->hasOne(User::class, 'id', 'order_from_user');
    }
    public function services() {
        return $this->hasMany(HMServices::class, 'id', 'service_id');
    }
    public function providers() {
        return $this->belongsTo(ServiceProviders::class, 'provider_id', 'id');
    }
}
