<?php

namespace App\Http\Controllers\Install;

use File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;
 
class InstallController extends Migration
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * https://laravel.com/docs/5.6/migrations#creating-columns
     */
   
   
   /**
    * Check if is instaled 
    */
    
  public function install()
    {
       return $this->_check(redirect('/install/admin/'), 
             view("standart.Install.database",['error'=>""]));
    }
   
   
        
 public function database(Request $request) {      
       $check = $this->_check(redirect('/install/admin'),'doit');
       if($check !='doit') return $check;
       
      try {
                $host = $request->input('host');
                $database = $request->input('database');
                $username = $request->input('username');
                $password = $request->input('password');
               
                $conn = new \PDO("mysql:host=$host;dbname=$database", $username, $password);
                // set the PDO error mode to exception
                //$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $conn = null;
                 
            } catch (\PDOException $e) {
                $error = '<p style="color: red; background: #fff; padding: 5px; font-weight:bold;"> 
                             ERROR:'.$e->getMessage().'<br /> '._l('Please check your data').'!!</p>';
                return view("standart.Install.database",compact('error','host','database','username','password'));
            }

$data_en= "<?php
return [
'APPKEY'=>'".\Wh::get_random(32)."',
'APP_NAME'=>'WatCMS',
'APP_DEBUG'=>false,
'APP_URL'=>'".url("/")."',
'DB_HOST'=>'".$host."',
'DB_PORT'=>'3306',
'DB_DATABASE'=>'".$database."',
'DB_USERNAME'=>'".$username."',
'DB_PASSWORD'=>'".$password."',
'DB_TABLE_PREFIX'=>'f_'
];";

           //$result = copy(base_path().'/.env.example',base_path() . '/.env');
  try { 
  if(\File::exists(base_path() . '/config/systemconfig.php')) {
          \File::put(base_path() . '/config/systemconfig.php', $data_en);
  }else{
          copy(base_path().'/config/systemconfig.example.php',base_path() . '/config/systemconfig.php');
          \File::put(base_path() . '/config/systemconfig.php', $data_en);
    }
 
 return redirect('/install/admin/');
 
 } catch (\PDOException $e) {
                $error = '<p style="color: red; background: #fff; padding: 5px; font-weight:bold;"> 
                             ERROR:'.$e->getMessage().'<br /><br /> '._l('Your Root directory is writable. Use alternative method to install the CMS!!').'!!</p>';
                return view("standart.Install.database",compact('error','host','database','username','password',
                                                                 'websitename','adminuser','adminpassword'));
        }
        
 }
 
 /**
  * Create admin step
  */
public function admin_create(){
     return $this->_check(view("standart.Install.admin"), redirect('/install/'));
 }
 
public function final_step(Request $request){      
      //Check if is install was maded than redirect to "/" if not move forward 
       $check = $this->_check('doit', redirect('/install'));
         if($check !='doit') return $check;
       
       
       $websitename = @$request->input('websitename');
       $name = @$request->input('name');
       $adminuser = @$request->input('adminuser');
       $adminpassword = @$request->input('adminpassword');
       
       
        if(\DB::connection()->getDatabaseName())
           {
            $table_array = require app_path('Http/Controllers/Install/tables.php');
             foreach($table_array as $k=>$v){
                  if (!\Schema::hasTable($k)) {
                     
                      \Schema::create($k, function (Blueprint $table) use ($v) {
                         $table->increments('id');
                        
                         foreach($v as $k1=>$v1){
                            $type= @$v1['type'];
                            
                             if(isset($v1['length'])){
                                $table->$type($k1,$v1['length'])->nullable();  
                             }elseif($type == "timestamps"){
                                 $table->$type($k1); 
                             }elseif($type == "float"){
                                 $table->$type($k1, 12, 2)->nullable();  
                             }else{
                                $table->$type($k1)->nullable(); 
                             }
                              
                           }
                            
                        });
                  }
            }
            
                
               $password ="";
            if (\Schema::hasTable('users')) {
                $get = \DB::table('users')->get(); 
                
                if(count($get)==0){
                    $password = !empty($adminpassword)? $adminpassword :  \Wh::get_random(20);
                   
                   \DB::table('users')->insert(['name'=>$name, 'email'=>$adminuser, "user_role"=>"1", "password"=>bcrypt($password)]); 
                
                }
                
             }
             
               if (\Schema::hasTable('role')) {
                $get_r = \DB::table('role')->get(); 
                
                if(count($get_r)==0){
                   \DB::table('role')->insert(['role_name'=>'admin', "role_description"=>"This is administration" ]); 
                   \DB::table('role')->insert(['role_name'=>'subscribers', "role_description"=>"This is administration" ]);
                   \DB::table('role')->insert(['role_name'=>'editor', "role_description"=>"This user can only edit or add products" ]);
                   
                }
                
             }
             
               $this->readfile("categories");
               $this->readfile("product");
               $this->readfile("role");
               $this->readfile("settings");
               $this->readfile("shippcountry");
               $this->readfile("page"); 
                
                
             $message =  "<h2>This is your data for the Admin Dashboard:</h2> 
                            <p>
                               Login: <strong>$adminuser</strong><br />
                               Password: <strong>*****</strong><br /><br />
                             </p> 
                             ";
$dataSession="<?php
return ['SESSION_DRIVER'=>'database'];";
\File::put(base_path() . '/config/sessionsConfig.php', $dataSession);
                               
             \Wh::get_by_curl("https://watcms.com/json/new?url=".url("/"),"not") ;
                 
             return view("standart.Install.finish",['message'=>$message]); 
           }
    }
    
 private function readfile($table_name=""){
     if (\Schema::hasTable($table_name)) {
            $get_r = \DB::table($table_name)->get(); 
            
            $directory = app_path("Http/Controllers/Install/dumy/".$table_name.".php");
            $file_data =  File::exists($directory)? require $directory : []; 
            
            if(count($get_r)==0){
             foreach($file_data as $v){ 
                 \DB::table($table_name)->insert($v); 
              }  
            }
       }
 }   
    
    /**
     * check if is setup allow if not redirect
     */
 private function _check($ret1 = "", $ret2 = "", $table="users"){
       try {
           $pdo = \DB::connection()->getPdo();
           $dat= \Wh::get_settings('_install_');
           if($dat=="completed" || \Schema::hasTable($table)) {
               return redirect('/');
            }else{
                return $ret1;
            }
             
         } catch (\Exception $e) {
             
             return $ret2;   
          }
               
   } 
    
    
    protected function get_database_structure(){
        exit();
          $tables =  ['f_author',
                      'f_cart',
                      'f_colectmail', 
                      'f_comments', 
                      'f_country', 
                      'f_cupon', 
                      'f_cupon_applied', 
                      'f_gallery', 
                      'f_categories', 
                      'f_orders', 
                      'f_page', 
                      'f_product', 
                      'f_role', 
                      'f_sessions', 
                      'f_settings', 
                      'f_shiping', 
                      'f_shippcountry', 
                      'f_uploads', 
                      'f_usermeta',
                      'f_users',
                      'f_visits',
                      'f_wishlist',
             ];
          
    foreach($tables as $table){ 
        $columns = \DB::select('show columns from ' . $table);
         
       echo '"'.str_replace("f_","",$table).'"=>[<br />';  
                  foreach ($columns as $value) {
                   if($value->Field !='id'){ 
                    $split = explode("(", $value->Type);
                    $t1=$split[0];
                    $t2=str_replace(")","",@$split[1]);
                    //echo $t1;
                    if($t1 =="int"){
                       $type = $t2<=6 ?  '"type"=>"smallInteger"' : '"type"=>"integer"';
                    }elseif($t1 =="varchar"){
                        $type =  '"type"=>"string","length"=>'.$t2; 
                    }elseif($t1 =="text"){
                        $type =  '"type"=>"text"' ; 
                    }elseif($t1 =="float"){
                         $type =  '"type"=>"float"' ; 
                    }elseif($t1 =="datetime" || $value->Type =="timestamp" || $value->Type =="date"){
                         $type =  '"type"=>"dateTime"' ;
                    }elseif($t1 =="json"){
                         $type =  '"type"=>"json"' ; 
                    }elseif($t1 =="longtext"){
                         $type =  '"type"=>"longtext"' ; 
                    } 
                    
                    
                      echo '&nbsp;&nbsp;&nbsp;&nbsp; "'.$value->Field.'"=>['.$type.'],<br />';
                  }     
                 }
         echo '],<br /><br />';
  }   
        return ;
    }

private function get_content(){
      return "";  
        
        $row=\DB::table('page')->get();
        
        echo "[<br />";
            foreach($row as $k=>$v){
               echo  "['type'=>'".$v->type."',
                       'cpu'=>'".$v->cpu."',
                       'title'=>'".$v->title."',
                       'options'=>'".$v->options."',
                       'text'=>'".htmlspecialchars(str_replace("'","&apos;",$v->text))."', 
                       'main'=>'".$v->main."',
                        ],<br />";
             
             }
        echo "]<br />";
       
    /*  
   
 $row=\DB::table('shippcountry')->get();
        
        echo "[<br />";
            foreach($row as $k=>$v){
               echo  "['country'=>'".$v->country."','code'=>'".$v->code."'],<br />";
                
            }
        echo "]<br />";
  
 $row=\DB::table('product')->get();
        
        echo "[<br />";
            foreach($row as $k=>$v){
               echo  "['id'=>'".$v->id."',
                       'user_id'=>'".$v->user_id."',
                       'cat'=>'".$v->cat."', 
                       'SKU'=>'".$v->SKU."',
                       'qtu'=>'".$v->qtu."',
                       'title'=>'".$v->title."',
                       'cpu'=>'".$v->cpu."',
                       'text'=>'".$v->text."',
                       'weight'=>'".$v->weight."',
                       'price'=>'".$v->price."',
                       'sale_price'=>'".$v->sale_price."',
                       'attr'=>'".$v->attr."',
                       'optionsdata'=>'".$v->optionsdata."',
                       'hide'=>'".$v->hide."' 
                       ],<br />";
             
             }
        echo "]<br />";
        
  */ 
 }
   
  
     
}
