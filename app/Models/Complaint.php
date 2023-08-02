<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CityRentalEquipments;



class Complaint extends Model
{
    protected $table = 'user_complaint';
    protected $guarded = [];
    public function complainer() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
