<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Colectmail;
use App\Modules\Page;
use App\Modules\Settings;
use App\Mail\WorldthemMail;
use Illuminate\Support\Facades\Mail; 

class AjaxController extends Controller
{
   /**
    * Subscribe method
    */
   public function subscribe($request=''){
    
        $mail = $request->input('email');
       if(empty($mail)){
           return "Please enter your email";
       }
       
        $lastid= Colectmail::insertGetId(['email'=> $mail,
                               'date'=>date("Y-m-d h:i:s")]);
        return "ok";
    }
   
    /**
     * Contact from method
     */
    
     public function contactForm($request=''){
       $id = @$request->input('id');  
       $field = Settings::where("value2",$id)->first();
       $row = json_decode($field->value1, true); 
       $title= $field->value;
       
      if(empty($row['to']))
                   return "Please fill in admin the field 'To' ".url('/admin/contact-form/single/'.$field->id);  
       
       $message='';
       if(!empty($row['fields'])){ 
            for($i=0; $i<count($row['fields']['label']); $i++){
                $post = @$request->input(@$row['fields']['name'][$i]);  
                $name =!empty($row['fields']['label'][$i]) ? $row['fields']['label'][$i] : @$row['fields']['placeholder'][$i];
                $message .= $name .": ". $post ."\n";
              }
          }
          
         Mail::to(@$row['to'])->send(new WorldthemMail( $title, $message));  
  
        return @$row['message'];
     }
}
