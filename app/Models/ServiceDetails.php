<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDetails extends Model
{
    protected $table = 'service_providers';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_provider_id', 'city_id','price_per_hour','available_from','available_to' , 'status','deleted_at'
    ];

    public function allCities() {
        return $this->hasOne(Cities::class, 'id', 'city_id');
    }
    public function providers() {
        return $this->belongsTo(ServiceProviders::class, 'id', 'provider_id');
    }
  
    

}
