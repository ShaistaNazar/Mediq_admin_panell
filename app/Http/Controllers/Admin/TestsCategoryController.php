<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TestsCategory;

class TestsCategoryController extends Controller
{
    public function allCategoryTests()
    {
        return $categories = TestsCategory::get();
    }

    public function allCategory()
    {
        return $categories = TestsCategory::paginate(50);
    }
    public function addCategory(Request $req)
    {
        TestsCategory::create(['category_name'=> $req->all()['data']['category_name'],
        'in_demand'=> $req->all()['data']['in_demand']]);
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'ResponseMessage' => 'Added successfully',
            ]
                ], 200);
            
    }

    public function destroyTestsCat($id)
    {
        $TestsCategory = TestsCategory::findOrFail($id);
        $TestsCategory->delete();
        return $TestsCategory = TestsCategory::all();
    }
    public function updateTestCat(Request $request)
    {
        try{
        $data = $request->all()['data'];
            
        $medicine = TestsCategory::where('id', $data['id'])
        ->update(['category_name' => $data['cat_name'],
        'in_demand' => $data['in_demand']]);
        
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

}

