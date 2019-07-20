<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartCheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AjaxController;
class WajaxController extends Controller
{
    /**
     * ajax_function.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product = new ProductController();
        $checkout = new CartCheckoutController();
        $signup = new UserController();
        $page = new PageController();
        $ajax = new AjaxController();
        $action = preg_replace("/[^a-zA-Z0-9_]+/", "", @$request->get('action'));
        
        /**
         * check if method is in controler
         */
         
        if (method_exists($product ,$action)){ //if method is in ProductController
           return $product->$action($request); 
           
        }elseif(method_exists($checkout ,$action)){ //if method is in CartCheckoutController
            return $checkout->$action($request);
            
        }elseif(method_exists( $signup ,$action)){ //if method is in UserController
            return $signup->$action($request);
            
        }elseif(method_exists( $ajax ,$action)){ //if method is in AjaxController
            return $ajax->$action($request);
            
        }else{ //if method is not in any of Controllers
        
            return  "Smething not all right, check again!!"; 
        }
        
     }

    
}
