<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Models\BillingDetails;
use App\Models\ShippingDetails;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'password', 'role_id',
         'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUserDetails($where = array()) {

        $query = DB::table('users');
        $query->select('id','phone');
      
        foreach ($where as $key => $value) {
            $query->where($key, $value);
        }
        $result = $query->get();
        return $result->toArray();
    }
    public static function checkUserExists($phone) {

        $query = DB::table('users');
        $query->select('id', 'first_name', 'last_name', 'phone', 'is_activate', 'is_blocked');
        $query->where('phone', '=',$phone);
        
        $result = $query->get();
        return $result->toArray();
    }
    public static function getUserrDetails($owner) {

        $query = DB::table('users');
        $query->select('id','first_name', 'last_name', 'user_name', 'social_id', 'social_access_token','c.name as city', 'c.id as city_id', 'address', 'biography', 'profile_picture','social_profile_picture_url','biography','phone');
      //  $query->select('first_name', 'last_name');
        $query->leftJoin('cities AS c', 'c.id', '=', 'users.city');
        $query->where('users.id', '=',$owner);
       
        return  $result = $query->first();
    }

    public static function getCode($phone,$code) {

        $query = DB::table('users');
        $query->select('id', 'first_name', 'last_name', 'phone', 'recovery_code');
        $query->where('phone', '=', $phone);
        
        $result = $query->get();
        return $result->toArray();
    }

    public static function changePassword($phone, $password) {
        $query = DB::table('users');
        $query->where('phone', $phone)
        ->update(['password' => $password]);
        return $result = $query->first();
 
    }

    public function AauthAcessToken() {
        return $this->hasMany('\App\Models\OauthAccessToken');
    }
    public function scopeOfUserRole($query)
    {
        return $query->where('role','employee');
    }

    public function shipping() {
        return $this->hasOne(ShippingDetails::class, 'id', 'shipping_id');
    }

    public function billing() {
        return $this->hasOne(BillingDetails::class, 'id', 'billing_id');
    }

   
}
