<?php

namespace App\Http\Controllers;

use App\Modules\Page;
use App\Modules\Settings;
 
class PageController extends Controller
{
     
    
     public function index($cpu) {
        $page = Page::where('cpu',$cpu)->first();
          
        if(empty($page)){
               return view('standart.404');
              } 
            
        \Config::set('page_id', $page->id);
        \Config::set('page', 'page');  
        \Config::set('pageTitle', $page->title);
        
       return view('theme::pages', ['rows' => @$page, "content"=>@\Wh::shortCode($page->text) ]);
    }
    
     public function extrct_justcontent($cpu) {
            $page = Page::where('cpu',$cpu)->first();
             return $page->text;
     }
     
 
}
