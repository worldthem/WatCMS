<?php namespace Platform\Modules\BankTransfer\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\SuccessPayment;
use App\Http\Requests;
/**
 * Paypal
 *
 * Controller to house all the functionality directly
 * related to the Paypal.
 */
 
class BankTransfer extends Controller
{
    
   public function run(){
             
        }  
    
    
    /**
     * This function is necesare it will show the html for checkoutform
     */
     public function frontend($data=[]){
       return view("BankTransfer::frontend", compact('data'));  
     }  
    
    
    /**
     * This function is necesare it will be for admin
     */
     public function admin($data=[]){
         return view("BankTransfer::admin", compact('data'));    
     }
     
     
     /**
     * This function is necesare it run when user well press pay
     */
     
     public function make_payment($data=[]){
      
          $data1 =  ['currency' => @CURENCY_CODE_KEY,
                     'payd' =>   $data['total'] ?? '',
                     'status'=> 'on-hold',
                     'message'=>'Pending',
                     'payment_type' =>'BankTransfer' 
                    ];
                    
                $Successpayment = new SuccessPayment();
                $secret = $Successpayment->response($data1,  ($data['order_id'] ?? ''));
         return url('/steps/viewOrder/'.$data['order_id'].'/'.$secret);
      }
     
 }