<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HMServices;
use App\Models\CityServices;
use Illuminate\Support\Facades\Input;


class HMServicesController extends Controller
{
    public function allServices()
    {
        return HMServices::where('service_name', 'like', '%' . '%')->orderBy('created_at', 'desc')->paginate(50);
    }

    public function allServicesDropdown()
    {
        return HMServices::get();
    }

    public function destroy($id)
    {
        $HMServices = HMServices::findOrFail($id);
        $HMServices->delete();
        return $HMServices = HMServices::all();
    }

    
    public function addService(Request $request)
    {
        $req = $request->data;
        $HMServices = new HMServices;
        try{
            $HMServices->service_name = $req['service_name'];
            $HMServices->in_demand = $req['in_demand'];
            $HMServices->save();
            if(!empty($req['cities'])){
                foreach($req['cities'] as $city){
                    CityServices::create(['city_id' => $city ,
                    'service_id' => $HMServices->id]);
                }
            }
            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'HMServices updated successfully',
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

    
    public function updateService(Request $request)
    {
        $req = $request->data;
        $HMServices = HMServices::find($req['Id']);
        try{
            $HMServices->service_name = $req['service_name'];
            $HMServices->in_demand = $req['in_demand'];

            $HMServices->save();
            $deleteServiceCity = CityServices::where('service_id',$HMServices->id)->delete();
            if(!empty($req['cities'])){
                foreach($req['cities'] as $city){
                    CityServices::updateOrCreate(['city_id' => $city ,
                    'service_id' => $HMServices->id]);
                }
            }
            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'HMServices updated successfully',
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
        $services = HMServices::with('service_city')->findOrFail($id);
        $services->cities = [];
        if(count($services->service_city) > 0){
            foreach($services->service_city as $key => $city){
                $cities2[$key] = $city->city_id;                
            }
        $services->cities = $cities2;
        }
        return $services;
    }
}
