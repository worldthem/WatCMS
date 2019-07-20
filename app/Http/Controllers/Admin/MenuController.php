<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Settings;

use App\Modules\Admin\Categories;
use App\Modules\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $settings = Settings::where('param','_website_menu_')->orderBy("id",'desc')->get();
         return view("admin.pages.menu",['rows'=>$settings]); 
    }
 
 
  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $pages = Page::where('type','pages')->orderBy('id', 'desc')->get();
        
         \Wh::update_settings('_categories_structure_', "", @\Wh::get_cat_yerahical_array(@\Wh::getAllCategories_all()));
         
         $row= Settings::where('id',$id)->first() ;
         
         $module = \Wh::get_all_configs("menu");
         $theme = \Wh::get_config(_THEME_NAME_, "menu");
         
         $position = [];
        if(!empty($module)){ 
         foreach($module as $k=>$v){
              $position= array_merge($position,$v); 
            }
         } 
          
          $position= !empty($theme)? array_merge($position, $theme): $position; 
          
          $custom_links= UTILS_LINK_FOR_MENU;
          $all_categories= @_CATEGORIES_STRUCTURE_;
            // get all the config
          $custom_links = \Wh::mergeConstantAnConfig($custom_links, "customLinks");   
            
                   
          $all_list = $custom_links;
          foreach($pages as $p){
             $all_list['/page/'.$p->cpu]= $p->title;
          }
           foreach($all_categories as $vCat){
             $all_list['/cat'. @$vCat['cpufull']]= @$vCat['title'];
          }
           
         return view('admin.pages.menu-single', compact('row','pages','position','all_list','custom_links','all_categories'));
     
    }
 
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $id = $request->input('id');  
          $text= @$request->input('value1');
          $text = str_replace(['class="activeIn"','id="undefined"','class=""','<ul></ul>'],'',$text);
          $data = [
                'value'   =>@$request->input('value'),
                'value1'  => @$text,
                'value2'  => @$request->input('value2'),
                'param'   => '_website_menu_',
                  
            ];
            
            //print_r($data);
          Settings::updateOrCreate(
                          ['id' => $id ], $data
                         );
          
          return redirect()->back();
        
    }

   
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    { 
        Settings::where('id', $id)->delete();
        return redirect()->back() ;            
    } 

     
}
