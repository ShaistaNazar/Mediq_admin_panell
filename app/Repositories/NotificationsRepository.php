<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\UserNotification;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package 
 * @version 
*/

class NotificationsRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserNotification::class;
    }
    public static function createNew($input)
    {
        return UserNotification::create($input);
    }
    public function getAll($id){
        return UserNotification::where('user_id',$id)->get();

    }
    public function makeRead($id){
        
        $notify=UserNotification::find($id);
        $notify->status_id=\Config::get('constants.notifications.read');
        
        if($notify->save()){
            return  $notify;
        }
        return false;
    }
    
    public function makeSeen(){

        return $notifications=UserNotification::where('status_id',\Config::get('constants.notifications.unread'))->update(['status_id'=>\Config::get('constants.notifications.seen')]);

    }
    
}