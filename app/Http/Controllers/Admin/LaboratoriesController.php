<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratories;
use App\Models\TestsCategory;
use App\Models\TestsInLabCategory;
use App\Models\Medicines;
use App\Models\Equipments;
use App\Models\MedicinesCategory;
use App\Models\Tests;
use App\Models\HMServices;
use Illuminate\Support\Facades\Input;


class LaboratoriesController extends Controller
{
    public function allLaboratories()
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');
        return Laboratories::Where('lab_name', 'like',  Input::get('filter') . '%')->orderBy($sortcol, $sortorder)->paginate(50);
    }

    public function allLaboratoriesDropdown()
    {
        return Laboratories::get();
    }

    public function addLaboratories(Request $request)
    {
        try {
            $Laboratories = new Laboratories;
            $Laboratories->lab_name = $request->data['lab_name'];
            $Laboratories->save();

            foreach ($request->data['pharmaCat'] as $oneCat) {

                if (isset($oneCat['enable'])) {
                    $featuresData[] = array('lab_id' => $Laboratories->id, 'testcategory_id' => $oneCat['id']);
                }
            }
            TestsInLabCategory::insert($featuresData);
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Laboratories updated successfully',
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

    public function destroyLaboratories($id)
    {
        $Laboratories = Laboratories::findOrFail($id);
        $Laboratories->delete();
        return $Laboratories = Laboratories::all();
    }

    public function updateLaboratoriesGet($id)
    {
        return  Laboratories::findOrFail($id);
    }

    public function updateLaboratories(Request $request)
    {
        $req = $request->data;
        $Laboratories = Laboratories::find($req['id']);
        try {
            $Laboratories->lab_name = $request->data['lab_name'];

            $categories = [];
            // Set Subscription Feature table
            foreach ($req['pharmaCat'] as $pharmaCat) {
                if ($pharmaCat['enable']) {
                    $categories[] = $pharmaCat['id'];
                }
            }

            $Laboratories->TestSyncCat()->sync($categories);

            // foreach($req['pharmaCat'] as $pharmaCat) {
            //     if(isset($pharmaCat['enable'])) {

            //             TestsInLabCategory::updateOrCreate(['lab_id' => $req['id'] , 'testcategory_id' => $pharmaCat['id']]);
            //     }
            //     else{die('1');
            //             TestsInLabCategory::where(['lab_id' => $req['id'] , 'testcategory_id' => $pharmaCat['id']])->delete();
            //     }


            // }

            $Laboratories->save();
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Laboratories updated successfully',
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

    public function inDemandMed()
    {
        try {

            return $medicines = Medicines::where('in_demand', 1)->paginate(50);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }
    public function inDemandEqu(Request $request)
    {
        $input = $request->all();
        try {
            return $medicines = Equipments::where('in_demand', 1)->where('is_rental',$input['is_rental'])->paginate(50);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }
    public function inDemandTest()
    {
        try {

            return $medicines = Tests::with('testCategory')->where('in_demand', 1)->paginate(50);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
        }
    }
    public function inDemandRem(Request $request)
    {
       
        try {
            if ($request['type'] == 'test') {
                $Tests = Tests::where('id', $request['id'])->first();
                $Tests->in_demand = 0;
                $Tests->save();
            }
            if ($request['type'] == 'medicine') {
                $medicines = Medicines::where('id', $request['id'])->first();
                $medicines->in_demand = 0;
                $medicines->save();
            }
            if ($request['type'] == 'equipment') {
                $Equipments = Equipments::where('id', $request['id'])->first();
                $Equipments->in_demand = 0;
                $Equipments->save();
            }
            
        } catch (\Exception $e) {
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
        try {
            if($request['type'] == 'medicine')
                Medicines::where('id', $request['id'])->update(['in_demand' => 1]);
            if($request['type'] == 'equipment')
                Equipments::where('id', $request['id'])->update(['in_demand' => 1]);
            if($request['type'] == 'test')
                Tests::where('id', $request['id'])->update(['in_demand' => 1]);
            if($request['type'] == 'med_category')
                MedicinesCategory::where('id', $request['id'])->update(['in_demand' => 1]);
            if($request['type'] == 'test_category')
                TestsCategory::where('id', $request['id'])->update(['in_demand' => 1]);
            if($request['type'] == 'hm_service')
                HMServices::where('id', $request['id'])->update(['in_demand' => 1]);

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Added to in-Demand successfully',
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
}
