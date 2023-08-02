<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTemp extends Model
{
    protected $table = 'order_temps';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [

        'id',
        'user_id',
        'order_number',
        'delivery_type_id',
        'shipping_id',
        'billing_id',
        'payment_method_id',
        'status',
        'is_admin',
        'total_amount',
        'prescription_id'
];

public function details() {
    return $this->hasMany(OrderDetails::class, 'order_number', 'order_number');
}
public function medDetails() {
    return $this->hasMany(OrderDetails::class, 'order_number', 'order_number')->where('product_type', 'Medicines');
}
public function equipDetails() {
    return $this->hasMany(OrderDetails::class, 'order_number', 'order_number')->where('product_type', 'Equipments');
}
public function LabsTestDetails() {
    return $this->hasMany(OrderDetails::class, 'order_number', 'order_number')->where('product_type', 'LabsTest');
}
public function otherMedicineDetails() {
    return $this->hasMany(OrderDetails::class, 'order_number', 'order_number')->where('product_type', 'OtherMedicines');
}
public function users() {
    return $this->hasOne(User::class, 'id', 'user_id');
}
public function PaymentMethods() {
    return $this->hasOne(PaymentMethods::class, 'id', 'payment_method_id');
}
public function shipping() {
    return $this->hasOne(ShippingDetails::class, 'id', 'shipping_id');
}
public function billing() {
    return $this->hasOne(BillingDetails::class, 'id', 'billing_id');
}
public function status() {
    return $this->hasOne(OrderStatus::class, 'id', 'status');
}
public function DelivProducts() {
    return $this->hasOne(DeliveryTypes::class, 'id', 'delivery_type_id');
}
public function prescription() {
  return $this->hasOne(Prescriptions::class, 'id', 'prescription_id');
}
}
