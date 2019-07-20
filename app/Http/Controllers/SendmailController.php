<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Mail\WorldthemMail;
use Illuminate\Support\Facades\Mail;
class SendmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactform(Request $request) {
        
       $form_id= $request->input('form_id'); 
       $name= $request->input('name');
       $email= $request->input('email');
       $subject= $request->input('subject');
       $orderid= $request->input('orderid');
       $message= $request->input('message');
       
       $requared=['name','email','message'];
       $js2 =return_js($requared, $request->all(), $form_id);
       
       if(!empty($js2)){
            echo '<script> $(document).ready(function(){ '.$js2.'}); </script>';
            exit("<p> The fields with * are requared</p>");
        }
        
      
            
       $text = "<p> You got a email from ".$name."</p>"
               . "<p> Name: $name  <br/> "
               . "Email: $email <br/>"
               . "Subject: $subject <br/>"
               . "Order ID: $orderid <br/>"
               . "Message: $message </p>";
      
       
        Mail::to(\Wh::get_settings('admin_mail'))->send(new WorldthemMail($subject, $text, \Wh::get_settings('admin_mail'),  $name ));
     echo "<h4>Thank you, we will get in touch with you shortly</h4>";
     echo '<script> $(document).ready(function(){ $("'.$form_id.'")[0].reset(); }); </script>';    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     
}
