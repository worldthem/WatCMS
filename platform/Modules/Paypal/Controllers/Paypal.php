<?php namespace Platform\Modules\Paypal\Controllers;

use App\Http\Controllers\Controller;
use Platform\Modules\Paypal\Controllers\PaypalController; 

/**
 * Paypal
 *
 * Controller to house all the functionality directly
 * related to the Paypal.
 */
 
class Paypal extends Controller
{
    
   public function run(){
             
        }  
    
    
    /**
     * This function is necesare it will show the html for checkoutform
     */
     public function frontend($data=[]){
       return view("Paypal::frontend", compact('data'));  
     }  
    
    
    /**
     * This function is necesare it will be for admin
     */
     public function admin($data=[]){
        return view("Paypal::admin", compact('data'));    
     }
     
     
     /**
     * This function is necesare it run when user well press pay
     */
     
     public function make_payment($data=[]){
          return url('/paypal/prepare/'.$data['order_id'].'/'.$data['total']);
       }
     
 }