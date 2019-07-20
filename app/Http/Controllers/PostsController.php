<?php

namespace App\Http\Controllers;
use App\Modules\Admin\Categories;
use App\Modules\Page;
use App\Modules\Settings;
use Illuminate\Http\Request;
 
class PostsController extends Controller
{
 
  public function index($params = null) {
    
    if(empty($params))
           return view('standart.404');
     
     $array_cpu= explode('/', @$params);       
     $cpu = @end($array_cpu);
     $type = @$array_cpu[0];
    
     $cat =count($array_cpu)>1? Categories::where('cpu',$cpu)
                                          ->select('id','title','metad','metak')
                                          ->first() : '';
       if(!empty($cat))
                     \Config::set('catID', $cat->id);
       
        $rows =!empty($cat)? Page::where('type',$type)->whereJsonContains('cat', [$cat->id])->OrWhereJsonContains('cat', ["$cat->id"])->paginate(20)
                              : Page::where('type',$type)->paginate(20);
       
        if(count($rows) < 1 || $type =='emails' || $type =='pages'){
               return view('standart.404');
              } 
         \Config::set('page', 'postCat');     
      return view('theme::posts',  compact('rows','cat','type'));
    }
    
    
    public function search(Request $request) {
            $search = @$request->get("s");
            $cat  = @$request->get("cat");
            $mode = @$request->get("mode");
            $type = 'posts';
           
       
       $rows = Page::where('type',$type)
                     ->where(function ($query ) use ($search) {
                                      $query->where('title', 'like', '%'.$search.'%')
                                                 ->orWhere('text', 'like', '%'.$search.'%') ;    
                                    });
          
          if(!empty($cat)){
            $rows = $rows->whereJsonContains('cat', [$cat])->OrWhereJsonContains('cat', ["$cat"]);
          }
            $rows = $rows->paginate(20);
            
             
            if($mode == 'ajax'){
                 $template= view()->exists('theme::searchPosts') ? 'theme::searchPosts' : 'standart.searchPosts';
               }else{
                 $template=  'theme::posts';
             }
               \Config::set('page', 'postSearch');  
      return view($template,  compact('rows','cat','type','search'));
    } 
    
    
/**
 * This will be for single post
 */    
   public function single($params = null) {
             if(empty($params))
               return view('standart.404') ;
           
             $array_cpu= explode('/', $params);
             $cpu= end($array_cpu);
             $type = @$array_cpu[0];
             
             $row = Page::where('cpu',$cpu)->where('type',$type)->first();
         
            if(empty($row)) 
               return view('standart.404');
                
                \Config::set('postID', $row->id);
                \Config::set('page', 'postSingle');
       return view('theme::posts', ['cat' => @$row, "content"=>@\Wh::shortCode($row->text), 'type' => $type]);
     }  
}