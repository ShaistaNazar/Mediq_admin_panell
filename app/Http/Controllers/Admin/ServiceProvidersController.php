<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\ServiceProviders;
use App\Models\ServiceDetails;
use App\Models\CityServices;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Messagebird;


class ServiceProvidersController extends Controller
{
    public function allServicesProviders()
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');
        $builder = ServiceProviders::query();
        $builder->with('services','servicesDetails.allCities')->withCount('providers');
        if (Input::has('filter') && $filter !='') {
        $builder->where('full_name', 'like', Input::get('filter') . '%');
        $builder->orWhere('phone', 'like', Input::get('filter') . '%');
        }
        return $users = $builder->orderByDesc($sortcol, $filter)->paginate(5000);               
      }
    public function providersDropdown(Request $request)
    {
        $req = $request->all();
        return ServiceProviders::with('providersData')->get();
// print_r($req);
        // $requiredDate = $req['date'];
        // $requiredTimeFrom =  date("H:i:s", strtotime($req['fromTime'])) . "\n";;
        // $requiredTimeTo = date("H:i:s", strtotime($req['toTime'])) . "\n";
        // $requiredServices = $req['service'];

        // print_r($requiredTimeFrom);
        // print_r($requiredTimeTo);

        // return $Providers = ServiceProviders::with('providersData')
        //     ->with('dropDownProvider')->whereHas('dropDownProvider', function( $query) use ($requiredDate, $requiredTimeTo, $requiredTimeFrom) {
        //         $query
        //         ->where('available_from','<=' ,$requiredDate)
        //         ->where('available_to','>=' ,$requiredDate)
        //         ->where('from_time','<=' ,$requiredTimeFrom)
        //         ->where('to_time','>=' ,$requiredTimeTo);
        //     })
        //     ->where('services_id', $requiredServices)->get();
    }  
    
    public function providersDropdownOrder(Request $request)
    {
        $req = $request->all();
        $requiredServices = $req['service'];

        return $Providers = ServiceProviders::with('dropDownProvider')
            ->where('services_id', $req['service'])->get();
    }  

    public function destroy($id)
    {
        $ServiceProviders = ServiceProviders::findOrFail($id);
        $ServiceProviders->delete();
        return $ServiceProviders = ServiceProviders::all();
    }

    
    public function addProviders(Request $request)
    {
        $req = $request->data;
        $ServiceProviders = new ServiceProviders;
        $serviceDetail = new ServiceDetails;
        $userMailExist = ServiceProviders::where('email',$req['email'])->first();
        // print_r($userMailExist);die();
        if($userMailExist){
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => 'Provider is already registered with this E-mail',
                ]
                    ], 200);
        }
        try{
            $ServiceProviders->full_name = $req['full_name'];
            $ServiceProviders->dob = $req['dob'];
            $ServiceProviders->email = $req['email'];
            $ServiceProviders->gender = $req['gender'];
            $ServiceProviders->phone = $req['phone'];
            $ServiceProviders->services_id = $req['selectedService'];
            $ServiceProviders->save();
            // print_r($ServiceProviders->id);die();
            $serviceDetail->service_provider_id = $ServiceProviders->id;
            $serviceDetail->city_id = $req['selectedCity'];
            $serviceDetail->price_per_hour = $req['price'];
            $serviceDetail->available_from = $req['fromDate'];
            $serviceDetail->available_to = $req['toDate'];
            $serviceDetail->from_time = date("H:i:s", strtotime($req['fromTime'])) . "\n";
            $serviceDetail->to_time = date("H:i:s", strtotime($req['toTime'])) . "\n";
            $serviceDetail->save();
            $message = 'Dear'. $serviceDetail->full_name .' You Are now registered as Home Service Provider ';
            Messagebird::createMessage('Mingle', $recipients = [$ServiceProviders->phone], $message);

            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'id' => $ServiceProviders->id,
                           'ResponseMessage' => 'Service Provider added successfully',
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

    public function iconSet(Request $request, $id)
    {

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        $filename  = uniqid('img_') . '.' . $ext;

        if (Storage::putFileAs('/public/providerImg/', $file, $filename)) {
            $ServiceProviders = ServiceProviders::find($id);
            $ServiceProviders->avatar = 'providerImg/'.$filename;
            $ServiceProviders->save();
            return $filename;
        }
    }

    
    public function updateproviders(Request $request)
    {
        $req = $request->data;
        $ServiceProviders = ServiceProviders::find($req['Id']);
        $serviceDetail = ServiceDetails::where('service_provider_id',$req['Id']);
        try{
            $ServiceProviders->full_name = $req['full_name'];
            $ServiceProviders->dob = $req['dob'];
            $ServiceProviders->email = $req['email'];
            $ServiceProviders->gender = $req['gender'];
            $ServiceProviders->phone = $req['phone'];
            $ServiceProviders->services_id = $req['selectedService'];
            $ServiceProviders->save();

            $from_time = date("H:i:s", strtotime($req['fromTime'])) . "\n";
            $to_time = date("H:i:s", strtotime($req['toTime'])) . "\n";

            $serviceDetail = ServiceDetails::where('service_provider_id',$req['Id'])->
            Update([
                'city_id' => $req['selectedCity'],
                'price_per_hour' => $req['price'],
                'available_from' => $req['fromDate'],
                'available_to' => $req['toDate'],
                'from_time' => $from_time,
                'to_time' => $to_time
            ]);

            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'id' => $req['Id'],
                           'ResponseMessage' => 'Service Provider updated successfully',
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

    public function EditService($id)
    {
         return  ServiceProviders::where('id',$id)->with('services','servicesDetails.allCities')->get();
    }


    public function countTotal() {

        return  ServiceProviders::count();
    
    }
    public function getCityServices(Request $request) {
      return  CityServices::where('city_id',$request['city_id'])->with('city_service')->get();
  
  }
}
