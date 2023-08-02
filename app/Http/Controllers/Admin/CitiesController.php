<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cities;

class CitiesController extends Controller
{
    public function getCities()
    {
        return cities::Where('city_name', 'like', '%' . '%')->paginate(50);
    }
    public function getCitiesToShow()
    {
        return cities::where('is_show',1)->get();
    }
    // public function allCities()
    // {  
    //     return cities::all();
    // }
    // public function allCitiesDropdown()
    // {
    //     return  cities::Where('name', 'like', '%' . '%');
    // }


    public function citiesforproperty()
    {  
        return  cities::select('id','name')->get();
    }
    public function citiesforarea()
    {  
        return  cities::select('id','name')->get();
    }
    public function citiesfortown()
    {  
        return  cities::select('id','name')->get();
    }
    public function editcity($id)
    {
         return  cities::findOrFail($id);
    }

    public function updateCity(Request $request)
    {
        $req = $request->data;
        $cities = cities::find($req['Id']);
        try{
            $cities->city_name = $req['name'];
            $cities->save();
            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'cities updated successfully',
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

    public function cityStatus(Request $request)
    {
        $req = $request->all();
        $cities = cities::find($req['city']);
        try{
            $cities->is_show = $req['status'];
            $cities->save();
            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'cities updated successfully',
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

    public function addCity(Request $request) {
        $cities = new cities;
        $cities->city_name = $request['data']['name'];
        $cities->province = $request['data']['province_name'];
        $cities->is_show = $request['data']['status'];
        $cities->save();
        return $cities;
      }


        public function destroycity($id)
    {
        $cities = cities::findOrFail($id);
        $cities->delete();
        return $cities = cities::all();
    }
    //for selection fields
    public function city()
    {
        return  Cities::orderBy('name', 'ASC')->get(['id', 'name']);
    }
    public function citiesarea(Cities $cities)
    {
        return $Cities->citiesarea()->orderBy('name', 'ASC')->get(['id', 'name']);
    }
    public function citiestown(Cities $cities)
    {
        return $Cities->citiestown()->orderBy('name', 'ASC')->get(['id', 'name']);
    }
    //
}
