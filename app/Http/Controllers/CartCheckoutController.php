<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Module;
use App\Modules\Paypal;
use App\Modules\User;
use App\Modules\Cupon;
use App\Modules\CuponApplied;
use App\Modules\Cart;
use App\Modules\Orders;
use App\Modules\SuccessPayment;
use App\Modules\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
 
use App\Http\Controllers\StripeController;
use App\Http\Controllers\PaypalController; 


class CartCheckoutController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    private function get_sesion(){
        $cookie = @\Cookie::get('tmp_user_id');
        return !empty($cookie) ? $cookie : "";
    } 
     
    public function index($params=""){
          $param = explode('/',$params);
          $page= preg_replace("/[^a-zA-Z0-9_]+/", "", $param[0]); 
        if (method_exists($this ,$page)){ //if method is in ModuleController
            unset($param[0]);
            return $this->$page($param);
        }else{
            return view('theme::errors.404') ;
        }
    }
    
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    function cart(){
        $check_qtu = Cart::where('user_id', $this->get_sesion())
                          ->where('typecart', 2)
                          ->select('id')
                          ->count();
          \Config::set('page', 'cart'); 
        return view('theme::cart',["err" =>  "","iderr"=>"", "cartnr" => $check_qtu, "cart_page"=>"yes"]);
    }
    
     
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkout() {
            // get last billing address what user enter
            $lastOrder = \Wh::get_last_address();
            $last_bill =  $lastOrder['billing'] ?? [] ;
            // get last shipping address what user enter
            $last_shipp = $lastOrder['shipping'] ?? [];
            
            // get last country id 
              $coubtry_id =  $last_bill['country'] ?? ''; 
              $coubtry_id = $last_shipp['sipping_country'] ?? $coubtry_id; 
              $coubtry_id = !empty($coubtry_id) ?  $coubtry_id : 0;
               
            // get total weight of products
            $cart_total =@\Wh::get_cart_total([],'weight');
            
            // get total price
            $total_checkout = @\Wh::get_price_full(@$cart_total['total'],0,'none');
            $kg = @$cart_total['kg'];
            $cart_total = @$cart_total['total'];
            if($cart_total<1){
                     return redirect("/");
                 }
            
            // get shipping list 
            $default_shiping = \Wh::get_shipping($coubtry_id, @$kg, @$cart_total);
             
            // check if any shipping is setup
            $if_shipping = \Wh::check_shipping();
            $term_condition = @\Wh::constant_key(_MAIN_OPTIONS_,  "_checkout_termandcondition_");
        
         \Config::set('page', 'checkout'); 
        return view('theme::checkout', compact("last_bill","last_shipp","cart_total","kg","total_checkout",
                                               "default_shiping","if_shipping","term_condition"));
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddToCart(Request $request ) {
        $id = @$request->input('id');
        $qtu = @$request->input('qtu');
        $option_id= @$request->input('options');
        $max_qtu= @$request->input('max_qtu'); 
        $oneQty= @$request->input('oneQty'); 
        $redirect= @$request->input('redirect');
         
        $wher = [['typecart','=',2], ['user_id','=',@$this->get_sesion()], ['product_id','=',$id]];
        if(is_numeric($option_id)){
            $wher[] =  ['options_id','=',$option_id];
        }
        $cart_ittem = Cart::where($wher)->select('id','qty')->first();
         
        $data = ['qty'=>$qtu, 'product_id'=>$id, 'typecart'=>2 ,'user_id' => @$this->get_sesion() ];
        
        if(is_numeric($option_id)){
          $data['options_id'] = $option_id;  
        }
        if( !empty($cart_ittem) && empty($oneQty) ){
            $total=  $qtu +  $cart_ittem->qty;
            $quantity = $total > $max_qtu ? $max_qtu : $total;
            $data['qty'] = $quantity; 
            $data['created_at']=date("Y-m-d h:i:s");
        } 
           $cart_id = !empty($cart_ittem)? $cart_ittem->id : 222323232;
           Cart::updateOrCreate(
                           ['id' => @$cart_id ],$data 
                         );
        
        $view = view()->exists("theme::layouts.small_cartittem")? 'theme::layouts.small_cartittem' : 'standart.small_cartittem';
      
      return 'ok~~~'.view($view ); 
    }

 /**
  * A quick link add to cart and redirect to checkout
  * productID - id product
  */
    public function quickBuy($productID=0){
             $wher = [['typecart','=',2], ['user_id','=',@\Wh::get_sesion()], ['product_id','=',$productID]];
             $cart_ittem = Cart::where($wher)->select('id','qty')->first();
            
             $cart_id = !empty($cart_ittem)? $cart_ittem->id : 222323232;
             $data = ['qty'=>1, 
                      'created_at'=>date("Y-m-d h:i:s"),
                      'product_id' => $productID,
                      'user_id' => @\Wh::get_sesion(), 
                      'typecart'=>2 
                      ];  
            
             
             Cart::updateOrCreate(
                           ['id' => @$cart_id ],$data 
                         ); 
        
        return  redirect("/steps/checkout/");                             
    }
    
      
    /**
     * All the operation on cart page like:
     *  delete ittem from cart 
     *  inncrement quantity
     *  decremment quantity
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function actioncart(Request $request) {
        $type = @$request->input('type');
        $id = @$request->input('id');
        $qty = @$request->input('qty');
        $opt = @$request->input('opt'); 
         
        $errss= "";
         if($type=="del"){
              Cart::where([['id',  $id],['user_id', $this->get_sesion()]])->delete();
          } 
          
          if($type=="incr") {
                $errss= $qty <= 0? " <span></span>":"";
                $errss= $qty > $opt? "<p style='color:red;'> "._l(' Left only')." $opt "._l('quantities')." </p>" : $errss;
              
               if(empty($errss) || $qty > $opt){  
                   $sql = $qty > $opt ? $opt :$qty;
                   Cart::where([['id',  $id],['user_id', $this->get_sesion()]])
                             ->update(['qty'=>$sql]);
                }
            }
           
           $view = view()->exists("theme::layouts.cartittem")? 'theme::layouts.cartittem' : 'standart.cart.cartittem';
             
         return "[cart]~~~".view($view, ["err" => $errss, "iderr" => $id ]);
      }
      

   public function CuponApply(Request $request){
      $cuppon = @$request->input('cuppon');
      
     $get = Cupon::where('cupon',$cuppon)
                                ->whereNull('publish')
                                ->select("id","used")->first();
      
     if(!empty($get)){
          $data1= ['cupon_id'=>$get->id,
                   'user_id'=>$this->get_sesion(),
                   'order_id'=>"1"];
          CuponApplied::updateOrCreate(['user_id'=>$this->get_sesion(),
                                         'order_id'=>"1"
                                        ],$data1);
          
          //$used= empty($get->used)? 1 : $get->used + 1;
          Cupon::where('id',$get->id)->update(['used'=>$get->used + 1]);
        
         $view = view()->exists("theme::layouts.cartittem")? 'theme::layouts.cartittem' : 'standart.cart.cartittem';
        
          return "[cart]~~~".view($view, ["err" => @$errss, "iderr" => @$id ]);
      
      }else{
         return  _l('This cuppon is expired!'); 
      }
   } 
    
     
    
    /**
     * This will prepare array and will check if field is requaired 
     */
     
    private function prepare_data($request, $arr= "", $key=""){
        $error = '';
        $data = [];
        $all_input= @array_reverse($request->all()) ;
         
        foreach($all_input as $k=>$v){
                $k = !empty($key)? str_replace($key,'',$k) : $k; 
                if(isset($arr[$k])){
                    $data[$k]=$v;
                    if(isset($arr[$k]['required']) && empty($v)){
                         $error =$k;
                         break;
                     }
               } 
         }
          
        $er= empty($error) ? '':'[script]~~~ addClass($$(".cl_'.$key.$error.'") , "invalid"); $$(".cl_'.$key.$error.'").required="required"; $$(".cl_'.$key.$error.'").focus(); ';
        unset($data['password']);
        return ['data'=>$data, 'error'=>$er];
        
     }
     
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function place_order(Request $request) {
           
           $billing = @\Wh::get_settings_json('billing_fields','value1') ;
           $shipping = @\Wh::get_settings_json('shipping_fields','value1') ;
         
               
               $bill=['data'=>[]];
           if(is_array($billing) && count($billing)>0){
               $bill= $this->prepare_data($request, $billing);
               if(!empty($bill['error'])) return $bill['error'];
           }
            
            $ship=['data'=>[]];
            $_differentaddres= $request->input('_differentaddres');
            
          if(is_array($shipping) && count($shipping)>0 && !empty($_differentaddres)){  
                $ship = $this->prepare_data($request, $shipping,"sipping_");
                if(!empty($ship['error'])) return $ship['error'];
            }
           
            // get the price of delivery
            $delivery = @$request->input('deliverymethod');
            $if_shipping = \Wh::check_shipping();
           
            if($if_shipping && empty($delivery)){
                return '[script]~~~ window.location.href="#shipping_method";  $$$(".cl_deliverymethod").each(function() { this.required="required" }); ';
            }
           
           // prepare payment, generate invoice 
            
            $cart_total =@\Wh::get_cart_total([],"cuppon");
            $total = is_array($cart_total) ? $cart_total['total'] : $cart_total;   
            
            
            $shipping= !empty($delivery)? @\Wh::get_shipping_cost($delivery, $total) : 0;
            $total = $shipping + $total;
            
            $shippingData=['billing'=>$bill['data'] ?? '',
                           'shipping'=>$ship['data'] ?? '',
                           'shipping_id'=>$delivery ?? 0,
                           'delivery_price' =>$shipping ?? 0,
                           'cupon_name'=>$cart_total['cuppon'] ?? '',
                           'cupon_discount'=>$cart_total['discount'] ?? 0 
                           ];
             $optionsData=['price_total' => $cart_total['total'] ?? 0,
                           'currency'    => CURENCY_CODE_KEY ];              
           
       $data1 = ['shipping' => @json_encode($shippingData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
                 'options' => @json_encode($optionsData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
                 'sessionuser'=> $this->get_sesion(),
                 'user_id' => \Wh::id_user(),
                 'status'=> 'Incomplete',
                 'created_at' => date("Y-m-d H:i:s") ];
                 
          $order_id = Orders::insertGetId($data1);
          
          Cart::where('user_id', $this->get_sesion())
              ->where('typecart', 2)
              ->update(['orderid' => $order_id]);    
            
            
            // registr the user if is checked
             $password= @$request->input('password');
             $email= @$request->input('email');
             if(!empty($password) && !empty($email)){ 
                $data= [
                     'email'=> @$request->input('email'), 
                     'name'=>@$request->input('email'), 
                     'password'=>@$request->input('password'),
                     'checkout'=>'checkout' ];
                     
               $registr= new User();
               $reg = $registr->registrations($data);
               
               if($reg=='is'){
                 $reg = $registr->signin($data);
                  if(!empty($reg)){
                       return $reg;
                     }    
                  }
             }
             
                $payment = @$request->input('payment');
                
                if(empty($payment)) 
                               return  _l("Please select a payment method!");
                
                $data = ['order_id'=>$order_id,'total'=>$total, 'request'=>$request->all()];
                $url = @\Wh::check_clas_is(@\Wh::object_module($payment, "payment")."@make_payment", $data) ;
                
            return filter_var($url, FILTER_VALIDATE_URL) === FALSE ? $url  : 
                                                          '[script]~~~ window.location.href="'.$url.'";';
     }
 
    public function onlyPayment(Request $request){
        
       $orderid = $request->orderid;
        
       $order = (new Orders)->getOrer($orderid); 
      
       $payment = @$request->payment; 
       if(empty($payment)) 
               return  _l("Please select a payment method!");  
       
       $options = @json_decode($order->options); 
       $data = ['order_id'=>$orderid, 'total'=>($options->price_total ?? 0), 'request'=>$request->all()];
       
       $url = @\Wh::check_clas_is(@\Wh::object_module($payment, "payment")."@make_payment", $data) ;
       
       return filter_var($url, FILTER_VALIDATE_URL) === FALSE ? $url  : 
                                                        '[script]~~~ window.location.href="'.$url.'";';
        
    }
    
    
 public function viewOrder($param=[]){
         $id=@$param[1];
         $secretcod= @$param[2];
         $where =  Auth::check() && ($id=="n" || empty($id) ) ? 
                             [['user_id','=',\Wh::id_user()]] :
                              
                             [['id', '=', $id],['secretnr', '=', $secretcod]] ;
         
         $order= Orders::where($where)->get(); 
        \Config::set('page', 'orders');
         return view('theme::vieworder', ['order' => $order, 'all'=>""]);
    }
   
    
     
 public function shipping_get(Request $request){
        $id= @$request->input('id'); 
        $kg= @$request->input('kg');
        $kg= !empty($kg)? @$kg :0 ;
        $total= @$request->input('total');
        return \Wh::get_shipping($id, $kg, $total);
      }
     
    
   
}
