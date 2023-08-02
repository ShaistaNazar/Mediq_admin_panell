<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingDetails extends Model
{
    use SoftDeletes;
    protected $table = 'billing_details';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

}
