<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\OrdersRequest;
use App\Repositories\NotificationsRepository;


class NotificationController extends Controller
{
	protected $notificationRepo;
  
    function __construct(NotificationsRepository $notificationsRepository,Request $request) {
     
     	$this->notificationRepo=$notificationsRepository;
 	 
 	}
   /*
     * get user notifications
    */
   	public function getNotifications(){
   		
   		$userId=Auth::id();
   		$data=$this->notificationRepo->getAll($userId);

   		if($data){
		
			$ResponseCode = \Config::get('constants.response.ResponseCode_success');
			$ResponseMessage = __('notify.list');
			$param = 'Data';
			$values = $data;

		}else{
			$ResponseCode =\Config::get('constants.response.ResponseCode_fail');
			$ResponseMessage =  __('notify.fail');
			$param = 'Data';
			$values = new \stdClass();
		}
		return responseMsg($ResponseCode, $ResponseMessage, $param, $values);
   	}
/*
     * make notifications read
    */
    public function readNotifications(OrdersRequest $request){
   		
   		$input = $request->all();
        $validated = $request->validated();

        $data=$this->notificationRepo->makeRead($input['notification_id']);

   		if($data){
		
			$ResponseCode = \Config::get('constants.response.ResponseCode_success');
			$ResponseMessage = __('notify.updated');
			$param = 'Data';
			$values = $data;

		}else{
			$ResponseCode =\Config::get('constants.response.ResponseCode_fail');
			$ResponseMessage =  __('notify.fail');
			$param = 'Data';
			$values = new \stdClass();
		}
		return responseMsg($ResponseCode, $ResponseMessage, $param, $values);
   	}
   	/*
     * make notification seen,
    */
   	public function seenNotifications(OrdersRequest $request){

   		$data=$this->notificationRepo->makeSeen();

		$ResponseCode = \Config::get('constants.response.ResponseCode_success');
		$ResponseMessage = __('notify.updated');
		$param = 'Data';
		$values = new \stdClass();

		return responseMsg($ResponseCode, $ResponseMessage, $param, $values);
   	}
}
