<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Models\Complaint;
use App\Models\User;

class UserComplaintController extends Controller
{
    public function allComplaints(Request $request)
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');
        $equipment = Complaint::query();
        if (Input::has('filter') && $filter !='') {
            $equipment->where('complaint_title', 'LIKE', "$filter%");
            $equipment->orWhere('user_phone', 'LIKE', "$filter%");
        }
        return $equipment->with('complainer')->orderBydesc($sortcol, $sortorder)->paginate(50);
    }


    public function addComplaint(Request $request)
    {
        try {
        $data = $request->all()['data'];
        $user_id = 0;
        $user = User::where('phone',$data['phone'])->first();
        if($user){
            $user_id = $user->id;
        }
        $complaint = Complaint::create(['user_id' => $user_id,
                          'user_phone'  =>$data['phone'],
                          'complaint_title'  =>$data['complaint_title'],
                          'complaint_description'  =>$data['complaint_description'],

        ]);
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $complaint,
                'ResponseMessage' => 'Complaint Added successfully',
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
    public function editComplaint($id){
        return Complaint::findOrFail($id);
    }
    public function updateComplaint(Request $req)
    {
        $data = $req['data'];
        $user_id = 0;
        $user = User::where('phone',$data['phone'])->first();
        if($user){
            $user_id = $user->id;
        }
         $complaint = Complaint::where('id',$data['complaintId'])
        ->update(['user_phone'  =>   $data['phone'],
        'complaint_title' =>     $data['complaint_title'],
        'complaint_description' =>   $data['complaint_description'],
        'user_id' =>    $user_id
        ]);
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $complaint,
                'ResponseMessage' => 'Complaint Updated successfully',
            ]
        ], 200);
    
    }

    public function destroyEquipments($id)
    {
        $Equipments = Equipments::findOrFail($id);
        $Equipments->delete();
        return $Equipments = Equipments::all();
    }


    public function updateEquipments(Request $request)
    {
        $req = $request->data;
        $Equipments = Equipments::find($req['id']);
        try {
            $Equipments->equipment_name = $request->data['equipment_name'];
            $Equipments->price = $request->data['price'];
            $Equipments->brand = $request->data['brand'];
            $Equipments->is_rental = $request->data['is_rental'];
            // $Equipments->quantity = $request->data['quantity'];
            $Equipments->description = $request->data['Description'];
            $Equipments->save();
            $delete = CityRentalEquipments::where('rental_equipment_id', $req['id'])->delete();
            if(!empty($request->data['cities']) && $request->data['is_rental'] == true){
                foreach($request->data['cities'] as $city){
                    CityRentalEquipments::create(['city_id' => $city ,
                    'rental_equipment_id' => $Equipments->id]);
                }
            }

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'id' => $Equipments->id,
                    'ResponseMessage' => 'Equipments updated successfully',
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
