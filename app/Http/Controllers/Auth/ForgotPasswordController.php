<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPassword(Request $request) {
        $input = $request->all();
        $errorMessage = "";
        $validator = Validator::make($request->all(), [
                    'phone' => 'required|min:12'
        ]);
        if ($validator->fails()) {
            $errorList = $validator->errors();
            if ($errorList->first('phone')) {
                $errorMessage = $errorList->first('phone');
            }
        }
        if ($errorMessage != "") {
            $ResponseCode = 0;
            $ResponseMessage = $errorMessage;
        } else {
            if ($userDetails = User::getUserDetails(array('phone' => $input['phone']))) {
                $userDetails = (array) $userDetails[0];
                $random_code = str_random(4);
                $new_code = strtolower($random_code);
                $phone = $input['phone'];
                $code = "Use the code " . $new_code . " to reset your password.";
                sendSms($phone, $code);
                $userDetails = User::find($userDetails['phone']);
           
                $userDetails->recovery_code = $new_code;
                $userDetails->save();
//

                //Send this new password via sms to user here
                $object = new stdClass();
                $object->Code = $new_code;
                $ResponseCode = 1;
                $ResponseMessage = __('user.account_recovery_code' , ['phone' =>  $input]);
                $param ='Data';
                $values = $object;  
              
            } else {
                $ResponseCode = 0;
                $ResponseMessage = __('user.valid_phone');
            }
        }
        return responseMsg( $ResponseCode , $ResponseMessage ,$param , $values);
    }
}
