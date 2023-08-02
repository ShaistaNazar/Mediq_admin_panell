<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\OrderTemp;
use App\Models\User;
use App\Models\UserPromotions;
use App\Models\RentalEquipments;
use App\Models\ShippingDetails;
use App\Models\BillingDetails;
use Stripe\Order;
use App\Http\Services\NotificationService;
use Carbon\Carbon;
use App\Http\Services\MessageService;
use DateTime;
use App\Models\Orders;
use App\Models\ServiceOrders;
use Illuminate\Support\Facades\DB;
use Auth;


class OrdersController extends Controller
{
    protected $msgService;
	function __construct(MessageService $msgService )
	{
		$this->msgService = $msgService;
	}
    
    public function allorders(Request $request)
    {
      $queryString = $request['filter'];
      $sortcol = $request['sortcol'];
      $builder = OrderTemp::query();
      $builder->with('details','users','PaymentMethods','shipping','billing','status','DelivProducts');
        if ($request['filter'] && $queryString !='') {
            $builder->where('order_number', 'LIKE', "$queryString%");
        }
        return $users = $builder->orderBy($request['sortcol'], $request['sort'])->paginate(50);
 
      //  $orders = OrderTemp::with('details','users','PaymentMethods','shipping','billing','status','DelivProducts')
      //  ->orderBy($request['sortcol'], $request['sort'])->paginate(30);

       if(array_key_exists('completed',$request->all())){
        $orders = OrderTemp::where('status',4)->with('details','users','PaymentMethods','shipping','billing','status','DelivProducts')->orderBy($request['sortcol'], $request['sort'])->paginate(30);
       }
       if(array_key_exists('pending',$request->all())){
        $orders = OrderTemp::whereNotIn('status',[1,4])->with('details','users','PaymentMethods','shipping','billing','status','DelivProducts')->orderBy($request['sortcol'], $request['sort'])->paginate(30);
       }
       if(array_key_exists('cancelled',$request->all())){
        $orders = OrderTemp::where('status',1)->with('details','users','PaymentMethods','shipping','billing','status','DelivProducts')->orderBy($request['sortcol'], $request['sort'])->paginate(30);
       }
       foreach ($orders as $key => $value) {
       
           $relationship=$value['details'];
           foreach ($relationship as $key => $val) 
           {
     
            if($val->product_type=='Medicines'){
                $val->load('medProducts');
            }
            if($val->product_type=='Equipments'){
             $val->load('equProducts');
            }
        //     if($val->product_type=='Services'){
        //         $val->load('servProducts.providers');
        //         $val->load('servProducts.providers.services');
        //    }
            if($val->product_type=='LabsTest'){
                $val->load('testProducts.testCategory');
                $val->load('prescription');
                $val->load('testProducts.labs'); 
            }
            if($val->product_type=='OtherMedicines'){
                $val->load('OtherMedicines');
               }
           }
     
        
       }
       return $orders;
    }
    public function singleOrder($id)
    {
       $orders = OrderTemp::with('details','users','PaymentMethods','shipping','billing','status','DelivProducts','prescription')->where('id',$id)->get();

       foreach ($orders as $key => $value) {
       
           $relationship=$value['details'];
           foreach ($relationship as $key => $val) 
           {     
            if($val->product_type=='Medicines'){
                $val->load('medProducts');
            }
            if($val->product_type=='Equipments'){
                $val->load('equProducts');
            }
            if($val->product_type=='LabsTest'){
                 $val->load('testProducts.labs');
                 $val->load('testProducts.testCategory');
            }
            if($val->product_type=='OtherMedicines'){
                $val->load('OtherMedicines');
               }
           }      
       }
       return $orders;
    }
    public function getHighestGrossingProducts()
    {
    $orders = OrderDetails::where('status',4)->SELECT('created_at','product_type', 'product_id', DB::raw("COUNT(product_type) as total_product"))
    ->groupBy('product_type', 'product_id')->orderBy('total_product', 'desc')->get();
    foreach ($orders as $key => $val) 
           {     
            if($val->product_type=='Medicines'){
                $val->load('medProducts');
            }
            if($val->product_type=='Equipments'){
                $val->load('equProducts');
            }
            if($val->product_type=='LabsTest'){
                 $val->load('testProducts.labs');
                 $val->load('testProducts.testCategory');
            }
            if($val->product_type=='OtherMedicines'){
                $val->load('OtherMedicines');
            }
           }
           return $orders;
    }
    public function getRentalEquipmentReport()
    {
        return RentalEquipments::with('equipment')
        ->SELECT('created_at','price', 'equipment_id', DB::raw("COUNT(equipment_id) as total_product"))
        ->groupBy('equipment_id')->orderBy('total_product', 'DESC')->paginate(50);
    }
    public function getHighestGrossingServices()
    {
    $orders = ServiceOrders::where('status',4)->SELECT('created_at','service_id', DB::raw("COUNT(service_id) as total_product"))
    ->with('services')
    ->groupBy('service_id')->orderBy('total_product', 'desc')->get();
           return $orders;
    }
    public function medicOrder($id)
    {
       return OrderTemp::with('medDetails.medProducts')->where('id',$id)->get();

    }
    public function equipOrder($id)
    {
       return OrderTemp::with('equipDetails.equProducts')->where('id',$id)->get();
    }
    public function labtestOrder($id)
    {
       return OrderTemp::with('LabsTestDetails.testProducts.labs','LabsTestDetails.testProducts.testCategory')->where('id',$id)->get();
    }
    public function otherMedOrder($id)
    {
       return OrderTemp::with('otherMedicineDetails.OtherMedicines')->where('id',$id)->get();
    }

    public function changeOrderStatus(Request $request)
    {
        $req = $request->all();
        $changeOrder = OrderTemp::find($req['data']);
        $changeOrder->status = $req['val'];
        $changeOrder->save();
        $changeOrderDetail = OrderDetails::where('order_number',$req['order'])->first();
        $changeOrderDetail->status = $req['val'];
        $changeOrderDetail->save();
        

        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'ResponseMessage' => 'Status Changed successfully',
            ]
                ], 200);
    }

    public function getPromotion()
    {
       $promotions = UserPromotions::get();
       if($promotions)
       {
        $addedPromotion = UserPromotions::first();
        if($addedPromotion)
        {
            $endDate = $promotions[0]->created_at->addDays(8);
            $alldata = [];
            $alldata[0] = $promotions;
            $alldata[1] = $endDate;
            $alldata[2] = $addedPromotion->total_users;
            return $alldata;
        }
       
       }     
       return $addedPromotion;
       
       
    }

    public function addPromotion(Request $request)
	{
        // $order=$this->ordersRepo->makePromotion($request);
        try
        {
        $promotions = UserPromotions::get();
        $orderInWeek = $request['data']['orders'];
		$percentage = $request['data']['discount'];
		$date = new Carbon; //  DateTime string will be 2014-04-03 13:57:34
		$date->subDays(7); // or $date->subDays(7),  2014-03-27 13:58:25
		// return $orders = Orders::select('user_id')->where('created_at', '>', $date->toDateTimeString())->groupBy('user_id')->get();

		$inDemand = OrderTemp::SELECT('user_id', DB::raw("COUNT(user_id) as total"))->where('created_at', '>', $date->toDateTimeString())->where('user_id', '!=', 1)
        ->groupBy('user_id')->get();
        // echo '<pre>';
        // print_r($inDemand);
        // die();
        $count = count($inDemand);
    $promotionCode = mt_rand(100000, 999999);
		foreach($inDemand as $key => $value)
		{
			if($value['total'] > $orderInWeek)
			{
			$addedPromotion = UserPromotions::create([
				'user_id' => $value['user_id'],
				'code' => $promotionCode,
                'percentage' => $percentage,
                'order_ratio' => $orderInWeek,
                'total_users' => $count
      ]);
              $userPhone = User::where('id',$addedPromotion->user_id)->first();
              if($userPhone){
                $maskName = "Home Medics";
                $textMessage = "Congratulation you have availed " . $addedPromotion->percentage . "% discount on your next order, promotion validity is 7 days. Your promotion code is ".$promotionCode;
                $sendMsg = $this->msgService->sendSmsMessage($textMessage , $userPhone->phone, $maskName);

              }
       }
    }
    // return $addedPromotion;
    //     foreach($addedPromotion as $key => $valueUser)
    //         {

    //             $userPhone = User::where('id',$addedPromotion->user_id)->first();
    //                 $maskName = "Home Medics";
    //                 $textMessage = "Congratulation you have availed " . $addedPromotion->percentage . "% discount on your next order, promotion validity is 7 days. Your promotion code is ".$promotionCode;
    //                 $sendMsg = $this->msgService->sendSmsMessage($textMessage , $userPhone->phone, $maskName);
    //         }
        
        // if($addedPromotion)
        // {
        //     foreach($addedPromotion as $key => $valueUser)
        //     {
        //         $userPhone = User::find($valueUser->user_id);
        //             $maskName = "Home Medics";
        //              $textMessage = "Congratulation you have availed" . $valueUser->percentage . "on your next order within, promotion validity is days";
        //             $sendMsg = $this->msgService->sendSmsMessage($textMessage , $userPhone->phone, $maskName);
        //     }
        // }

        // $count = UserPromotions::count();
        // $addedPromotion = UserPromotions::where('user_id', 0)->firstOrCreate(['total_users' => $count]);
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'ResponseMessage' => 'New Promotion created successfully',
            ]
                ], 200);
            }

                catch(\Exception $e){
                    return response()->json([
                        'ResponseHeader' => [
                            'ResponseCode' => 0,
                            'ResponseMessage' => $e->getMessage(),
                        ]
                            ], 200);
                }
    }
    
    public function endPromotion()
    {
        try{
       $promotions = UserPromotions::get();
       if($promotions)
       {
        UserPromotions::truncate();
       }   
       return response()->json([
        'ResponseHeader' => [
            'ResponseCode' => 1,
            'ResponseMessage' => 'Promotion Removed successfully',
        ]
            ], 200);
        }

            catch(\Exception $e){
                return response()->json([
                    'ResponseHeader' => [
                        'ResponseCode' => 0,
                        'ResponseMessage' => $e->getMessage(),
                    ]
                        ], 200);
            }       
    }

    public function serviceOrdersGet(Request $request)
    {
        $Order = ServiceOrders::with('users','services','providers')->orderBy($request['sortcol'], $request['sort'])->paginate(30);
        if(array_key_exists('completed',$request->all())){
            $Order = ServiceOrders::where('status',4)->with('users','services','providers')->paginate(30);
           }
           if(array_key_exists('pending',$request->all())){
            $Order = ServiceOrders::whereNotIn('status',[1,4])->with('users','services','providers')->paginate(30);
           }
           if(array_key_exists('cancelled',$request->all())){
            $Order = ServiceOrders::where('status',1)->with('users','services','providers')->paginate(30);
           }
           return $Order;
    }

    public function providerSelected(Request $request)
    {
        try{
            $payment_m = 0;
            if($request['data']['TotalAmount'] > 50000){
                $payment_m = 4;
            }
       $selectProvider = ServiceOrders::where('id',$request['data']['orderId'])->update([
           'provider_id' => $request['data']['SelectedProvider']['id'],
           'total_amount' => $request['data']['TotalAmount'],
           'payment_status' => 0,
           'status' => 3,
           'payment_method_id' => $payment_m
       ]);
       $user_id = ServiceOrders::where('id',$request['data']['orderId'])->first();

       $serviceNotification = array("user_id"=>$user_id['order_from_user'], "provider_name"=>$request['data']['SelectedProvider']['full_name'],
       "phone"=>$request['data']['SelectedProvider']['phone'], "order_amount"=>$request['data']['TotalAmount'] , "order_id"=>$request['data']['orderId'],  "order_number"=>$request['data']['orderNumber']);

       $checkNotyResponce = NotificationService::notifyjazcash($serviceNotification);
       return response()->json([
        'ResponseHeader' => [
            'ResponseCode' => 1,
            'ResponseMessage' => 'Service Provider Selected',
        ]
            ], 200);
        }

            catch(\Exception $e){
                return response()->json([
                    'ResponseHeader' => [
                        'ResponseCode' => 0,
                        'ResponseMessage' => $e->getMessage(),
                    ]
                        ], 200);
            }       
    }

    public function statusChangeOrder(Request $request)
    {
        $req = $request->all();
        return ServiceOrders::where('id', $req['orderId'])
       ->update([
           'payment_status' => $req['status']
        ]);
    }

    public function serviceOrder(Request $request){
        try{
            $orderNumber = $this->orderNumber();
                $servicetypes = ServiceOrders::create([
                    'order_number' => $orderNumber,
                    'service_id' => $request['data']['selectedSer']['services_id'],
                    'order_from_user' => Auth::id(),
                    'comments' => $request['data']['comments'],
                    'order_for' => $request['data']['name'],
                    'total_amount' => $request['data']['TotalAmount'],
                    'by_admin' => 1,
                    'provider_id' => $request['data']['selectedSer']['id'],
                    'status' => 3,
                ]);
                return response()->json([
                    'ResponseHeader' => [
                        'ResponseCode' => 1,
                        'ResponseMessage' => 'Service Provider Selected',
                    ]
                        ], 200);
            }
    
                catch(\Exception $e){
                    return response()->json([
                        'ResponseHeader' => [
                            'ResponseCode' => 0,
                            'ResponseMessage' => $e->getMessage(),
                        ]
                            ], 200);
                }
    }
    public function orderInWeek(Request $request)
    {
        $today = Carbon::now();
        $files = OrderTemp::where('created_at', '>', $today->subDays(7))->get();
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
                    $counterperday = $counterperday+1;
                }
 
            }
 
 
            $response[$i] = $counterperday;
            $i++;
        }
        $object = new \stdClass();
        $object->counterperday = $response;
        return response()->json($object);
    }
    function orderNumber(){
        return $orderNumber= Auth::id().time();
      }
    public function newOrder(Request $request)
    {
        $data = $request->all();
        $prescription_id = 0;
        if(array_key_exists('equipdata',$request->all())){
            $equipdata = $request->all()['equipdata'];
        }
        if(array_key_exists('prescription_id',$request->all())){
          $prescription_id = $request->all()['prescription_id'];
      }
        if(array_key_exists('miscellaneousMedicinedata',$request->all())){
            $miscellaneousMedicinedata = $request->all()['miscellaneousMedicinedata'];
        }
        if($request->all()['data']['shipping_id'] ==0 && $request->all()['data']['billing_id'] ==0){
        $shippingDetail = ShippingDetails::create(['first_name' => $data['data']['shippingFirstName'],
        'last_name' => $data['data']['shippingLastName'],
        'phone' => $data['data']['shippingPhone'],
        'city' => $data['data']['shippingCity'],
        'province' => $data['data']['shippingProvince'],
        'home_address' => $data['data']['shippingHome_address']]);

        $billingDetail = BillingDetails::create(['first_name' => $data['data']['billingFirstName'],
        'last_name' => $data['data']['billingLastName'],
        'phone' => $data['data']['billingProvince'],
        'city' => $data['data']['billingCity'],
        'province' => $data['data']['billingProvince'],
        'home_address' => $data['data']['billingHome_address']]);
            $shippingDetail_id = $shippingDetail->id;
            $billingDetail_id =  $billingDetail->id;
        }else{
            $shippingDetail_id = $request->all()['data']['shipping_id'];
            $billingDetail_id =  $request->all()['data']['billing_id'];

        }        
        $orderNumber = $this->orderNumber();

        $orderTemp = OrderTemp::create(['order_number' => $orderNumber,
        'shipping_id' => $shippingDetail_id,
        'billing_id' => $billingDetail_id,
        'payment_method_id' => 0,
        'is_admin' => 1,
        'delivery_type_id' => 1,
        'prescription_id' => $prescription_id,
        'total_amount' => $data['data']['TotalAmount'],
        'user_id' =>  $request->all()['data']['user_id'],
        'status' => 3]);
        if(!empty($equipdata)){
            foreach ($equipdata as $equip){
                $equiorderDetail = OrderDetails::create(['order_number' => $orderNumber,
                'product_type' => 'Equipments',
                'product_id' => $equip['id'],
                'quantity' => $equip['quantity'],
                'status' => 1]);
                }       
        }
        if(!empty($miscellaneousMedicinedata)){
            foreach ($miscellaneousMedicinedata as $mmdata){
                $equiorderDetail = OrderDetails::create(['order_number' => $orderNumber,
                'product_type' => 'OtherMedicines',
                'product_id' => $mmdata['id'],
                'quantity' => $mmdata['quantity'],
                'status' => 1]);
                }       
        }

        if(!empty($data['data']['MedsForm'])){
            foreach ($data['data']['MedsForm'] as $med){
            if($med['selectedMedicine'] != ""){
                $medorderDetail = OrderDetails::create(['order_number' => $orderNumber,
                'product_type' => 'Medicines',
                'product_id' => $med['selectedMedicine']['id'],
                'quantity' => $med['quantity'],
                'status' => 1]);

                }
            }       
        }

        if(!empty($data['data']['TestsForm'])){
                foreach ($data['data']['TestsForm'] as $test){
                    if($test['selectedTest'] != ""){
                    $testorderDetail = OrderDetails::create(['order_number' => $orderNumber,
                    'product_type' => 'LabsTest',
                    'product_id' => $test['selectedTest']['id'],
                    'quantity' => $test['quantity'],
                    'status' => 1]);
                    }       
            }
        }
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'ResponseMessage' => 'Your has been successfully placed. Please proceed with the payment section to complete your order',
            ]
                ], 200);
        
    }
    public function completeCount(){
        return OrderTemp::where('status',4)->count();

    }
    public function pendingCount(){
        return OrderTemp::whereNotIn('status',[1,4])->count();

    }
    public function cancelCount(){
        return OrderTemp::where('status',1)->count();

    }
}
