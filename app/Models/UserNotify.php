<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotify extends Model
{
    protected $table = 'user_notifications';

    protected $fillable = [
        'user_id', 'note_title', 'note_body','status_id','note_heading','total_amount','note_type','is_paid'
    ];
}
