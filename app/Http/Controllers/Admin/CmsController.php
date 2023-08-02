<?php
namespace App\Http\Controllers\Admin;

use App\Models\CMSPages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class CmsController extends Controller {

    public function allCmsPages() {
        
        
        $objCMS = CMSPages::Where('title_english', 'like', '%' . Input::get('filter') . '%') 
        
        ->orwhere('title_english', 'like', '%' . Input::get('filter') . '%')
        ->orwhere('page_html_content', 'like', '%' . Input::get('filter') . '%')
        ->orwhere('slug', 'like', '%' . Input::get('filter') . '%')
        ->orwhere('keywords', 'like', '%' . Input::get('filter') . '%')

        ->paginate(50);
      
        return $objCMS;
    }


    public function getPageSlug($pageSlug) {
        return CMSPages::Where('slug', '=', $pageSlug)->get();
    }

    public function addNewCmsPage(Request $request) {

        $req = $request->data;
        $keyword_array = array();
        $cms_pages = new CMSPages;

        try {
            
            foreach($req['keywords'] as $value){
                $keyword_array[]  = $value['text'];
            }

            $keywordvalues = implode(",", $keyword_array);
            
            $cms_pages->title_english = $req['title_english'];
            $cms_pages->keywords = $keywordvalues;
            $cms_pages->description = $req['description'];
            $cms_pages->slug = $req['slug'];
            $cms_pages->status = $req['selected'];
            $cms_pages->page_html_content = $req['page_html_content'];
            $cms_pages->save();
            
            $ResponseCode = 1;
            $ResponseMessage = __('CMS updated successfully');
            $param = 'matches';
            $values = new \stdClass();

            return response()->json(['ResponseHeader' => ['ResponseCode' => 1, 'ResponseMessage' => 'CMS updated successfully']], 200);


        } catch(\Exception $e) {
            
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),]
                ], 200);

        }

    }

    public function editCmsPageByPageID($id) {

        try{

            $objPage = CMSPages::findOrFail($id);
            
            return  $objPage;

        } catch(\Exception $e) {

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
                    ], 200);
         }

    }

    public function updateCmsPage(Request $request) {
        
        $req = $request->data;
        $keyword_array = array();
        $cms_pages = CMSPages::find($req['Id']);
        
        try {
            
            foreach($req['keywords'] as $value){
                $keyword_array[]  = $value['text'];
            }
            
            $keywordvalues = implode(",", $keyword_array);
            $cms_pages->title_english = $req['title_english'];
            $cms_pages->keywords = $keywordvalues;
            $cms_pages->description = $req['description'];
            $cms_pages->slug = $req['slug'];
            $cms_pages->status = $req['selected'];
            $cms_pages->page_html_content = $req['page_html_content'];
            
            $cms_pages->save();

            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'CMS page updated successfully',
                       ]
                    ], 200);

        } catch(\Exception $e) {

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
         
        }
    }

    public function deleteCmsPageByID($id) {

        $cms = CMSPages::findOrFail($id);
        $cms->delete();
    
        return $cms = CMSPages::all();
    
    }

}
