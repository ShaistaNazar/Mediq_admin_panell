<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Tests;
use App\Models\TestsCategory;
use App\Models\TestsInLabCategory;

class TestsController extends Controller
{
    public function allTests()
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');
        return Tests::with('testCategory')->orwhere('test_name', 'like', Input::get('filter') . '%')
        ->orderBy($sortcol, $sortorder)->paginate(50);

    }

    public function allTestsDropdown($LabID)
    {
        return TestsInLabCategory::with('testCategory')->where('lab_id',$LabID)->get();
    }
    public function dropdownTests($testID)
    {
        return Tests::where('testcategory_id',$testID)->get();
    }

    public function addTests(Request $request) {
        try
        {
            
        //     echo '<pre>';
        // print_r($request->data['price']);
        // die();
        $newTest = new Tests;
        $newTest->description = $request->data['Description'];
        $newTest->test_name = $request->data['test_name'];
        $newTest->price = $request->data['price'];
        $newTest->testcategory_id = $request->data['selectedCat'];
        $newTest->lab_id = $request->data['selectedLab'];
        $newTest->is_prescription_req = $request->data['is_prescription_req'];
        $newTest->save();

            //  $Tests = Tests::Create(
            //     ['description' => $request->data['Description']],
            //     ['test_name' => $request->data['test_name']],
            //     ['price' => $request->data['price']],
            //     ['testcategory_id' => $request->data['selectedCat']],
            //     ['lab_id' => $request->data['selectedLab']],
            //     ['is_prescription_req' => $request->data['is_prescription_req']],
                
            // );
        //     echo '<pre>';
        // print_r($Tests);
        // die();
            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'Test Added successfully',
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

      public function destroyTests($id)
      {
          $Tests = Tests::findOrFail($id);
          $Tests->delete();
          return $Tests = Tests::all();
      }
      public function updateTestsGet($id)
    {
         return  Tests::findOrFail($id);
    }

    public function countTests()
    {
         return  Tests::count();
    }

    public function updateTests(Request $request)
    {
        $req = $request->data;
        $Tests = Tests::find($req['id']);
        try{
        $Tests->test_name = $request->data['test_name'];
        $Tests->testcategory_id = $request->data['testcategory_id'];
        $Tests->is_prescription_req = $request->data['is_prescription_req'];
        $Tests->price = $request->data['price'];       
        $Tests->description = $request->data['Description'];
        $Tests->lab_id = $request->data['selectedLab'];
            $Tests->save();
            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'Tests updated successfully',
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
