<?php

namespace App\Http\Controllers;
 
 
use App\Modules\Product;
use App\Modules\Page;
use App\Http\Controllers\Controller;
use App\Helpers\HelperController;
use Illuminate\Http\Request;

class HomeControler extends Controller {
   public function index() {
        return view('theme::cach.home'); 
     }
     
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request) {
         
        try { 
            $settings = @\Wh::constant_key(_MAIN_OPTIONS_,  "_pageHome_");
            $cacheHome = @\Wh::constant_key(_MAIN_OPTIONS_,  "_cachehomepage_");
            $homeKey = @$request->get('keyHome'); 
            if(!empty($cacheHome)&& $homeKey != "SdeVssSDSFwe"){
              return view("standart.cache.home");
            }
            
            $product = !empty($settings)? Page:: where("id", $settings)->first() :
                       Product::join_query()
                                ->inRandomOrder()
                                ->paginate(20) ;
            
            $view = !empty($settings)? 'theme::pages' : 'theme::home';
             \Config::set('page', 'home');  
             return view()->exists($view)? 
                      view($view, ['products' => @$product,'rows'=>@$product, 'urlis'=>'',"content"=>@\Wh::shortCode(@$product->text) ]):'No view';
       
       } catch (\Exception $e) {
           return redirect('/install/') ;
             
        }    
    } 
 
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shop(Request $request) {
        try { 
             $product = Product::join_query()
                              ->inRandomOrder();
             $product =\Wh::GetParametrs($product, $request);
             $product = $product->paginate(20); 
             
             
             $view = 'theme::shop';
             return view()->exists($view)? 
                      view($view, ['products' => $product, 'rows'=>@$product, 'urlis'=>'' ]):'No view';
       
       } catch (\Exception $e) {
        
           return  redirect('/install/') ;
             
        }    
    }
     
}     