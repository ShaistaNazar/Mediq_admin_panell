<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Models\Equipments;
use App\Models\CityRentalEquipments;
use App\Http\Services\NotificationService;
use App\Models\RentalEquipments;


class EquipmentsController extends Controller
{
    public function allEquipments(Request $request)
    {
        $is_rental = $request->all()['is_rental'];
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');
        $equipment = Equipments::query();
        $equipment->where('is_rental', $is_rental);
        if (Input::has('filter') && $filter !='') {
            $equipment->where('equipment_name', 'LIKE', "$filter%");
        }
        return $equipment->orderBy($sortcol, $sortorder)->paginate(50);
    }
   
    public function allRentalEquipments(Request $request)
    {
        return RentalEquipments::with('equipment','user')->orderBy($request['sortcol'], $request['sort'])->paginate(50);
    }
    public function rentalEquipmentPriceAdd(Request $request)
    {
        $input = $request->all()['data'];
        $priceUpdate = RentalEquipments::where('id',$input['id'])->update(['price' => $input['TotalAmount']]);
        $rentalEquip = RentalEquipments::where('id',$input['id'])->with('equipment')->first();
        $rentalEquipmentPriceotification = array("user_id"=>$rentalEquip['user_id'], 
       "order_amount"=> $rentalEquip['price'] , "order_number"=>$rentalEquip['order_number'], 
       "equipment_ordered"=>$rentalEquip['equipment']['equipment_name'],"equipment_id"=>$rentalEquip['equipment_id']);


       $checkNotyResponce = NotificationService::notifyRentalEquipment($rentalEquipmentPriceotification);
        return response()->json([
            'ResponseHeader' => [
                'ResponseCode' => 1,
                'id' => $priceUpdate,
                'ResponseMessage' => 'Price updated successfully',
            ]
        ], 200);
    }
    public function filteredEquipments()
    {
        $filter = Input::get('filter');
        $sortcol = Input::get('sortcol');
        $sortorder = Input::get('sort');
        $type = Input::get('type');
        // print_r(Input::get('type'));
        // die();
        return Equipments::Where('equipment_name', 'like',  $type . '%')->paginate(20);
    }

    public function allEquipmentsDropdown()
    {
        return Equipments::paginate(50);
    }

    public function countEquipments()
    {
        return Equipments::count();
    }

    public function iconSet(Request $request, $id)
    {

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        $filename  = uniqid('img_') . '.' . $ext;

        if (Storage::putFileAs('/public/equipmentImg/', $file, $filename)) {
            $Equipments = Equipments::find($id);
            $Equipments->image = 'equipmentImg/'.$filename;
            $Equipments->save();
            return $filename;
        }
    }

    public function addEquipments(Request $request)
    {
        // return $request->all();g
        try {
            $Equipments = new Equipments;
            $Equipments->equipment_name = $request->data['equipment_name'];
            $Equipments->price = $request->data['price'];
            $Equipments->brand = $request->data['brand'];
            $Equipments->is_rental = $request->data['is_rental'];
            $Equipments->description = $request->data['Description'];
            $Equipments->save();
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

    public function destroyEquipments($id)
    {
        $Equipments = Equipments::findOrFail($id);
        $Equipments->delete();
        return $Equipments = Equipments::all();
    }

    public function updateEquipmentsGet($id)
    {
        $equipment = Equipments::with('city_equipment')->findOrFail($id);
        $equipment->cities = [];
        if(count($equipment->city_equipment) > 0){
            foreach($equipment->city_equipment as $key => $city){
                $cities2[$key] = $city->city_id;                
            }
            $equipment->cities = $cities2;
        }
        return $equipment;
    
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
