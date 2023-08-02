<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineWarning extends Model
{
    protected $table = 'medicine_warnings';
    protected $fillable = [
        'id',
        'title',
        'detail',
        'medicine_id',
        'created_at',
        'updated_at',
];
}
