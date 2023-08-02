<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Medicines;
use App\Models\MiscellaneousMedicines;
use App\Models\MedicineWarning;
use App\Models\Pharmacies;
use App\Models\MedicinesCategory;
use Illuminate\Support\Facades\Storage;


class MedicinesController extends Controller
{
    public function allMedicinesDropdown(){
        return Medicines::all();
    }
    public function allMiscellaneousMedicinesDropdown(){
        return MiscellaneousMedicines::all();
    }

    public function allMedicines()
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');

        return Medicines::with('category','MedicineWarning')
            ->where('medicine_name', 'like',  Input::get('filter') . '%')
            ->orderBy(Input::get('sortcol'), Input::get('sort'))->paginate(50);
    }
    public function allMedicinesCat()
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');

        return MedicinesCategory::where('category_name', 'like',  Input::get('filter') . '%')->paginate(50);
    }

   
    public function destroyMedicine($id)
    {
        $cities = Medicines::findOrFail($id);
        $cities->delete();
        return $cities = Medicines::all();
    }
    public function editMedicine($id)
    {
        return Medicines::with('MedicineWarning')->where('id',$id)->first();
    }

    public function updateMedicine(Request $request)
    {
        try{
        $data = $request->all();
        $medicine = Medicines::find($data['data']['id']);
        $medicine->medicine_name = $data['data']['medicine_name'];
        // $medicine->available_quantity = $data['data']['available_quantity'];
        $medicine->price = $data['data']['price'];
        // $medicine->expairy_date = $data['data']['expairy_date'];
        // $medicine->brand = $data['data']['brand'];
        $medicine->is_prescription_req = $data['data']['is_prescription_req'];
        $medicine->composition = $data['data']['composition'];
        // $medicine->how_to_take = $data['data']['howToTake'];
        // $medicine->pharmacy_id = $data['data']['pharmacy_id'];
        $medicine->category_id = $data['data']['category_id'];
        $medicine->primary_use = $data['data']['PrimaryUse'];
        $medicine->save();
        if(!empty($data['data']['MedicineWarnings'])){
            foreach($data['data']['MedicineWarnings'] as $key => $value){
                $warning = MedicineWarning::UpdateOrCreate([
                    'id'       => $value['id']],[
                        'title'       => $value['title'],
                        'detail'       => $value['detail']
                ]);
            }
        }
        if(!empty($data['data']['addMedicineWarnings'])){
            foreach($data['data']['addMedicineWarnings'] as $key => $value){
                $warning = MedicineWarning::Create([
                        'medicine_id'       => $medicine->id,
                        'title'       => $value['title'],
                        'detail'       => $value['detail']
                ]);
            }
        }

        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $medicine->id,
                'ResponseMessage' => 'Updated successfully',
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

        if (Storage::putFileAs('/public/medicines_images/', $file, $filename)) {
            $Subscriptions = Medicines::find($id);
            $Subscriptions->medicine_image = 'medicines_images/'.$filename;
            $Subscriptions->save();
            return $filename;
        }
    }
    public function addMedicine(Request $request)
    {
        try{
        $data = $request->all();

        $medicine = new Medicines;
        $medicine->medicine_name = $data['data']['medicine_name'];
        // $medicine->available_quantity = $data['data']['available_quantity'];
        $medicine->price = $data['data']['price'];
        // $medicine->expairy_date = $data['data']['expiry_date'];
        // $medicine->brand = $data['data']['brand'];
        $medicine->is_prescription_req = $data['data']['is_prescription_req'];
        $medicine->status = $data['data']['status'];
        $medicine->category_id = $data['data']['category_id'];
        $medicine->composition = $data['data']['composition'];
        // $medicine->how_to_take = $data['data']['howToTake'];
        $medicine->primary_use = $data['data']['PrimaryUse'];
        $medicine->save();
        if(!empty($data['data']['MedicineWarnings'])){
            foreach($data['data']['MedicineWarnings'] as $key => $value){
                if(!empty($value['detail'])){
                    $warning = MedicineWarning::create([
                        'title'       => $value['title'],
                        'detail'       => $value['detail'],
                        'medicine_id'       => $medicine->id
                ]);
               }
            }
        }        
        
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $medicine->id,
                'ResponseMessage' => 'Medicine Added successfully',
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

    public function inDemandAdd(Request $request)
{
   
    $req = $request->data;
    if($req['type'] == 1)
    try{
        $user->full_name = $req['full_name'];
        $user->phone = $req['phone'];
        $user->email = $req['email'];
        $user->dob = $req['dob'];
        $user->save();

        $billing = BillingDetails::Where('id', $user->billing_id)->first();
        $billing->phone = $req['billingPhone'];
        $billing->home_address = $req['billingHome_address'];
        $billing->first_name = $req['billingFirstName'];
        $billing->last_name = $req['billingLastName'];
        $billing->province = $req['billingProvince'];
        $billing->city = $req['billingCity'];
        $billing->save();

        $shipping = ShippingDetails::Where('id', $user->billing_id)->first();
        $shipping->phone = $req['shippingPhone'];
        $shipping->home_address = $req['shippingHome_address'];
        $shipping->first_name = $req['shippingFirstName'];
        $shipping->last_name = $req['shippingLastName'];
        $shipping->province = $req['shippingProvince'];
        $shipping->city = $req['shippingCity'];
        $shipping->save();
        
        return response()->json([
                   'ResponseHeader' => [
                       'ResponseCode' => 1,
                       'ResponseMessage' => 'User Details updated successfully',
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

public function countMedicines() {

    $medicine = Medicines::count();
    $miscellaneousMedicine = MiscellaneousMedicines::count();
    return $medicine + $miscellaneousMedicine;

}
public function allMiscellaneousMedicines()
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');

        return MiscellaneousMedicines::where('medicine_name', 'like',  Input::get('filter') . '%')
            ->orderBy(Input::get('sortcol'), Input::get('sort'))->paginate(10);
    }
    public function destroyMiscellaneousMedicine($id)
    {
        $medicine = MiscellaneousMedicines::findOrFail($id);
        $medicine->delete();
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $medicine->id,
                'ResponseMessage' => 'Deleted successfully',
            ]
                ], 200);
    }
    public function editMiscellaneousMedicine($id)
    {
        return MiscellaneousMedicines::where('id',$id)->first();
    }

    public function updateMiscellaneousMedicine(Request $request)
    {
        try{
        $data = $request->all();
        if(array_key_exists('id',$data['data']) ){
          $medicine = MiscellaneousMedicines::find($data['data']['id']);
        }else{
          $medicine = new MiscellaneousMedicines;
        }
        $medicine->medicine_name = $data['data']['medicine_name'];
        $medicine->price = $data['data']['price'];
        $medicine->is_prescription_req = $data['data']['is_prescription_req'];
        $medicine->save();
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $medicine->id,
                'ResponseMessage' => 'Updated successfully',
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
}
