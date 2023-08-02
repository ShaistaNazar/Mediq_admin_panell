<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TestsCategory;
use App\Models\TestsInLabCategory;

class TestsInLabCategoryController extends Controller
{

    public function labCatEdit($catID)
    {
        $objCats = TestsCategory::select('id','category_name')

        ->with('testCategory')->get();

        // $arrObj = array();
        // echo '<pre>';
        // print_r($objCats);die();
       
        foreach ($objCats as $OneCat) {


            if(!empty($OneCat->testCategory))
                $is_feature = 1;
            else
                $is_feature = 0;

            $arrObj[] = [
                'id' => $OneCat->id, 
                'test_name' => $OneCat->category_name, 
                'enable' => $is_feature,
                ];
        }

        return $arrObj;
    }

}
