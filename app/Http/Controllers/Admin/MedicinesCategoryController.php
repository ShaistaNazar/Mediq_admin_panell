<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Medicines;
use Illuminate\Support\Facades\Input;
use App\Models\MedicinesCategory;

class MedicinesCategoryController extends Controller
{
    public function dropdown(){
        return MedicinesCategory::get();
    }
    public function dropdownSelected($categoryID){
        return Medicines::where('category_id',$categoryID)->get();
    }

    public function allMedicinesCat()
    {
        $filter = Input::get('filter');
        return MedicinesCategory::where('category_name', 'like', Input::get('filter') . '%')->paginate(30);
    }

    public function destroyMedicineCat($id)
    {
        $cities = MedicinesCategory::findOrFail($id);
        $cities->delete();
        return $cities = MedicinesCategory::all();
    }

    public function addMedicineCat(Request $request)
    {
        try{
        $data = $request->all();
            
        $medicine = new MedicinesCategory();
        $medicine->category_name = $data['data']['category_name'];
        $medicine->in_demand = $data['data']['in_demand'];
        $medicine->save();
        
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $medicine->id,
                'ResponseMessage' => 'Added successfully',
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
    public function updateMedicineCat(Request $request)
    {
        try{
        $data = $request->all()['data'];
            
        $medicine = MedicinesCategory::where('id', $data['id'])->update(['category_name' => $data['cat_name']]);
        
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $medicine,
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

        if (Storage::putFileAs('/public/images/', $file, $filename)) {
            $Subscriptions = Medicines::find($id);
            $Subscriptions->medicine_image = $filename;
            $Subscriptions->save();
            return $filename;
        }
    }

    
}
