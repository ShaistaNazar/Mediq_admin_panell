<?php

namespace App\Http\Services;

use OneSignal;
use Illuminate\Support\Facades\DB;
use App\Repositories\NotificationRepository;
use App\Models\UserNotify;
use App\Models\User;

class NotificationService
{
    
    public function updateStatus($id, $status)
    {

        $notification = DB::table('user_notifications')->find($id);

        if(!$notification){
            return false;
        }
        if($notification->note_status != $status){
            DB::table('user_notifications')->where('id', $id)->update(['note_status' => $status]);
        }
        $notification->note_status = $status;
        return $notification;
    }

    static public function notify($user,$testDetail,$type)
    {
        $ifUser = User::where('id', $user->id)->first();
        $data['content_available'] = true;
        $data['note_body'] = "Your Lab Reoprt is Ready for Download";
        $data['from_user'] = $ifUser;
        $data['type'] = $type;
       
        // if(isset($ifUser->player_id) && $ifUser->player_id!=''){
            OneSignal::sendNotificationToUser(

               $data['note_body'],
               $ifUser->player_id,
               $url = null,
               $data = $data,
               $buttons = null,
               $schedule = null

           );
            // return true;
            $input=['user_id'=>$user->id,'note_title'=>$data['note_body'],'note_type'=> $type,'note_body'=>$data['note_body'],'status_id'=>'report', 'note_heading' => $testDetail->test_name,'total_amount' => $testDetail->description];

           return $addNotify = UserNotify::create($input);
        
            return true;

        // } 
    }
    static public function notifyjazcash($data)
    {
        $ifUser = User::where('id',$data['user_id'])->first();
        $data['content_available'] = true;
        $data['note_body'] = "Thank-you, We've received your request, Our representative will be in contact with you shortly";
        $data['from_user'] = $ifUser;
        $data['type'] = 'service';
        // $abc = "12e62d4a-7e9d-4319-ab11-91b721900844";
        // echo $abc;
        // echo $ifUser->player_id;
       
        if(isset($ifUser->player_id) && $ifUser->player_id!=''){
            $user_plyerId = $ifUser->player_id;
            OneSignal::sendNotificationToUser(

               $data['note_body'],
               $user_plyerId,
               $url = null,
               $data = $data,
               $buttons = null,
               $schedule = null

           );
           if($data['order_amount'] <= 50000){
            $note_type= 3;
           }else{
            $note_type= 4;
           }
            $input=['user_id'=>$data['user_id'], 'note_title'=>$data['note_body'], 'note_heading' => $data['order_number'],
            'note_type'=> $note_type,'total_amount' => $data['order_amount'],'note_body'=>$data['provider_name'].",".$data['phone']];

           return $addNotify = UserNotify::create($input);
            return true;
        } 
    }
    static public function notifyRentalEquipment($data)
    {
        $ifUser = User::where('id',$data['user_id'])->first();
        $data['content_available'] = true;
        $data['note_body'] = "Thank-you, We've received your request for Renting ".$data['equipment_ordered']." equipment. Your total bill is Rs-/ ".$data['order_amount'];
        $data['from_user'] = $ifUser;
        $data['type'] = 'equipment';
        // $abc = "12e62d4a-7e9d-4319-ab11-91b721900844";
        // echo $abc;
        // echo $ifUser->player_id;
       
        if(isset($ifUser->player_id) && $ifUser->player_id!=''){
            $user_plyerId = $ifUser->player_id;
            OneSignal::sendNotificationToUser(

               $data['note_body'],
               $user_plyerId,
               $url = null,
               $data = $data,
               $buttons = null,
               $schedule = null

           );
           if($data['order_amount'] <= 50000){
            $note_type= 5;
           }else{
            $note_type= 6;
           }
            $input=['user_id'=>$data['user_id'], 'note_title'=>$data['note_body'], 'note_heading' => $data['order_number'],
            'note_type'=> $note_type,'total_amount' => $data['order_amount'],'note_body'=>$data['equipment_id'].",".$data['equipment_ordered']];

           return $addNotify = UserNotify::create($input);
            return true;
        } 
    }

    public function reMatchNotify($user, $data, $type = 'rematch_request', $fromUser,$is_unmatched,$is_request) {
    
        $data['type'] = snake_case($type);
        $data['from_id'] = $fromUser->id;
        $data['is_unmatched'] = $is_unmatched;
        $data['is_request'] = $is_request;
        // $plyer_idm='d1dc855d-2e46-4352-9b81-ae7461c4c51b';
        $plyer_idm=$user->plyer_id;
        
        if($plyer_idm !=''){
            return OneSignal::sendNotificationToUser(
                "Mingles: " . $fromUser->user_name . ' has requested with you ',
                $plyer_idm,
                $url = null,    
                $data = $data,
                $buttons = null,
                $schedule = null
 
            );
        }
       
    }

}
