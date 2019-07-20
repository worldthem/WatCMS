<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\FileUpload;
use App\Modules\Cart;
use Illuminate\Support\Facades\DB;
use App\Modules\Product;
class Download extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=0, $orderid=0) {
         
         $get_file= FileUpload::where('id',$id)->first();
         if(empty($get_file)) return redirect()->back();
         $role =get_current_user_role();
        
        $check_cart = Cart::where('cart.product_id', $get_file->id_post)
                           ->where('cart.typecart', '4')
                           ->where('cart.orderid', $orderid)
                           ->leftJoin('orders', 'cart.orderid', '=', 'orders.id')
                           ->where(function ($query) {
                                    $query->where( 'orders.status', 'processing')
                                          ->orWhere( 'orders.status', 'completed');
                                 })
                            ->where(function ($query) {
                                    $query->where( 'orders.user_id', \Wh::id_user("yes"))
                                          ->orWhere( 'orders.sessionuser', @\Wh::get_sesion());
                                 })
                            ->select("cart.id as cid","cart.downloaded as dNr","orders.id as oid")         
                           ->first();
          
           
          
         $destinationPath = public_path('product-files/'.$get_file->file);
        
          if(!empty($check_cart) && file_exists( $destinationPath )){
             Cart::whereid($check_cart->cid)->update(['downloaded'=>$get_file->dNr+1]);
             $response =  \Response::download($destinationPath, $get_file->originalFileName) ;
                 ob_end_clean();
             return $response;
          }else{
             return redirect()->back();
          }
         
        
       }

     
}
