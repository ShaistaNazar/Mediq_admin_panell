<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacies;
use App\Models\Cities;
use App\Models\PharmacyCatMedicine;

class PharmaciesController extends Controller
{
    public function allPharmacies()
    {
       return Pharmacies::with('allCities')->paginate(100);
    }

    public function updatePharmacies($id)
    {
       $pharmacies = Pharmacies::with('allcities')->where('id',$id)->first();
       $cities = Cities::get();
       $pharmacies_cities = array();
       $pharmacies_cities['pharmacies'] = $pharmacies;
       $pharmacies_cities['cities'] = $cities;
       return $pharmacies_cities;
    }
    public function updatePostPharmacies(Request $request)
    {
        try{
        $data = $request->all();        
        $pharmacyID = $data['data']['pharmacies']['id'];
        $selectedCity = ($data['data']['selectedCity']);
        $updatedName = ($data['data']['pharmacies']['pharmacy_name']);
        $cityID = Cities::select('id')->where('city_name',$selectedCity)->first();
        $update = Pharmacies::where('id',$data['data']['pharmacies']['id'])->Update([
            'pharmacy_name' => $updatedName,
            'city_id' => $cityID->id
        ]);
        foreach($data['data']['pharmaCat'] as $pharmaCat) {
            if(isset($pharmaCat['enable'])) {
                if($pharmaCat['status'] == true)
                {
                    PharmacyCatMedicine::updateOrCreate(['pharmacy_id' => $pharmacyID , 'medicine_category_id' => $pharmaCat['id']]);
                }
                else{
                    PharmacyCatMedicine::where(['pharmacy_id' => $pharmacyID , 'medicine_category_id' => $pharmaCat['id']])->delete();
                }
            }
            

        }
        
       return response()->json([
        'ResponseHeader' => [
            'ResponseCode' => 1,
            'ResponseMessage' => 'Pharmacy Updated successfully',
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
        // print_r($updatedName);
    }

    public function addPharmacies(Request $request)
    {
        try{
        $data = $request->all();
        $selectedCity = ($data['data']['selectedCity']);
        $updatedName = ($data['data']['pharmacy_name']);
        $cityID = Cities::select('id')->where('city_name',$selectedCity)->first();
        $update = Pharmacies::Create([
            'pharmacy_name' => $updatedName,
            'city_id' => $cityID->id
        ]);
        //   print_r($data['data']['pharmaCat']);die();

        foreach($data['data']['pharmaCat'] as $pharmaCat) {
            
            if(isset($pharmaCat['enable'])) {
                PharmacyCatMedicine::Create(['pharmacy_id' => $update->id , 'medicine_category_id' => $pharmaCat['id']]);
            }

        }
        
       return response()->json([
        'ResponseHeader' => [
            'ResponseCode' => 1,
            'ResponseMessage' => 'Pharmacy Added successfully',
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

    public function DeletePharmacy($id)
    {

            $Pharmacies = Pharmacies::findOrFail($id);
            $Pharmacies->delete();
            return $Pharmacies = Pharmacies::all();
    }

    public function dropdown(){
        return Pharmacies::get();
    }
}
