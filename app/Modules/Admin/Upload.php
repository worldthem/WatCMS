<?php

namespace App\Modules\Admin;

use Illuminate\Database\Eloquent\Model;
use File;

class Upload extends Model {
    
 public function upload($request="",$path='/imgproduct',$type=''){
     $lenght = $request->input('length');
     $name_return= [];
     $destinationPath = public_path($path);
     $this->check_directory($destinationPath);
     
     $_MAIN_OPTIONS_ = @_MAIN_OPTIONS_;
      
     $width = !empty($_MAIN_OPTIONS_["_media_width"]) ? @$_MAIN_OPTIONS_["_media_width"] : 255;
     $height = !empty($_MAIN_OPTIONS_["_media_height"]) ? @$_MAIN_OPTIONS_["_media_height"] : 383;
     $crop =   !empty($_MAIN_OPTIONS_["_media_crop"]) ? true : false;
    
     for($i=0; $i<=intval($lenght); $i++){
         $name = "file".$i;
        if ($request->hasFile($name)){
            $image = $request->file($name);
            $name_end = \Wh::get_random(25).'.'.$image->getClientOriginalExtension();
            $name_return[] = empty($type)? $name_end : [$name_end,  $image->getClientOriginalName() ];
            $image->move($destinationPath, $name_end);
            
            if(empty($type)){
                \Wh::resize_crop_image(@$width, @$height,  $destinationPath."/".$name_end , $destinationPath."/thumb_".$name_end, 90, @$crop);
            }
             
        }
     }
     return $name_return;
 }
 
  public function simpleUpload($request, $name="",$path='/img' ){
        $destinationPath = public_path($path);
         $this->check_directory($destinationPath);
     
          $name_end = '';
        if ($request->hasFile($name)){
            $image = $request->file($name);
            $name_end = \Wh::get_random(25).'.'.$image->getClientOriginalExtension();
            $image->move($destinationPath, $name_end);
         }
     return $name_end;
 }
 
 
 
  public function upload_csv($request="",$name=""){
      
     $name_end= "";
     $destinationPath = public_path('/csv');
      $this->check_directory($destinationPath);
        if ($request->hasFile($name)){
            $image = $request->file($name);
            $name_end = \Wh::get_random(20).'.'.$image->getClientOriginalExtension();
            $image->move($destinationPath, $name_end);
        }
      
     return $name_end;
 }
 
 private function check_directory($path='', $nr=0755){
    
    if(!File::exists($path)) {
       File::makeDirectory($path, $nr, true, true);
    }
 }
 
 
 
}
