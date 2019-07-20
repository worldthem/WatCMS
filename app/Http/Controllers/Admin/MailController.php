<?php

namespace App\Http\Controllers\Admin;
use App\Mail\WorldthemMail;
use Illuminate\Support\Facades\Mail;
use App\Modules\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
 
  public function index(){
     if (file_exists(base_path("config/systemConfigMail.php"))) {
         $array = require base_path("config/systemConfigMail.php");
        }else{
             $array=[
                "mailDRIVER"=>"sendmail",
                "mailHOST"=>"smtp.mailgun.org",
                "mailPORT"=>587,
                "mailFROM_ADDRESS"=>"hello@example.com",
                "mailFROM_NAME"=>"Support",
                "mailENCRYPTION"=>"tls",
                "mailUSERNAME"=>"",
                "mailPASSWORD"=>"",
           ];
        }
        
        $drivers = [ "sendmail", "smtp", "mailgun", "mandrill", "ses", "sparkpost", "log", "array"];
        
      return view("admin.pages.email",compact("array","drivers"));  
  }
  
  private function writeMail($data=''){
    try { 
            \File::put(base_path() . '/config/systemConfigMail.php', $data);
            return redirect()->back();
          } catch (\PDOException $e) {
                $error = '<p style="color: red; background: #fff; padding: 5px; font-weight:bold;"> 
                             ERROR:'.$e->getMessage().'<br /><br /> '._l('Your Root directory is writable. Use alternative method to setup your email!!').'!!</p>';
                return redirect()->back()->withErrors([ $error]);
        }
  } 
  
  
  public function store(Request $request){
$content = "<?php
return [
    'mailDRIVER'=>'".@$request->input('mailDRIVER')."',
    'mailHOST'=>'".@$request->input('mailHOST')."',
    'mailPORT'=>'".@$request->input('mailPORT')."',
    'mailFROM_ADDRESS'=>'".@$request->input('mailFROM_ADDRESS')."',
    'mailFROM_NAME'=>'".@$request->input('mailFROM_NAME')."',
    'mailENCRYPTION'=>'".@$request->input('mailENCRYPTION')."' ,
    'mailUSERNAME'=>'".@$request->input('mailUSERNAME')."' ,
    'mailPASSWORD'=>'".@$request->input('mailPASSWORD')."' ,
];
";
   
   $this->writeMail($content);
    
   return $this->writeMail($content); 
}
  
  public function sendTest(Request $request){
      try { 
            
             Mail::to($request->input('to'))->send(new WorldthemMail('Test mail from '.url("/"), $request->input('body'), \Wh::constant_key(_MAIN_OPTIONS_, "admin_mail"), 'Support '.\Wh::url_s() ));
              return redirect()->back();
           } catch (\PDOException $e) {
                $error = '<p style="color: red; background: #fff; padding: 5px; font-weight:bold;"> 
                             ERROR:'.$e->getMessage().'<br /><br /> !!</p>';
                return $error;
        }  
   } 
  
}