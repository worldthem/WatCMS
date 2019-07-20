<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Module;
use App\Modules\Admin\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
 
class AdminController extends Controller {
   /**
     * Upload image for tinimces.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request) {
     
          $imageFolder = public_path('/uploads/');
          $imageFolder_return =  \URL::to('/').'/public/uploads/' ;
          reset ($_FILES);
          $temp = current($_FILES);
          if (is_uploaded_file($temp['tmp_name'])){
            if (isset($_SERVER['HTTP_ORIGIN'])) {
              // same-origin requests won't set an origin. If the origin is set, it must be valid.
              header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            }
        
            /*
              If your script needs to receive cookies, set images_upload_credentials : true in
              the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');
        
            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }
        
            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }
        
            // Accept upload if there was no origin, or if it is an accepted origin
            $filetowrite = $imageFolder . $temp['name'];
            $filetowrite2 = $imageFolder_return . $temp['name'];
            move_uploaded_file($temp['tmp_name'], $filetowrite);
        
            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            echo json_encode(array('location' => $filetowrite2));
          } else {
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
          } 
       
    }
 
 public function upload_images(Request $request, $type="")  {
          $upload = new Upload();
          $val = $upload->upload($request,"/img");
        
          if($type=="simple"){
             return  "<img src='".url("/public/img/".$val[0])."'class='bg_image' >"; 
           }
                  
   }
    
  public function shareTranslate($lang=''){
   if(!empty($lang)){
      \Wh::get_by_curl("https://watcms.com/json/share/lang?url=".url("/language/".$lang.".json"), "yes");
   }
   
    return "Thank you!";
    
 }
    
    
    
    
}
