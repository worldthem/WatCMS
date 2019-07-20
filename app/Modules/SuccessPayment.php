<?php
 namespace App\Modules;
 
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Modules\Page;
use App\Modules\Cart;
use App\Modules\Orders;
use App\Modules\CuponApplied;
use App\Modules\Product;
use App\Mail\WorldthemMail;
use Illuminate\Support\Facades\Mail;
 
class SuccessPayment extends Model
{
   
  public $unik_nr;
    
    
public function response($dataPayment=[], $order_id=0){
    $order = Orders::find($order_id); 
     
    $this->unik_nr = \Wh::get_random(20) ;
    
    $optionsData=  json_decode($order->options, true);   
    $optionsData = $optionsData + $dataPayment;
    $data = ['options'   =>@json_encode($optionsData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ,
             'secretnr'  => $this->unik_nr,
             'created_at'=> date("Y-m-d H:i:s"),
             'status'    => $dataPayment['status'] ?? 'Incomplete' 
            ];
            
    Orders::where('id', $order_id)->update($data);
    
    $cartData= @\Wh::get_cart(2, $order_id);
    
    $user_id= '';
    
    if(!empty($cartData)){
          foreach($cartData as $v){
             $user_id=  $v->user_id; 
              $options = @json_decode($v->variations);
              $get_price= @\Wh::get_price_number($v->pr_price, $v->sale_price, @$options->variation[$v->options_id]->price);
              $total=round($get_price * $v->qty , 2);
               
                Cart::where('id', $v->cartid)
                      ->update( ['typecart'=> 4, 'price'=>$total]); 
            } 
         }
             
        CuponApplied::where('user_id', $user_id)
                       ->update( ['order_id'=> $order_id ]); 
            
        \Wh::hooks('afterpayment',['orderID'=>$order_id]);
                    
         // this email will go to costomer 
        $this->email_prepare('processing', $order_id);
        
        // this email will go to Admin
        $this->email_prepare('processing', $order_id);
        
       return $this->unik_nr;
  }
 
 
 
 public function email_prepare($type='', $order_id=0 ){
  
    $page = Page::where('main', $type)->first();
    
    $page_json = @json_decode(@$page->options, true);  
   
    if(empty($page)) return '';
    if( @$page_json['enable'] !="enable" ) return '';
     
    $content = $page->text ?? '';
    $subject = $page_json['subject'] ?? '';
    
    $email ='';
   if($order_id>0){ 
    $vorder= Orders::find($order_id);
     
     $jsonOptions = @json_decode($vorder->options);
     
    $jsonShipping = @json_decode($vorder->shipping);
    $order_billing =  $jsonShipping->billing ?? [];  
    $order_shipping=  $jsonShipping->shipping ?? [];
   
    $fields= @\Wh::get_settings_json('billing_fields') ;
    $fields_shipping= @\Wh::get_settings_json('shipping_fields') ;
   
    $order_amount=($jsonOptions->payd ?? 0).' '.($jsonOptions->currency ?? '');
    
    $bil_name =   $order_billing->name ?? '';
    $bil_lastname =  $order_billing->lastname ?? '' ;
    $email =  $order_billing->email ?? \Wh::get_user_name("current", "email"); 
    
   $table ='<table style="width: 100%; max-width:800px;min-width:320px" cellspacing="0">
                <tbody>';
                $cartAll = @\Wh::get_cart(4,$vorder->id);
             foreach($cartAll as $v){   
              $table .='
                <tr>
                    <td style="text-align: left; border-bottom:1px solid #e4e4e4; padding:15px;border-spacing: 0px;">
                        <a href="'.\Wh::product_url($v->cpu,$v->cat).'">
                         '.$v->title.'
                        </a>';
                        if(!empty($v->op_variations)) {
                        $table .='  <br />
                               <i> '.@\Wh::ret_option(@$v->op_variations).'</i>';
                             } 
               $table .='</td>
                    <td style="text-align: left; border-bottom:1px solid #e4e4e4; padding:15px;border-spacing: 0px;">
                      '.$v->qty.' <b>x</b> '. $v->cart_price .'  '.($jsonOptions->currency ?? '').' 
                    </td>
                 </tr>';
                }
                
              $table .='     
                 <tr>
                     <td style="text-align: right;padding:5px 15px;font-size: 15px;"><b>Cupon:</b> </td>
                     <td style="text-align: left;padding:5px 15px;font-size: 15px;"><b>Five bax</b></td>
                 </tr>
                 
                 <tr>
                     <td style="text-align: right;padding:5px 15px;font-size: 15px;"><b>Discount:</b> </td>
                     <td style="text-align: left;padding:5px 15px;font-size: 15px;"><b>-38.40 '.($jsonOptions->currency ?? '').'</b></td>
                 </tr>
                 ';
                 if(!empty($jsonShipping->shipping_id)){
                 $table .='     
                      <tr>
                         <td style="text-align: right;padding:5px 15px;font-size: 15px;"><b>'.\Wh::get_shipping_field($jsonShipping->shipping_id,  'shipping_name').'</b> </td>
                         <td style="text-align: left;padding:5px 15px;font-size: 15px;"><b> '.$jsonShipping->delivery_price.' '.($jsonOptions->currency ?? '').'</b></td>
                     </tr>
                     ';
                    } 
               $table .='  
                 <tr>
                     <td style="text-align: right;padding:5px 15px;font-size: 15px;"><b>Total:</b> </td>
                     <td style="text-align: left;padding:5px 15px;font-size: 15px;"><b> '.($jsonOptions->payd ?? '').' '.($jsonOptions->currency ?? '').'</b></td>
                 </tr>
                   
              </tbody>
        
        </table>';
        
        
   $shipping_billing= '  
      <table style="width: 100%; max-width:800px;min-width:320px" cellspacing="0">
            <tbody>
            
            <tr>
                <td style="text-align: left; border:1px solid #e4e4e4; padding:15px; vertical-align: top;" >
                  <div style="font-style:italic;font-size: 17px; font-weight: bold; margin-bottom:10px;"> '.$fields['header']['name'].'</div>
                    '; 
                    if(!empty($order_billing)) {
                      foreach($order_billing as $k5=>$v5){
                        $shipping_billing .='<b>'.$fields[$k5]['name'].' :'; 
                        $shipping_billing .=  $k5=="country" ? \Wh::get_countrybyid($v5, "country") : $v5;
                        $shipping_billing .='</b>';
                       }
                    }
   $shipping_billing .='
                </td>';
          if(!empty($order_shipping)) {  
   $shipping_billing .='<td style="text-align: left; border:1px solid #e4e4e4; padding:15px; vertical-align: top;"> 
                   <div style="font-style:italic;font-size: 17px; font-weight: bold; margin-bottom:10px;">'.$fields_shipping['header']['name'].'</div>
                    '; 
                     
                      foreach($order_shipping as $k5=>$v5){
                        $shipping_billing .='<b>'.$fields_shipping[$k5]['name'].' :'; 
                        $shipping_billing .=  $k5=="country" ? \Wh::get_countrybyid($v5, "country") : $v5;
                        $shipping_billing .='</b>';
                       }
                     
    $shipping_billing .='</td>';
                 }
    $shipping_billing .=' </tr>
               
            </tbody>
      </table>';
  
  $content = @str_replace('[products]',$table, $content);
  $content = @str_replace('[billing_shiping]', $shipping_billing, $content);
  $content = @str_replace('[order_number]', $order_id, $content);
  $content = @str_replace('[order_amount]', $order_amount, $content);
  $content = @str_replace('[first_name]', $bil_name, $content);
  $content = @str_replace('[last_name]', $bil_lastname, $content );

  $subject = @str_replace('[order_number]', $order_id, $subject);
  $subject = @str_replace('[first_name]', $bil_name, $subject);
  $subject = @str_replace('[last_name]', $bil_lastname, $subject);
  
  }// if is email for orderers  
    
  Mail::to($email)->send(new WorldthemMail($subject, $content));  
    
    $bil_lastname=  null;
    $table =null;
    $content =null;
    $shipping_billing =null;
    $order_id =null;
    $bil_name =null;
    $order_amount =null;
    $subject =null;
    $jsonShipping =null;
    $page =null;
    $page_json =null;
    $vorder =null;
    $jsonOptions =null;
 }
 
 
}