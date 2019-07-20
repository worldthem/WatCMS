<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Modules\Orders;
use App\Modules\SuccessPayment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = "all", $s="" )
    {
            if($status=="all" && empty($s)){
                  $data= Orders::where('status','!=','Incomplete')->orderBy('id','desc')->paginate(50) ;
            }elseif(!empty($s)){
                  $data=  Orders::where("shipping",'like','%'.$s.'%')
                                 ->orWhere("options",'like','%'.$s.'%')
                                 ->orWhere("user_id",'like','%'.$s.'%')
                                 ->orWhere("id",'like','%'.$s.'%')
                                 ->orderBy('id','desc')
                                 ->paginate(50);
            }else {
                 $data= Orders::where('status',$status)->orderBy('id','desc')->paginate(50) ;
            } 
            
          $get_var = empty($s) ? $status : $s;
         return view('admin.pages.home', ['orders' =>  $data, 'getvar'=>$get_var]);
    }
    
    
    function viewOrder($id=""){
         $vorder = Orders::find($id);
          $options = @json_decode($vorder->options);
          $shipping = @json_decode($vorder->shipping);
          $order_billing =  $shipping->billing ?? [];  
          $order_shipping=  $shipping->shipping ?? [];
          
           $fields= @\Wh::get_settings_json('billing_fields');
           $fields_shipping= @\Wh::get_settings_json('shipping_fields');
           $payment_systems= @\Wh::get_settings_json('payments_settings'); 
          
         return view('admin.pages.vieworder', compact('vorder','options', 'order_billing', 'order_shipping','fields','fields_shipping','payment_systems' ));

    }
    
      /**
     * Remove or change status .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function  bulk_processing(Request $request)
    {
          $productid = $request->input('productid');
           $action = $request->input('action');
           $s = $request->input('s');
           $email= new SuccessPayment();
          
          if(!empty($action) && empty($s) && !empty($productid)){
              
              foreach ($productid as $val){
                 if($action=='del'){
                         Orders::where('id', $val)->delete();
                     }else{
                         
                         Orders::where('id', $val)->update(["status"=>$action]);
                         $email->email_prepare($action, $val);
                         
                     } 
                  }
           }
           
      return !empty($s)? redirect('/admin/orders/status/all/'.$s) :  redirect()->back() ;
    }
    
    
     public function change_status($id, $status='on-hold'){
             Orders::where('id', $id)->update(["status"=>$status]);
              $email= new SuccessPayment();
              $email->email_prepare($status, $id);
             return redirect()->back() ;
     }

    
  
   
     /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */ 
        public function user_orders($id='')
        {
              $orders = Orders::where('user_id',$id)->where('status','!=','Incomplete')->paginate(50);
             return view('admin.pages.home', ['orders' => $orders]);
        }

 
}
