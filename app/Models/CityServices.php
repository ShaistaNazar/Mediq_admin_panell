<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class CityServices extends Model
{
    protected $table = 'city_services';
    protected $guarded = [];

    public function city_service() {
      return $this->hasOne(HMServices::class, 'id', 'service_id');
  }

}
