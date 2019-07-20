<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Settings;
use File;
use ZipArchive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $active = \Wh::get_settings_json('_active_modules_');
          $directories = array_map('basename', File::directories(base_path("platform/Modules")));
          
          //$path = base_path('platform/Modules/'.$module.'/config.php');
          //$is =  File::exists($path)? require $path : [];
          
          return view("admin.pages.modules",['rows'=> $directories,'active'=>$active]); 
    }
 
 
     private function check_directory($path='', $nr=0755){
        
        if(!File::exists($path)) {
             File::makeDirectory($path, $nr, true, true);
          }
     }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           
           $name = "module";
           $theme_zip='';
           $name_theme='';
            
           
           
        if ($request->hasFile($name)){
             $resource =  base_path('platform/Modules/');//base_path().'/resources/views/themes/' ;
             
             $this->check_directory($resource);
             
             $theme = $request->file($name);
             $name_end =  $theme->getClientOriginalName();
             $theme->move($resource, $name_end);
         
             $theme_zip=$resource.$name_end ;
             $zip = new ZipArchive;
             $res = $zip->open($theme_zip);
            
            if ($res === TRUE) {
                $zip->extractTo($resource);
                 $name_theme = str_replace(['.zip','.ZIP'],['',''], $name_end);
              } else {
              echo 'not';
              $response="extract_problem";
            }
           $zip->close();  
          }
          
          if(!empty($theme_zip)){
              unlink($theme_zip);
          }
          if ($request->hasFile($name)){
            $this->check_directory($resource, 0644);
          }
          
        return redirect()->back() ;
    }
    
   private function unset_module($module=""){
        $settings = \Wh::get_settings_json('_active_modules_') ;
        $settings = !empty($settings)? $settings: [];
             
        if(in_array($module, $settings)){
             $key = array_search($module, $settings);
              unset($settings[$key]);
              \Wh::update_settings('_active_modules_', '',json_encode($settings));
              return "not";
         }
    
    return $settings;
   } 
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activate($module="")
    {
             $settings= $this->unset_module($module);
             if($settings != "not"){
                $settings[] = $module; 
                \Wh::update_settings('_active_modules_', '',json_encode($settings));
                
                $path = base_path('platform/Modules/'.$module.'/config.php');
                
                $is =  File::exists($path)? require $path : [];   
                
                if(!empty($is['run']) && strpos($is['run'], '@') !== false){
                    \Wh::check_clas_is("Platform\Modules\\".$module."\\".$is['run']);
                 }
             }
             
           return redirect()->back();
    }
    
      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function destroy ($module="")
        {    
               $this->unset_module($module);
              
              $directory =  base_path("platform/Modules/".$module."/"  );
               $this->deleteDir($directory);
               return redirect()->back() ;            
        }
        
      private static function deleteDir($dirPath) {
            if (! is_dir($dirPath)) {
                throw new InvalidArgumentException("$dirPath must be a directory");
            }
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
        }  
    
}
