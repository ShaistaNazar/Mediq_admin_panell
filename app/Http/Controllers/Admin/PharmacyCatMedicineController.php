<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PharmacyCatMedicine;
use App\Models\MedicinesCategory;

class PharmacyCatMedicineController extends Controller
{
    public function editPharmaCat($pharmaID) {

        $objFeatures = MedicinesCategory::select('id','category_name')

                ->with(['categories' => function ($query)  use ($pharmaID) {
                    $query->where('pharmacy_id', '=', $pharmaID);
                }])->get();
        $arrObj = array();
        // print_r($objFeatures->toarray());die();
        foreach ($objFeatures as $category) {     
            if(!empty($category->categories))
                $isCat = true;
            else
                $isCat = false;

            $arrObj[] = [
                'id' => $category->id, 
                'category_name' => $category->category_name, 
                'status' => $isCat
            ];
        }

        return $arrObj;
    }
}
