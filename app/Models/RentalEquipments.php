<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Equipments;


class RentalEquipments extends Model
{
    protected $table = 'rental_equipment';

    protected $guarded = [];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function equipment() {
        return $this->hasOne(Equipments::class, 'id', 'equipment_id');
    }

    
}
