<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\MessageService;
use App\Models\UserTestReports;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Tests;
use App\Http\Services\NotificationService;


class UserTestReportsController extends Controller
{
	protected $msgService;
	function __construct(MessageService $msgService )
	{
		$this->msgService = $msgService;
	}
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    public function getUserTestReports()
    {
        return UserTestReports::with('users','tests.labs')->orderBy('id', 'desc')->paginate(50);
    }
    public function UserTestReportsforproperty()
    {  
        return  UserTestReports::select('id','file')->get();
    }
    public function UserTestReportsforarea()
    {  
        return  UserTestReports::select('id','file')->get();
    }
    public function UserTestReportsfortown()
    {  
        return  UserTestReports::select('id','file')->get();
    }
    public function editcity($id)
    {
         return  UserTestReports::findOrFail($id);
    }

    public function updateCity(Request $request)
    {
        $req = $request->data;
        $UserTestReports = UserTestReports::find($req['Id']);
        try{
            $UserTestReports->file = $req['file'];
            $UserTestReports->save();
            $user = User::find($UserTestReports->user_id);
            if($UserTestReports->save()){
                $maskName = "Home Medics";
                $textMessage = "Dear User your test report is ready for download, Please navigate to 'My Lab Reports' on Application ";
                $sendMsg = $this->msgService->sendSmsMessage($textMessage , $user->phone, $maskName);
            }
            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'Uploaded successfully',
                           'id' => $UserTestReports->id,
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

        $Subscriptions = UserTestReports::find($id);
        $name = User::find($Subscriptions->user_id);
        $filename  = uniqid($name->email) . '.' . $ext;

        $testDetail = Tests::Where('id',$Subscriptions->test_id)->first();

        if (Storage::putFileAs('/public/usersPDF/', $file, $filename)) {           
            $Subscriptions->file = 'usersPDF/' . $filename;
            $save = $Subscriptions->save();
            if($save){
            
                $textMessage = "Dear user, your Test Report is ready for download";
                
            $sendMsg = $this->msgService->sendSmsMessage($textMessage , $name->phone);

            
            $checkNotyResponce = NotificationService::notify($name,$testDetail, $type = 2);
            }

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 1,
                    'ResponseMessage' => 'Uploaded successfully',
                ]
                    ], 200);
        }
    }

    public function addCity(Request $request) {
        $UserTestReports = new UserTestReports;
        $UserTestReports->file = 'testReports/' . $request->file;
        $UserTestReports->save();
        return $UserTestReports;
      }


        public function destroyReport($id)
    {
        $UserTestReports = UserTestReports::findOrFail($id);
        $UserTestReports->delete();
    }
    //for selection fields
    public function city()
    {
        return  UserTestReports::orderBy('file', 'ASC')->get(['id', 'file']);
    }
    public function UserTestReportsarea(UserTestReports $UserTestReports)
    {
        return $UserTestReports->UserTestReportsarea()->orderBy('file', 'ASC')->get(['id', 'file']);
    }
    public function UserTestReportstown(UserTestReports $UserTestReports)
    {
        return $UserTestReports->UserTestReportstown()->orderBy('file', 'ASC')->get(['id', 'file']);
    }
}
