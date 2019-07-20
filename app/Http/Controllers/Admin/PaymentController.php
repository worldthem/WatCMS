<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Upload;
use Illuminate\Support\Facades\Crypt;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_payment = \Wh::get_settings_json('_active_modules_');
        $rows = [];
        $payment = \Wh::get_settings_json('payments_settings');
        foreach ($list_payment as $v){
            $payment_value= \Wh::get_config(@$v, "payment");
          if(!empty($payment_value)){
             $rows[$v] = @$payment[$v]['enable'];  
          }
        }
      return view("admin.pages.payment", compact("rows") );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings($module="")
    {
        
       //$list_payment = \Wh::get_settings_json('_active_modules_');
       $payment = \Wh::get_settings_json('payments_settings');
       $data = @$payment[$module];
       $view = @\Wh::check_clas_is(@\Wh::object_module($module, "payment")."@admin", $data) ;
         
       return view("admin.pages.payment", compact("view","module","data"));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                $action_field = $request->input('action_field');
                 
                $payment = \Wh::get_settings_json('payments_settings');
                 
                $upload  = new Upload();
                  
                   $data = $request->all();
                   $array = $data;
                  
                  $array['logo'] = isset($data['logo'])? $upload->simpleUpload($request, "logo" ) : $array['img']; 
                  $array['logo'] = isset($array['nologo'])? "" : $array['logo']; // 
                  
                  /*
                  if(isset($array['encrypted'])){
                     $arr= explode(",",$array['encrypted']);
                    
                        foreach($arr as $v){
                          $array[$v] = Crypt::encryptString($array[$v]);
                          Crypt::decryptString($encrypted);
                        }
                  }
                  */
                  
                  unset($array['encrypted']);
                  unset($array['_token']);
                  unset($array['action_field']);
                  unset($array['img']);
                  unset($array['nologo']);
                  
                 $payment[$action_field] = $array;
                 
                  \Wh::update_settings('payments_settings', '',  json_encode($payment) ); 
                 return redirect()->back(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($module='',$type="yes")
    {
       $payment = \Wh::get_settings_json('payments_settings');
       
       if($type=="yes"){
         $payment[$module]['enable'] =  "yes";
       }else{
         unset($payment[$module]['enable']);
       }      
                 
      \Wh::update_settings('payments_settings', '',  json_encode($payment) ); 
      return redirect()->back();
    }
   
}
