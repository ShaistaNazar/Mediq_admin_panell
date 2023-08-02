<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medicines;
use App\Models\MiscellaneousMedicines;

class OrderDetails extends Model
{
    protected $table = 'order_details';

    protected $fillable = [

        'id',
        'product_type',
        'order_number',
        'product_id',
        'quantity',
        'status'
];
public function status() {
    return $this->hasOne(OrderStatus::class, 'id', 'status');
}
public function medProducts() {
    return $this->hasOne(Medicines::class, 'id', 'product_id');
}
public function equProducts() {
    return $this->hasOne(Equipments::class, 'id', 'product_id');
}
public function servProducts() {
    return $this->hasOne(ServiceDetails::class, 'id', 'product_id');
}
public function testProducts() {
    return $this->hasOne(Tests::class, 'id', 'product_id');
}
public function prescription() {
    return $this->hasOne(Prescriptions::class, 'order_id', 'order_number');
}
public function OtherMedicines() {
    return $this->hasOne(MiscellaneousMedicines::class, 'id', 'product_id');
}

}
