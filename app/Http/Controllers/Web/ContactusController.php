<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\ContactUs;

class ContactusController extends Controller
{
      public function ContactForm(Request $request)
      {
        try 
        {
          $data = $request->all();
          $form = ContactUs::create([
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message']
          ]);
          return response()->json([
            'ResponseHeader' => [
              'ResponseCode' => 1,
              'form' => $form,
              'ResponseMessage' => 'Thanks for ContactUs'
            ]
            ], 200);
        }
        catch(\Exception $exception)
        {
          return response()->json([
            'ResponseHeader' => [
              'ResponseCode' => 0,
              'ResponseMessage' => $exception->getMessage()
            ]
            ], 401);
        }
      }

      public function allContactInfo()
      {
        return ContactUs::all();
      }

      // public function allContactInfo()
      // {
      //   // $sortcol = Input::get('sortcol');
      //   // return ContactUs::get()->orderBy(Input::get('sortcol'), Input::get('sort'))->paginate(10);
      //     $filter = Input::get('filter');
      //     $sortcol = Input::get('sortcol');
      //     $sortorder = Input::get('sort');
  
      //     return ContactUs::where('id', 'like', '%' . Input::get('filter') . '%')
      //         ->orwhere('email', 'like', '%' . Input::get('filter') . '%')
      //         ->orwhere('subject', 'like', '%' . Input::get('filter') . '%')
      //         ->orderBy(Input::get('sortcol'), Input::get('sort'))->paginate(10);
      // },

      public function changeStatus(Request $request, $id)
      {
        try {
          $data = $request->all();
          $form = ContactUs::find($id);
          $form->status = $data['status'];
          $form->save();
          return response()->json([
            'ResponseHeader' => [
              'ResponseCode' => 1,
              'id' => $form,
              'ResponseMessage' => 'Request Processed Successfully!'
            ]
            ], 200);
        
      } catch(\Exception $exception){
        return response()->json([
          'ResponseHeader' => [
              'ResponseCode' => 0,
              'ResponseMessage' => $exception->getMessage(),
          ]
              ], 401);
      }
      }
}
