<?php

namespace App\Http\Controllers\Admin;
use App\Modules\User;
use App\Modules\Usermeta;
use App\Modules\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($s="" )
    {
        if (empty($s)){
            $users=User::orderby("id",'desc')->paginate(50);
        }elseif(ctype_digit($s)){
            $users= User::where("id", $s)->paginate(50);
        }else{
             $users=  User::where("name",'like','%'.$s.'%')
                          ->orWhere("email",'like','%'.$s.'%')
                          ->orderby("id",'desc')
                          ->paginate(50);
        }
         
                                      
        $roles = Role::orderby("id",'desc')->get();
         
        
        return view('admin.pages.users', ['rows' => $users,"getvar" =>  @$s, "roles" =>$roles]); 
    }


       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function single($id="" )
    {
          $user= User::where("users.id",$id)
                ->leftJoin('usermeta', 'users.id','=','usermeta.user_id')
                ->select("usermeta.meta_key", "usermeta.meta_value", "users.*","users.id as id" )
                ->first();
          
          $meta = @json_decode(@$user->meta_value,true);
          
          $roles = Role::orderby("id",'desc')->get();
          
         return view('admin.pages.userSingle', ['val' => $user, "roles" =>$roles, 'meta'=>$meta]); 
    }
    
     /**
     * Edit the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
           public function store (Request $request)
        { 
              $id = @$request->input('id');
              
              $password = @$request->input('password');
              $data = [
                    'name'=> @$request->input('name'),
                    'email' => @$request->input('email'),
                    'user_role'=>@$request->input('user_role')
               ];
               
               if(!empty($password)){
                $data['password'] = @bcrypt($password);
               }
               
           $object =  User::updateOrCreate(
                                 ['id' => $id ], $data
                             );
                   $objID= $object->id; 
         
          Usermeta::updateOrCreateMeta($objID,@$request->meta);   
                       
                        
         return redirect()->back() ; 
      } 
      

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_bulk(Request $request)
    {
          $rowid = $request->input('rowid');
           $action = $request->input('action');
            $s = $request->input('s');
          if(!empty($action) && empty($s)){
              
              foreach ($rowid as $val){
                 if($action=='del' &&  $val != "1" ){
                       User::where('id', $val)->delete();
                     }  
                 }
           }
           
       return !empty($s)? redirect('/admin/users/search/'.$s) :  redirect()->back() ;
    }

  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    { 
       if($id != "1"){ 
        User::where('id', $id)->delete();
        Usermeta::where('user_id',$id)->delete();
        }
       return redirect()->back() ;            
    } 
    
    
}
