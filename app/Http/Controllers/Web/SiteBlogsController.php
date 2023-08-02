<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\SiteBlogs;
use Illuminate\Support\Facades\Storage;

class SiteBlogsController extends Controller
{

  // upload blog image

  public function addBlogImage(Request $request, $id)
  {
    $file = $request->file('file');
    $ext = $file->getClientOriginalExtension();

    $filename  = uniqid('img_') . '.' . $ext;

    if (Storage::putFileAs('/public/images/', $file, $filename)) {
        $Subscriptions = SiteBlogs::find($id);
        $Subscriptions->image = 'images/'.$filename;
        $Subscriptions->save();
        return $filename;
    }
  }
  // upload blog data like as title and description etc

    public function addNewBlog(Request $request)
    {
    
      try{
        $data = $request->all();
        $blog = SiteBlogs::create([
        'title' => $data['title'],
        'author' => $data['author'],
        'is_show' => $data['is_show'],
        'description' => $data['description']
      ]);
      return response()->json([
        'ResponseHeader' => [
          'ResponseCode' => 1,
          'id' => $blog->id,
          'ResponseMessage' => 'Blog Add Successfully!'
        ]
        ], 200);
      }
      catch(\Exception $exception){
        return response()->json([
          'ResponseHeader' => [
              'ResponseCode' => 0,
              'ResponseMessage' => $exception->getMessage(),
          ]
              ], 200);
      }
    }

    // get all blogs data
    public function getBlogs()
    {
        return SiteBlogs::all();
        // $objBLOG = SiteBlogs::Where('title', 'like', '%' . Input::get('filter') . '%') 
        
        // ->orwhere('author', 'like', '%' . Input::get('filter') . '%')
        // ->orwhere('is_show', 'like', '%' . Input::get('filter') . '%')
        // ->paginate(50);
      
        // return $objBLOG;
    }

    public function allBlogs()
    {
        return SiteBlogs::where('is_show', 1)->get();
        // $objBLOG = SiteBlogs::Where('title', 'like', '%' . Input::get('filter') . '%') 
        
        // ->orwhere('author', 'like', '%' . Input::get('filter') . '%')
        // ->orwhere('is_show', 'like', '%' . Input::get('filter') . '%')
        // ->paginate(50);
      
        // return $objBLOG;
    }

    public function showBlog($id)
    {
      $blog = SiteBlogs::find($id);
      return response()->json($blog, 200);
    }

    public function editBlog($id)
    {
      $blog = SiteBlogs::find($id);
      if($blog == ''){
        return response()->json([
            'error' => 'Blog not found!'
        ], 404);
    }else{
        return response()->json($blog, 200);
    }
    }

    public function filterBlog(Request $request)
    {
      // $filter = Input::get('filter');
      // $sortcol = Input::get('sortcol');
      // $sortorder = Input::get('sort');

      return SiteBlogs::where('title', 'like', '%' . Input::get('filter') . '%')
      ->orwhere('author', 'like', '%' . Input::get('filter') . '%')
      ->orderBy(Input::get('sortcol'), Input::get('sort'))
      ->paginate(20);
    }
    // update blog by id

    public function updateBlog(Request $request, $id)
    {
      try{
        $data = $request->all();
        $blog = SiteBlogs::find($id);
        if($blog){
          $filename = $blog->image;
          if($request->file('file')){
            $file = $request->file('file');
            $ext = $file->getClientOriginalExtension();
            $filename  = uniqid('img_') . '.' . $ext;
            Storage::putFileAs('/public/images/', $file, $filename);
          }
          $blog->title = $data['title'];
          $blog->author = $data['author'];
          $blog->is_show = $data['is_show'];
          $blog->description = $data['description'];
          $blog->image =$filename;          
          $blog->save();
  
        return response()->json([
          'ResponseHeader' => [
            'ResponseCode' => 1,
            'id' => $blog->id,
            'ResponseMessage' => 'Blog update Successfully!'
          ]
          ], 200);
        }
        }        
      catch(\Exception $exception){
        return response()->json([
          'ResponseHeader' => [
              'ResponseCode' => 0,
              'ResponseMessage' => $exception->getMessage(),
          ]
              ], 200);
      }
    }

    // delete blogs by id

    public function deleteBlog(Request $request , $id)
    {
      $blog = SiteBlogs::findOrFail($id);
      $blog->delete();

      return response()->json([
        'ResponseHeader' => [
          'ResponseCode' => 1,
          'id' => $blog->id,
          'ResponseMessage' => 'Blog delete Successfully!'
        ]
        ], 200);
    }
}
