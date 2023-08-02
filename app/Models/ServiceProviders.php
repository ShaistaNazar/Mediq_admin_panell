<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProviders extends Model
{
    protected $table = 'service_provider_info';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','services_id', 'full_name','email','gender','dob' , 'phone', 'status','avatar','deleted_at'
    ];

    public function services() {
        return $this->hasMany(HMServices::class, 'id', 'services_id');
    }
    public function servicesDetails() {
        return $this->belongsTo(ServiceDetails::class, 'id','service_provider_id');
    }

    public function allCities() {
        return $this->hasMany(Cities::class, 'id', 'city_id');
    }
    public function providersData() {
        return $this->hasOne(HMServices::class, 'id', 'services_id');
    }
    public function dropDownProvider() {
        return $this->hasMany(ServiceDetails::class, 'service_provider_id', 'id');
    }
    public function providers() {
        return $this->hasMany(ServiceOrders::class, 'provider_id', 'id');
    }
}
