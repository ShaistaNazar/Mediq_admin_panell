<?php
namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Ranking;



class SettingController extends Controller
{
    public function socialGet()
    {
        $socials = Setting::Where('id', 'like', '%' . Input::get('filter') . '%')->get();     
        return $socials;
    }

    
    public function updateSocial(Request $request)
    {        
        $req = $request->value;
        Setting::truncate();
    
        try{
        foreach ($req as $value)
        {
            $socials = new Setting();
            $socials->option=  $value['option'];       
            $socials->value=  $value['value'];      
            $socials->save();
        }
           return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'Values updated successfully',
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
    public function updateRankingMinutes(Request $request){
        $id = 1;
        $req = $request->all();
        print_r($req);
            try{        
            $socials = Ranking::find($id);
            $socials->chats=  $req['chats'];
            $socials->likes=  $req['likes'];       
            $socials->save();
        
           return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'Values updated successfully',
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

    public function rankingGet()
    {  
        $id =1;
        return  Ranking::findOrFail($id);
    }

}