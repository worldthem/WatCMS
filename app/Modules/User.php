<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Modules\Page;
use App\Mail\WorldthemMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Routing\Redirector;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable {

    use AuthenticableTrait;
    private $have_role;
    protected $table = 'users';
    protected $guarded = ['id'];
    
 function replace_sesion_with_id($id="") {
     if(!empty($id)){
         $getses=  Session::get('tmp_user_id');
         Session::forget('tmp_user_id');
         Session::put('tmp_user_id',  $id);
          \DB::table('cart')->where('user_id', $getses)
            ->update(['user_id' =>$id]);
     }
 }
    
 
function registrations($a){
      $message= "";
       if(empty($a['email'])) return '';
      
       if(\DB::table('users')->where('email', $a['email'])->count()>0){ 
           $message= isset($a['checkout'])? 'is' :  _l("This email is all ready registred, try to login"); 
        }else{
            $password= !empty($a['password'])?  $a['password'] : \Wh::get_random(10);
         $userdata = [
            'password'  =>bcrypt(@$password) ,
            'email'     => @$a['email'],
            'name'      => @$a['name'],
            'created_at'=> date("Y-m-d h:i:s"),
            'user_role'=> 0,
           ];
           
          $id = \DB::table('users')->insertGetId($userdata);   
         
           \Auth::attempt([
                        'password'  =>$password ,
                        'email'     => $a['email']
                        ], true);
            $message=  "reload" ; 
        } 
       
    return @$message;    
 }
 
 function signin($a=[]){
         $message= "";
       if(empty($a['email'])  || empty($a['password'])) return '';
       
         if (\Auth::attempt([
                           'password'  => @$a['password'],
                           'email'     => @$a['email']
                            ], true)) {
          
           return "";
         }else{
           return '<b style="color:red;">'._l("Wrong password or email."). 
                      '<a href="#" onclick="modaljs(this, \'show\' ); return false;" data-modal="#login_window">'._l("Try to reset your password.").'</a>'.'</b>';  
         }
          
 }
 
 /**
    * Description : check user role which type of users login
    */ 
    public function role() {
        //return $this->hasOne('App\Role', 'id', 'user_role');
       $return=  \DB::table('users')
                    ->where('users.id', \Wh::id_user())
                    ->Join('role', 'users.user_role', '=', 'role.id')
                    ->select('role.role_name')
                    ->first();
          
        return empty($return)? false : $return->role_name;
    }
    /**
     * Description : check has role if user has any role assigned
     */ 
    public function hasRole($roles){
        
        // Check if the user is a root account
        if($this->role() === false){
            return false;
        }
        
        if($this->role() == 'admin') {
            return true;
         }
         

        if(is_array($roles)){
            foreach($roles as $need_role){
                if($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else{
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }

    /**
     * Description : check role from database
     */ 
    private function getUserRole()
    {
        return $this->role();
    }

    // 
    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role)==strtolower($this->role())) ? true : false;
    }
 
 
  public function buildEmail($type = '', $data=[]){
       $page = Page::where('main', $type)->first();
    
       $page_json = @json_decode(@$page->options, true);  
   
        if(empty($page)) return '';
        if( @$page_json['enable'] !="enable" ) return '';
     
        $content = @$page->text;
        $subject = @$page_json['subject'];
        
        $email = @$data['email'];  
        
        preg_match_all("/\[([^\]]*)\]/", $content, $matches);
        
        if(!empty($matches[1])){
            $arraySearch=[];
            $arrayReplace=[];
            foreach($matches[1] as $shortCode){
                if(!empty($data[$shortCode])){
                      $arraySearch[]='['.$shortCode.']';
                      $arrayReplace[]=@$data[$shortCode];
                   } 
            }
          $content = !empty($arraySearch) ?  @str_replace($arraySearch, $arrayReplace, $content ) : $content; 
        }
        
        Mail::to($email)->send(new WorldthemMail($subject, $content));  
    }  
 
 
 
 
    
}
