<?php

namespace Platform\Modules\Paypal\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Modules\SuccessPayment;

require __DIR__ . "/../vendor/autoload.php";
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;

use PayPal\Api\Payee; 
use PayPal\Api\Payer;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use App\Http\Controllers\Controller;
//use Redirect;

class PaypalController extends Controller {
   
   public function __construct()
    {

               /** PayPal api context **/
                $payment_systems = @\Wh::get_settings_json('payments_settings');
                
                $this->_api_context = new ApiContext(new OAuthTokenCredential(
                    @$payment_systems['Paypal']['id'],
                    @$payment_systems['Paypal']['secret']
                   )
                );
                
                $this->_api_context->setConfig([
                                'mode' =>  @$payment_systems['Paypal']['mode'],
                                'log.LogEnabled' => true,
                                'log.FileName' => '../PayPal.log',
                                'log.LogLevel' => 'DEBUG', // PLEASE USE `FINE` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                                'cache.enabled' => true 
                               ]
                           );
        
   }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function make_payment($order_id='', $total=0)
    {
          
           $payer = new Payer();
           $payer->setPaymentMethod("paypal");
        
            //Sett ittem
            $item_1 = new Item();
            
            $item_1->setName('Order ID: '.$order_id.'; from '.\URL::to('/') ) /** item name **/
                        ->setCurrency(CURENCY_CODE_KEY)
                        ->setQuantity(1)
                        ->setPrice($total); /** unit price **/
            
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
                
                
            //Sett ittem    
        
        $amount = new Amount();
                $amount->setCurrency(CURENCY_CODE_KEY)
                    ->setTotal($total);
        
        
        $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Order ID: '.$order_id.'; from '.\URL::to('/'));
        
        /*Get redirect url*/
        $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(url("/paypal/process/$order_id")) /** Specify return URL **/
                    ->setCancelUrl(url("/steps/checkout"));
      
             
              $payment = new Payment();
              $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
               
        $message= '';   
        try {
        
            $payment->create($this->_api_context);
        
        } catch (Exception $ex) {
            $message = $ex;
         }
         
         $approvalUrl = !empty($message)? $message : @$payment->getApprovalLink();
         
        return redirect()->away(@$approvalUrl);
      }
   
      
     public function process($order_id='', Request $request){
        $success = $request->get("success");
        $paymentId = $request->get("paymentId");
        $payer_id = $request->get("PayerID");
        $token = $request->get("token");
        
           
        if (empty($paymentId) || empty($token)) {
                   return redirect('/steps/checkout')  ;
            }
        
         $payment = Payment::get($paymentId, $this->_api_context);
         
         // ### Payment Execute
            // PaymentExecution object includes information necessary
            // to execute a PayPal account payment.
            // The payer_id is added to the request query parameters
            // when the user is redirected from paypal back to your site
            $execution = new PaymentExecution();
            @$execution->setPayerId($payer_id);
        
              $exec= "";
             try {
                // Execute the payment
                  $result = @$payment->execute(@$execution, $this->_api_context);
                  
                 try {
                    $payment = @Payment::get($paymentId, $this->_api_context);
                  
                   } catch (Exception $ex) {
                    $exec= $ex ;
                   
                   }
                   
             } catch (Exception $ex) {
                    $exec= $ex ;
              
              } 
              
         
            $obj = @json_decode($payment);
            //printw($obj);
            $status = @$obj->transactions[0]->related_resources[0]->sale->state=="completed" ? 'processing':'on-hold';
            
            $data1 =  ['paypaltxt' => @$obj->transactions[0]->invoice_number,
                       'txn' => @$payment->getId() ,
                       'currency' => $obj->transactions[0]->amount->currency,
                       'payd' =>  @$obj->transactions[0]->amount->total, 
                       'status'=> $status,
                       'message'=>@$payment,
                       'payment_status'=> @$obj->transactions[0]->related_resources[0]->sale->state,
                       'payment_type'=>'paypal'
                      ];
                    
            
            $payment_end = new SuccessPayment();
            $secret = $payment_end->response($data1, $order_id);  
           
          return redirect()->away('/steps/viewOrder/'.$order_id.'/'.$secret); 
            
      }
   
}
