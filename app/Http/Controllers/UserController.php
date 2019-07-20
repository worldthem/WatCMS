<?php

namespace App\Http\Controllers;
 
use App\Modules\User; 
use App\Modules\PasswordReset; 
use App\Mail\WorldthemMail;
 
use App\Http\Requests; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notification;
use App\Modules\SuccessPayment;
use Illuminate\Support\Facades\Password; 
use App\Modules\Usermeta;

use Illuminate\Support\Facades\Mail;
 
class UserController extends Controller
{  
    
/**
* this is simple login and registration with redirect
* 
* use it like  redirect('/loginPage?url='. \URL::current())
*/    
public function simpleLoginPage(){
          if( \Auth::check()){
              $redirect = @e(\Input::get("url"));
              $redirect = !empty($redirect) ? str_replace(url('/'), '', $redirect): '/';
            }
         return \Auth::check() ? redirect($redirect)  : view('theme::myaccount');
 }   
 
 
/**
* This is for admin page
*/
public function showLoginPage()
    {
      $redirect ="/admin"; //\Wh::instring('/login', $intended ) ? "/admin" : $intended;
       //return $redirect; 
      return \Auth::check()? redirect($redirect)  : view('standart.auth.login');
    }
    
   /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
   public function authenticate(Request $request) {
       $ajax_method = @$request->input('method');
       $credentials = $request->only('email', 'password');
       
      if (Auth::attempt($credentials)) {
          if ($ajax_method=="ajax") {
                return 'reload';
             } else {
                return redirect()->intended($_SERVER['HTTP_REFERER']); 
            }
           
            } else {
                 echo "Wrong password or email.";
            }
       return "";
 } 
    
    /**
     * Handle an registration and authentication attempt.
     *
     * @return Response
     */
   public function registration(Request $request) {
         $userdata = [
            'password'  => @$request->input('password'),
            'email'     => @$request->input('email'),
            'name'      => @$request->input('name')
           ];
            
         $ajax_method = @$request->input('method');
           
        if(empty($userdata['password']) || empty($userdata['email'])){
           return _l('The password and Email address are requered!');  
        }
         
        $registr= new User();
        $reg = $registr->registrations($userdata);
        
        if($reg=="reload") 
          $registr->buildEmail('new-account' ,['email'=>$userdata['email'],'password'=>$userdata['password']]);
        
        if(!empty($reg)){ 
           return $reg ;  
        }
      
        return "reload";
    } 
    
       /**
     * Handle an reset pass.
     *
     * @return Response
     */
public function resetpass(Request $request ) {
         $userdata = [
             'email' => @$request->input('email'),
           ];
         
        if( empty($userdata['email'])){
           return _l('The Email address are requered')."!";  
        }
         
          
        if(User::where('email', $userdata['email'])->count()<=0){ 
              return _l("We can't find a user with that e-mail address, try to create an account")."!";
            }
            
             $token = str_random(60);
              
              $data = [ 'email' => $userdata['email'],
                        'token' => $token
                                    ];
                       
           $passwordReset = PasswordReset::updateOrCreate(['email' => $userdata['email']], $data);
           $link = url("/signup/new-password/".$token); 
                        
           (new User)->buildEmail('reset-password', ['email'=>$userdata['email'],'reseturl'=>$link]);
         
           return _l('We have e-mailed your password reset link<br />') ;
             
 }
    
    
 public function  new_password($token=""){
    if(empty($token)){
        return  redirect("/");
    } 
       $email = PasswordReset::where("token", $token)->first();
         
        if(!empty($email)){
            return view('standart.auth.resetPassword',compact("token"));
        }else{
             return  redirect("/");
        }
     
 }
 
 public function new_password_update(Request $request){
    $password = @$request->input('password');
    $password_repeat = @$request->input('password_repeat');
    $token = @$request->input('reset_token');
    
    if(empty($password)){
        return _l("Pleas enter a new password.");
    }
    
    if($password != $password_repeat ){
        return _l("Passwords don't match.");
    }
    
    
    if(empty($token)){
        return _l("Something got wrong");
    }
    
    $email = PasswordReset::where("token", $token)->first();
    if(!empty($email)){
       User::where('email', $email->email)
             ->update(['password' =>bcrypt($password)]);  
             
       PasswordReset::where('id', $email->id)->delete();      
      }
   
   return "reload";          
 }
 
 
    
 public function  logout(){
         Auth::logout();
         return redirect("/");
 }
     
    
public function myaccount(){
          $user = Auth::check()? User::find(\Wh::id_user()) : "";
         return view('theme::myaccount',["user" => $user]);
     }
   
      /**
     * Handle an reset pass.
     *
     * @return Response
     */
public function updatemyaccount(Request $request){
       
       if(!Auth::check()){
           return "Error, you should be login  to do this operation";
       }
       
       $userdata = [
            'password'  =>$request->input('password'),
            'name'      => $request->input('name') 
           ];
       
        $a = ['name'=>$userdata['name']];
       if(!empty($userdata['password'])){
        $a['password'] = bcrypt($userdata['password']);     
       }
       
         $Uid = \Wh::id_user();
         $user = User::where('id', $Uid)
                      ->update($a);
         
         //Usermeta::updateOrCreateMeta($Uid,@$request->meta); 
                        
        return redirect()->back();
       
    } 
    
}