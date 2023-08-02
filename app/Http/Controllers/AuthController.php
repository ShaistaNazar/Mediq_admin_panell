<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use App\Models\User;
use App\Models\Permissions;
use Tymon\JWTAuth\Exceptions\JWTException;
use Messagebird;

use Validator;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {

        // grab credentials from the request
        $credentials = $request->only('phone', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'user.invalid_credentials'], 401);
            }

            $currentUser = Auth::user();
            // all good so return the token
            if($currentUser->role_id != 3)
            {
                $permissions = Permissions::where('Emp_id', $currentUser->id)->first();
                return response()->json(compact('token', 'currentUser', 'permissions'));
            }
            else
            {
                return response()->json(['error' => 'You are not allowed here, Legal action will be taken against you if you ever try this again'], 500);
            }
                 
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'user.could_not_create_token'], 500);
        }

    }

    public function forgotPassword(Request $request) {
        
        $input = $request->all();

        $validator = Validator::make($request->all(), [ 'phone' => 'required' ]);

        if ($validator->fails()) {

            $errorList = $validator->errors();

            if ($errorList->first('email')) {
                $errorMessage = $errorList->first('email');
            }
            
            return response()->json(['error' => 'user.valid_phone'], 401);

        } 


        if ($userDetails = User::where('phone',$input['phone'])->where('role_id',1)->first()) {
            
            // $userDetails = (array) $userDetails[0]; 
            $phone = $userDetails['phone'];

            
            $activation_code = mt_rand(100000, 999999);

            $userDetails = User::find($userDetails['id']);
            $userDetails->activation_code = $activation_code;
            $userDetails->save();
            $message = 'Your Recovery Code is '. $activation_code;

            $ok = Messagebird::createMessage('Mingle', $recipients = [$phone], $message);
        } else {

            return response()->json(['error' => 'user.valid_phone'], 401);
        
        }
    }
    
    public function verify(Request $request) {

        $input = $request->all();
        
        if ($userDetails = User::getUserDetails(array('activation_code' => $input['password']))) {
        
             $userDetails = (array) $userDetails[0];
             return $userDetails['id'];
        
        } else {
            
            return response()->json(['error' => __('Please enter valid code')], 401);
        
        }
    }


    public function reset(Request $request) {

        $input = $request->all();
        
        if (User::getUserDetails(array('id' => $input['id'] , 'role_id' =>1))) {
            
            $userDetails = User::find($input['id']);
            
            $userDetails->password = bcrypt($input['password']);
            $userDetails->save();
        
            return response()->json(['Success' => __('')]);

        } else {
            
            return response()->json(['error' => __('user.valid_phone')], 401);
        
        }
    }
    
    public function check() {
       // return response(['authenticated' => true]);
        try {
            JWTAuth::parseToken()->authenticate();

            return response(['authenticated' => true]);

        } catch (JWTException $e) {
            return response(['authenticated' => false]);
        }

    }

    public function logout() {

        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

            return response()->json(['message' => 'Log out success'], 200);

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 401);
        }
        

    }
}
