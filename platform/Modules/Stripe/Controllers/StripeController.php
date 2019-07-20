<?php
namespace Platform\Modules\Stripe\Controllers;

use Illuminate\Http\Request;
use App\Modules\SuccessPayment;
use App\Http\Controllers\Controller;

require __DIR__ . "/../vendor/autoload.php";

class StripeController extends Controller
{
    
     
   public function make_payment($data="" ){
           $data = @json_decode(@base64_decode($data), true);
             //printw($data);
             //return "";
           $order_id = @$data['order_id']; 
           $total = @$data['total'];
           $token = @$data['request']['stripe_token'];
           
          if(empty($token))
              return "Error: No Token";
          
          $payment_systems = @\Wh::get_settings_json('payments_settings');
           
          @\Stripe\Stripe::setApiKey(@$payment_systems['Stripe']['sk_secret']);
                
          $charge =@\Stripe\Charge::create([
                        'amount' => ($total * 100),
                        'currency' => CURENCY_CODE_KEY,
                        'description' =>  'Order ID: '.$order_id.' from '.\URL::to('/'),
                        'source' => $token,
                    ]);
        
                   
        
            $status = @$charge->status=="succeeded" ? 'processing':'on-hold';
           
            $data1 =  ['paypaltxt' => @$charge->id,
                       'txn' => @$charge->balance_transaction,
                       'currency' => $charge->currency,
                       'payd' =>  @$charge->amount / 100, 
                       'status'=> $status,
                       'message'=>@$charge->status,
                       'payment_status'=> @$charge->status,
                       'payment_type'=>'stripe',
                      ];
                    
             $payment = new SuccessPayment();
             $secret = $payment->response($data1, $order_id);  
            return redirect('/steps/viewOrder/'.@$order_id.'/'.@$secret);
          }
        
     
   
}
