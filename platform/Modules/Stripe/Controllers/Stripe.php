<?php namespace Platform\Modules\Stripe\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Platform\Modules\Stripe\Controllers\StripeController;

/**
 * Stripe
 *
 * Controller to house all the functionality directly
 * related to the Stripe.
 */
 
class Stripe extends Controller
{
    
    public function run(){
         
    }  
    
    /**
     * This will show to checkout page 
     */
     public function frontend($data=[]){
     
       return view("Stripe::frontend", compact('data'));  
     }  
    
    
    /**
     * This will bee the admin option 
     */
     public function admin($data=[]){
        return view("Stripe::admin", compact('data'));    
     }
     
     /**
     * This will bee the final method what make the payment
     */
    public function  make_payment($data=[] ){
            $data = @base64_encode(json_encode(@$data));
           return url('/stripe/make-payment/'.$data);
     }
     
     
}