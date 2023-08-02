<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserMatches;
use App\Models\DeactivedUsers;
use App\Models\Subscriptions;
use App\Models\UserSubscriptionHistory;
use App\Models\UserBlocked;
use App\Models\Media;
use App\Models\role_ids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Hash;
use Auth;
use Spatie\Permission\Models\Permission;
use App\models\Permissions;
use App\Models\ShippingDetails;
use App\Models\BillingDetails;
use App\Models\Prescriptions;
use App\Models\DeviceId;
use App\Models\OrderTemp;
use App\Models\UserPrescription;


// $client = new Client();


class UserController extends Controller
{

    private $image_ext = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * total downloads
     */
    public function totalDownloads(Request $request)
    {
        try {
            $response = DeviceId::all()->count();
            if ($response) {
                return response()->json([
                    'ResponseHeader' => [
                        'ResponseCode' => \Config::get('constants.response.ResponseCode_success'),
                        'ResponseMessage' => __('user.get_users_count'),
                    ], 'ResponseBody' => [
                        'data' => $response
                    ]
                ], 200);
            } else {
                return response()->json([
                    'ResponseHeader' => [
                        'ResponseCode' => \Config::get('constants.response.ResponseCode_fail'),
                        'ResponseMessage' => __('user.get_users_count_zero'),
                    ], 'ResponseBody' => [
                        'data' => new \stdClass()
                    ]
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' =>\Config::get('constants.response.ResponseCode_fail'),
                    'ResponseMessage' => $e->getMessage(),
                ], 'ResponseBody' => [
                    'data' => new \stdClass()
                ]
            ], $e->getMessage());
        }
    }
    /**
     * helper function to sort array
     */
    function compareByTimeStamp($time1, $time2)
    {   
        $obj_date_1 = DateTime::createFromFormat('Y-m-d H:i:s',date("Y-m-d H:i:s", $time1));
        $obj_date_2 = DateTime::createFromFormat('Y-m-d H:i:s',date("Y-m-d H:i:s", $time2));
        

        if ($obj_date_1->getTimestamp() < $obj_date_2->getTimestamp())
            return -1;
        else if ($obj_date_1->getTimestamp()  > $obj_date_2->getTimestamp())
            return 1;
        else
            return 0;
    }
    /**
     * Monthly active users
     */
    public function MonthlyActivceUsers(Request $request)
    {
        try{
            $usersthatplacedorders = OrderTemp::pluck('user_id')->toArray();
            $usersthatUploadedPrescriptions = Prescriptions::pluck('user_id')->toArray();
            $total_users = array_unique(array_merge($usersthatplacedorders, $usersthatUploadedPrescriptions));
            $added =  false;
            $user_counter = 0;
    
            foreach ($total_users as $user_id) {
                $withoutCarbonDatesArray = [];
                $user_creation_date = DateTime::createFromFormat('Y-m-d H:i:s', User::where('id', $user_id)->first()->created_at);
                $first_date_of_month = $user_creation_date->getTimestamp();
                $ordersCreatedAt = OrderTemp::where('user_id', $user_id)->pluck('created_at')->toArray();
                $prescriptionsCreatedAt = Prescriptions::where('user_id', $user_id)->pluck('created_at')->toArray();
                $allTimeStamps = array_unique(array_merge($ordersCreatedAt, $prescriptionsCreatedAt));
                
                foreach ($allTimeStamps as $carbonTime) {
                    
                    $obj_date = DateTime::createFromFormat('Y-m-d H:i:s', $carbonTime);
                    array_push($withoutCarbonDatesArray, $obj_date->getTimestamp());
                }
                usort($withoutCarbonDatesArray, array("App\Http\Controllers\Admin\UserController", "compareByTimeStamp"));
                $last_date_of_month = DateTime::createFromFormat('Y-m-d H:i:s',$user_creation_date->modify("+1 month")->format("Y-m-d H:i:s"))->getTimestamp();
               
                foreach ($withoutCarbonDatesArray as $key=>$timeToCompare) {
                   
                    if ($timeToCompare >= $first_date_of_month && $timeToCompare <= $last_date_of_month) {
                        //lies in this month 
                        $added =  true;
                        if(array_key_exists($key+1, $withoutCarbonDatesArray)){
                            if(!($withoutCarbonDatesArray[$key+1]  >= $first_date_of_month &&$withoutCarbonDatesArray[$key+1] <= $last_date_of_month)){
                                $first_date_of_month_time_stamp= DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s", $last_date_of_month));
                                $first_date_of_month = $first_date_of_month_time_stamp->getTimestamp();
                                $last_date_of_month = DateTime::createFromFormat('Y-m-d H:i:s',$first_date_of_month_time_stamp->modify("+1 month")->format("Y-m-d H:i:s"))->getTimestamp();    
                            } 
                        }
                        
                    } else {
                        $added=false;
                        break 2;
                    }
                }
                if ($added) {
                    $user_counter++;
                }
            }
            if ($user_counter) {
                return response()->json([
                    'ResponseHeader' => [
                        'ResponseCode' => \Config::get('constants.response.ResponseCode_success'),
                        'ResponseMessage' => __('user.monthly_active_users'),
                    ], 'ResponseBody' => [
                        'data' =>$user_counter
                    ]
                ], 200);
             
            }else{
                return response()->json([
                    'ResponseHeader' => [
                        'ResponseCode' => \Config::get('constants.response.ResponseCode_fail'),
                        'ResponseMessage' => __('user.monthly_active_users_not_found'),
                    ], 'ResponseBody' => [
                        'data' => new \stdClass()
                    ]
                ], 500);
            }
        }catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => \Config::get('constants.response.ResponseCode_fail'),
                    'ResponseMessage' => $e->getMessage(),
                ], 'ResponseBody' => [
                    'data' => new \stdClass()
                ]
            ], $e->getMessage());
        }
        
    }
    /**
     * Retention Rate
     */
    public function RetentionRate(Request $request)
    {
        try{
        //get all tables which have user id i.e.,  user presciptions and temp orders
        $usersthatplacedorders = OrderTemp::pluck('user_id')->toArray();
        $usersthatUploadedPrescriptions = Prescriptions::pluck('user_id')->toArray();
        $total_active_users = array_unique(array_merge($usersthatplacedorders, $usersthatUploadedPrescriptions));
        $counter = 0;
        foreach ($total_active_users as $user_id) {
            $ordersCreatedAt = OrderTemp::where('user_id', $user_id)->pluck('created_at')->toArray();
            $prescriptionsCreatedAt = Prescriptions::where('user_id', $user_id)->pluck('created_at')->toArray();
            $allTimeStamps = array_unique(array_merge($ordersCreatedAt, $prescriptionsCreatedAt));
            if (count($allTimeStamps) > 1) {
                $counter++;
            }
        }

        $total_users = DeviceId::whereNotNull('user_id')->get()->count();
        if ($total_users == 0) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => \Config::get('constants.response.ResponseCode_fail'),
                    'ResponseMessage' => __('user.no_any_user_yet'),
                ], 'ResponseBody' => [
                    'data' => new \stdClass()
                ]
            ], 404);
    
        }
        $percentage_of_users_who_again = ($counter / $total_users) * 100;
        if ($percentage_of_users_who_again) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => \Config::get('constants.response.ResponseCode_success'),
                    'ResponseMessage' => __('user.found_percentage'),
                ], 'ResponseBody' => [
                    'data' => $percentage_of_users_who_again
                ]
            ], 200);
            return responseMsg(\Config::get('constants.response.ResponseCode_success'), __('user.found_percentage'), 'User', $percentage_of_users_who_again);
        }
        }catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => \Config::get('constants.response.ResponseCode_fail'),
                    'ResponseMessage' => $e->getMessage(),
                ], 'ResponseBody' => [
                    'data' => new \stdClass()
                ]
            ], $e->getMessage());
        }
    }

    public function adminprofile(Request $request)
    {

        $req = $request->data;
        $user = User::find($req['Id']);

        try {
            $user->full_name = $req['full_name'];
            $user->email = $req['email'];
            $user->phone = $req['phone'];
            $user->save();
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Admin updated successfully',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }


    public function resetPassAdmin(Request $request)
    {

        $req = $request->data;
        $newPass = $req['password'];
        $user = User::find($req['Id']);

        try {

            $user->password = bcrypt($newPass);
            $user->save();

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Admin updated successfully',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }

    public function emailExist(Request $request)
    {

        if (User::whereEmail($request->email)->first()) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function phoneExist(Request $request)
    {

        if (User::wherePhone($request->phone)->first()) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function currentPassword(Request $request)
    {
        $pass = $request->currentpassword;
        $id = $request->Id;
        $user = User::find($id);

        if (Hash::check($pass, $user->password)) {

            return 'true';
        } else {

            return 'false';
        }
    }




    public function phoneExistWithId($id = null, Request $request)
    {

        if (User::where('Id', '!=', $id)->wherePhone($request->phone)->first()) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function allUsers()
    {
        $queryString = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $builder = User::query();
        $builder->where('role_id', 3)->where('is_active', 1);
        if (Input::has('filter') && $queryString != '') {
            $builder->where('full_name', 'LIKE', "$queryString%");
        }
        return $users = $builder->orderBy($sortcol, Input::get('sort'))->paginate(500)->toArray();
    }
    public function allEmployees()
    {
        $queryString = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $builder = User::query();
        $builder->where('role_id', 2);
        if (Input::has('filter') && $queryString != '') {
            $builder->where('full_name', 'LIKE', "$queryString%");
        }
        return $users = $builder->orderBy($sortcol, Input::get('sort'))->paginate(5000);
    }

    public function UsersHistory($id)
    {
        return UserSubscriptionHistory::with('packages', 'users')->where('user_id', $id)->paginate(50);
    }

    public function recentUsers()
    {
        $queryString = Input::get('filter');
        return $users = User::where('role_id', 3)->where('created_at', '>=',  Carbon::now()->subDays(7))
            ->where('full_name', 'LIKE', "$queryString%")->paginate(50);
    }
    public function recentEmp()
    {
        $queryString = Input::get('filter');
        return $users = User::where('role_id', 2)->where('created_at', '>=',  Carbon::now()->subDays(7))
            ->where('full_name', 'LIKE', "$queryString%")->paginate(50);
    }
    public function getrole_ids()
    {
        return $role_ids = role_ids::all();
    }
    public function getAuthUser()
    {

        $user = Auth::user();
        return $role_ids = role_ids::with('user_permissions')->where('id', $user->role_id)->first();
    }

    public function getadmin($id)
    {
        return  User::findOrFail($id);
    }

    public function editUser($id)
    {
        return  User::Where('id', $id)->with('shipping', 'billing')->get();
    }

    public function updateUser(Request $request)
    {
        //    return $request->all();
        $req = $request->data;
        $user = User::find($req['Id']);
        try {
            $user->full_name = $req['userForm']['full_name'];
            $user->phone = $req['userForm']['phone'];
            $user->email = $req['userForm']['email'];
            if ($req['billingForm']['billingPhone'] != null) {
                if ($user->billing_id == 0) {
                    $billing = BillingDetails::Create(
                        [
                            'phone' => $req['billingForm']['billingPhone'],
                            'home_address' => $req['billingForm']['billingHome_address'],
                            'first_name' => $req['billingForm']['billingFirstName'],
                            'last_name' => $req['billingForm']['billingLastName'],
                            'province' => $req['billingForm']['billingProvince'],
                            'city' => $req['billingForm']['billingCity']
                        ]
                    );
                    $user->billing_id = $billing->id;
                } else {
                    $billing = BillingDetails::Where('id', $user->billing_id)->first();
                    $billing->phone = $req['billingForm']['billingPhone'];
                    $billing->home_address = $req['billingForm']['billingHome_address'];
                    $billing->first_name = $req['billingForm']['billingFirstName'];
                    $billing->last_name = $req['billingForm']['billingLastName'];
                    $billing->province = $req['billingForm']['billingProvince'];
                    $billing->city = $req['billingForm']['billingCity'];
                    $billing->save();
                }
            }
            if ($req['shippingForm']['shippingPhone'] != null) {
                if ($user['shipping_id'] == 0) {
                    $shipping = ShippingDetails::Create(
                        [
                            'phone' => $req['shippingForm']['shippingPhone'],
                            'home_address' => $req['shippingForm']['shippingHome_address'],
                            'first_name' => $req['shippingForm']['shippingFirstName'],
                            'last_name' => $req['shippingForm']['shippingLastName'],
                            'province' => $req['shippingForm']['shippingProvince'],
                            'city' => $req['shippingForm']['shippingCity']
                        ]
                    );
                    $user->shipping_id = $shipping->id;
                } else {
                    $shipping = ShippingDetails::Where('id', $user->shipping_id)->first();
                    $shipping->phone = $req['shippingForm']['shippingPhone'];
                    $shipping->home_address = $req['shippingForm']['shippingHome_address'];
                    $shipping->first_name = $req['shippingForm']['shippingFirstName'];
                    $shipping->last_name = $req['shippingForm']['shippingLastName'];
                    $shipping->province = $req['shippingForm']['shippingProvince'];
                    $shipping->city = $req['shippingForm']['shippingCity'];
                    $shipping->save();
                }
            }
            $user->save();

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'User Details updated successfully',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }
    public function addUser(Request $request)
    {
        $req = $request->data;
        $user = new User;
        try {
            $user->first_name = $req['first_name'];
            $user->last_name = $req['last_name'];
            $user->phone = $req['phone'];
            $user->password = bcrypt($req['password']);
            $user->user_name = $req['first_name'] . ' ' . $req['last_name'];
            $user->activation_code = mt_rand(100000, 999999);
            $user->is_activate = 1;
            $user->is_activate = 0;
            $user->role_id = 2;
            $user->login_type = 'regular';
            $user->save();
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'User created successfully',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $users = User::all();
    }

    public function block($id, Request $request)
    {
        $req = $request->data;
        $user = User::find($id);
        $user->is_blocked = 1;
        $user->save();
        return '1';
    }

    public function unblock($id, Request $request)
    {
        $req = $request->data;
        $user = User::find($id);
        $user->is_blocked = 0;
        $user->save();
        return '1';
    }
    public function verify($id, Request $request)
    {
        $req = $request->data;
        $user = User::find($id);
        $user->selfie_verified = 1;
        $user->save();
    }
    public function unVerify($id, Request $request)
    {
        $req = $request->data;
        $user = User::find($id);
        $user->selfie_verified = 0;
        $user->save();
    }
    public function userCount()
    {

        return  User::where('role_id', 3)->count();
    }
    public function countPanel()
    {

        return  User::where('role_id', 2)->count();
    }

    public function getUserMatches()
    {

        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');

        return UserMatches::with(['from_users' => function ($query) {
            $query
                ->where('id', 'like', '%' . Input::get('filter') . '%')
                ->where('first_name', 'like', '%' . Input::get('filter') . '%')
                ->where('last_name', 'like', '%' . Input::get('filter') . '%')
                ->where('email', 'like', '%' . Input::get('filter') . '%')
                ->where('phone', 'like', '%' . Input::get('filter') . '%');
        }])
            ->with(['to_users' => function ($query) {
                $query->where('id', 'like', '%' . Input::get('filter') . '%')
                    ->where('first_name', 'like', '%' . Input::get('filter') . '%')
                    ->where('last_name', 'like', '%' . Input::get('filter') . '%')
                    ->where('email', 'like', '%' . Input::get('filter') . '%')
                    ->where('phone', 'like', '%' . Input::get('filter') . '%');
            }])->orderBy($sortcol, $sortorder)->paginate(50);

        //return UserMatches::getAllUserMatches($filter, $sortcol, $sortorder);

    }
    public function graph()
    {
        $today = Carbon::now();
        $files = User::where('created_at', '>', $today->subDays(7))->get();
        $totalCount = $files->count();
        $response = array();
        $i = 0;
        while ($i < 7) {
            $counterperday = 0;
            $dayOfWeek = Carbon::now()->subDays($i);
            foreach ($files as $file) {
                $createDate = new DateTime($file['created_at']);
                $createDatedaysofweek = new DateTime($dayOfWeek);
                $singleday = $createDatedaysofweek->format('Y-m-d');
                $strip = $createDate->format('Y-m-d');

                if ($singleday == $strip) {
                    $counterperday = $counterperday + 1;
                }
            }


            $response[$i] = $counterperday;
            $i++;
        }
        $object = new \stdClass();
        $object->counterperday = $response;
        return response()->json($object);
    }
    public function mingledGraph()
    {
        $today = Carbon::now();
        $files = UserMatches::where('created_at', '>', $today->subDays(7))->get();
        $totalCount = $files->count();
        $response = array();
        $i = 0;
        while ($i < 7) {
            $counterperday = 0;
            $dayOfWeek = Carbon::now()->subDays($i);
            foreach ($files as $file) {
                $createDate = new DateTime($file['created_at']);
                $createDatedaysofweek = new DateTime($dayOfWeek);
                $singleday = $createDatedaysofweek->format('Y-m-d');
                $strip = $createDate->format('Y-m-d');

                if ($singleday == $strip) {
                    $counterperday = $counterperday + 1;
                }
            }


            $response[$i] = $counterperday;
            $i++;
        }
        $object = new \stdClass();
        $object->counterperday = $response;
        return response()->json($object);
    }
    public function blockedByAdmin()
    {
        return User::where('is_blocked', 1)->paginate(50);
    }
    public function deactiveUsers()
    {

        $queryString = Input::get('filter');

        if (Input::has('filter') && $queryString != '') {

            $builder = DeactivedUsers::with('DeactiveUsers')->whereHas('DeactiveUsers', function ($q) use ($queryString) {
                $q->where('user_name', 'LIKE', "$queryString%");
            });
        } else {
            $builder = DeactivedUsers::with('DeactiveUsers');
        }

        return $deactiveUsers = $builder->paginate(50);
    }
    public function allBlockedUsers()
    {
        return $blockedUsers = UserBlocked::with(['fromUser' => function ($query) {
            $query->select('id', 'User_name', 'phone');
        }])
            ->with(['toUser' => function ($query) {
                $query->select('id', 'user_name', 'phone');
            }])->where('is_block', 1)->orderBy('created_at')->paginate(50);

        // with('fromUser','toUser')->where('is_blocked',1)->paginate();  
    }
    public function allreportsUsers()
    {
        return $blockedUsers = UserBlocked::with(['fromUser' => function ($query) {
            $query->select('id', 'User_name', 'phone');
        }])
            ->with(['toUser' => function ($query) {
                $query->select('id', 'user_name', 'phone');
            }])->where('is_block', '=', 0)->paginate(50);
        //    return $blockedUsers->where('is_block',0)->orderBy('created_at'->paginate(50));
        // with('fromUser','toUser')->where('is_blocked',1)->paginate();  
    }
    public function albumUser($id)
    {
        $media = Media::where('ref_id', $id)->paginate(50);
        $mediaImg = array();
        foreach ($media as $key => $value) {
            $mediaImg[$key] =  $value['media_url'];
        }
        return $mediaImg;
    }
    public function deActivate_activate($id)
    {
        try {
            $user = DeactivedUsers::where('user_id', $id)->delete();

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'User Activated Successfully',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => 'User Activation Failed',
                ]
            ], 200);
        }
    }
    public function updatePkg(Request $request)
    {
        $req = $request->all(['data']);

        try {
            $PkgChnageUser = UserSubscriptionHistory::updateOrCreate(['user_id' => $req['data']['UID']], ['package_id' => $req['data']['selectedstatus']]);
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Success',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => 'Failed',
                ]
            ], 200);
        }
    }

    public function addEmployee(Request $request)
    {
        $req = $request->data;
        $user = new User;
        try {
            $user->full_name = $req['full_name'];
            $user->phone = $req['phone'];
            $user->email = $req['email'];
            $user->gender = $req['gender'];
            $user->is_active = 1;
            $user->password = bcrypt($req['password']);
            $user->role_id = 2;
            $user->save();
            $thisUser = User::find($user->id);
            $permissions = new Permissions();
            $permissions->Emp_id = $user->id;
            $permissions->Read = $req['ReadPermissions'];
            $permissions->Write = $req['WritePermissions'];
            $permissions->Delete = $req['DeletePermissions'];
            $permissions->save();

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Employee created successfully',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }
    public function EditGetEmployees($id)
    {
        $user = User::find($id);
        $permission = Permissions::where('Emp_id', $id)->first();
        $userObj = array();
        $userObj['user'] = $user;
        $userObj['permission'] = $permission;
        return $userObj;
    }
    public function EmployeeUpdate(Request $request)
    {
        $req = $request->all(['data']);
        try {
            $user = User::where('id', $req['data']['ID'])->Update([
                'gender' => $req['data']['gender'],
                'full_name' => $req['data']['full_name'],
                'phone' => $req['data']['phone'],
                'email' => $req['data']['email'],
            ]);

            if (isset($req['data']['ReadPermissions']))
                $Read = $req['data']['ReadPermissions'];
            if (isset($req['data']['WritePermissions']))
                $Write = $req['data']['WritePermissions'];
            if (isset($req['data']['DeletePermissions']))
                $Delete = $req['data']['DeletePermissions'];

            $permission = Permissions::where('Emp_id', $req['data']['ID'])->Update([
                'Read' => $Read,
                'write' => $Write,
                'Delete' => $Delete,
            ]);
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Employee Updated successfully',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }
    public function getPrescriptions(Request $request)
    {
        if (array_key_exists('user_id', $request->all())) {
            return Prescriptions::where('ordered_by_user', $request->all()['user_id'])->orderBy('id', 'desc')->paginate();
        }
        if (array_key_exists('prescrip_id', $request->all())) {
            return Prescriptions::select('prescription_path')->where('id', $request->all()['prescrip_id'])->first();
        }
        return Prescriptions::where(['prescription_for' => 'Manual'])->orderBy('id', 'desc')->paginate();
        // return Prescriptions::orderBy('id','desc')->paginate();


    }

    public function updatePrescription($id)
    {
        return Prescriptions::where('id', $id)->update(['prescription_for' => 'Ordered']);
    }
    /**
     * this function handling uploading profile picture
     */
    public function uploadProfilePicture(Request $request)
    {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();

        $fileName  = uniqid('img_') . '.' . $ext;
        $imageSaved = Storage::putFileAs('/public/users/', $file, $fileName);

        if ($imageSaved) {
            $userDetails = User::find($request['admin_id']);
            $deleteImage = $userDetails['avatar'];
            $userDetails->avatar = 'users/' . $fileName;
            $userDetails->save();
            if ($deleteImage != "") {
                Storage::delete($deleteImage); //Delete previous image from storage
            }
            return $response_object = array(
                'response_code'     => \Config::get('constants.response.ResponseCode_success'),
                'response_message'  => __('user.profile_img_uploaded'),
                'response_param'    => 'User',
                'response_values'   => $userDetails
            );
        } else {
            return $response_object = array(
                'response_code' => \Config::get('constants.response.ResponseCode_fail'),
                'response_message' => __('user.profile_img_error'),
                'response_param' => 'User',
                'response_values' => new \stdClass()
            );
        }
    }
}
