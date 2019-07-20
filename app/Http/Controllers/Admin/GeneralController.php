<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Settings;
use App\Modules\Page;
use App\Modules\Admin\Upload;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
       return view("admin.pages.generalSettings"); 
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
        $upload  = new Upload();
          
        $post_all= $request->all();
        
        $get_settin= \Wh::get_settings_json("_main_options_");
         
        $post_all['_main_options_']['_logo_'] = !empty($post_all['_logo_']) ? @$upload->simpleUpload($request, "_logo_" ) :
                                                            @$get_settin['_logo_'];
        
        $post_all['_main_options_']['_favicon_'] = !empty($post_all['_favicon_']) ? @$upload->simpleUpload($request, "_favicon_" ) :
                                                            @$get_settin['_favicon_'];
        unset($post_all['_logo_']); 
        unset($post_all['_favicon_']);
        
       $settings=\Wh::get_settings_json("_main_options_");
         
       foreach($post_all as $k=>$v){
         $data = is_array($v)? json_encode($v): $v;
         \Wh::update_settings($k, "", $data);
       }
       
       
        $existing_url =  @rtrim($settings['_website_url_'], '/\\');  
        $new_url =  @rtrim($post_all['_main_options_']['_website_url_'], '/\\');  
        $cleanUrl = \Wh::clearUrl($existing_url);
         
           
        if($existing_url != $new_url && !empty($existing_url) && !empty($new_url)){
          
          $settings = Settings::select('id','value1')->where('param','_website_menu_')->get();
          
          if(count($settings)>0){
             
               foreach($settings as $v_settins){
                if(strpos($v_settins->value1,$existing_url) !== false){ 
                      Settings::where('id',$v_settins->id)->update(['value1'=>@str_replace($existing_url, $new_url, $v_settins->value1)]);
                    }
               }
           }
          
          $pages = Page::select('id','options','text')
                            ->where("text",'like','%'.$cleanUrl.'%')
                            ->orWhere("options",'like','%'.$cleanUrl.'%')
                           ->get();
                           
          if(count($pages)>0){ 
            
             $optionURL = @str_replace('/','\/', $existing_url);
             $jsonURL= @str_replace('/','\/', $new_url);
               foreach($pages as $v_page){
                   Page::where('id',$v_page->id)
                           ->update(['text'=>@str_replace($existing_url, $new_url, $v_page->text),
                                     'options'=>@str_replace([$optionURL, $existing_url], [$jsonURL, $jsonURL], $v_page->options)]);
                }
           }  
           
        }
        
        if(empty($post_all['_main_options_']['_developmentMode_']) && !empty($get_settin['_developmentMode_']) ){
            $css = _CSSSTYELE_;
             
             foreach($css as $kcss => $vcss){ 
                  $contentCss = @file_get_contents(base_path($vcss));
                  $minified = @\Wh::minify_css($contentCss);
                  $imgPath = @\Wh::removeSlashes($vcss);
                  $minified = str_replace(["../","%-"],[$imgPath, "% - "], $minified);
                  
                  $file=  str_replace(".css",".blade.php",$vcss);
                  \File::put(base_path($file), $minified);
              }
         }
         
       if(!empty($post_all['_main_options_']['_cachehomepage_'])){
        $contentHome =  file_get_contents(url("/")."?keyHome=SdeVssSDSFwe");
        $contentHome = str_replace( "%-" , "% - " , $contentHome);
         \File::put(base_path('/resources/views/standart/cache/home.blade.php'), \Wh::minify_html($contentHome));
       }  
         
        return redirect()->back();
    }

    
}
