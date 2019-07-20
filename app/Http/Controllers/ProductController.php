<?php

namespace App\Http\Controllers;
 
use App\Modules\Product;
use App\Modules\Admin\Categories;
use App\Modules\Comments; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
 
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
 
use App\Helpers\HelperController; 


class ProductController extends Controller {
   protected $constructor; 
    
 public function __construct() {  
       $this->constructor = new Product ();
    }
    
   public function index() {
        //return view('cach.home'); 
     }
   
   public function sort($type='asc') {
         session(['priceSort' => $type]);
         return redirect()->back();
     }
   
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function showproductfromcategory($params = null, Request $request) {
       
        if(empty($params))
           return view('standart.404'); 
           
             $array_cpu= explode('/', $params);
             $cpu= last($array_cpu);
             $catStructure = _CATEGORIES_STRUCTURE_;
           
              $currentCatID = @\Wh::getCatParent(@$cpu);
              if(empty($currentCatID)){
                 return view('standart.404');
              }
                
              \Config::set('page', 'productCat'); 
              \Config::set('catID', $currentCatID);
              $catChild= \Wh::catChildsId($currentCatID); 
              
              $product = Product::where('qtu','>',0)
                                 ->where(
                                  function($query) use ($catChild) {
                                             $query= $query->whereJsonContains('cat', [$catChild[0]] ); 
                                              for($i=1; $i<count($catChild);$i++){
                                               $query=  $query->orWhereJsonContains('cat', [$catChild[$i]]);  
                                               } 
                                          return $query;    
                                  }); 
                                  
                 $product =\Wh::GetParametrs($product, $request);
                 $product = $product->paginate(20); 
               
            return view('theme::productlist', ['products' => $product, 'catname'=>@$catStructure[$currentCatID]['title'],'cat_id'=>@$get_id,'cat_cpu'=>@$cpu,'cattitle'=>@$catStructure[$get_id]['title'],"maincat"=>@$catStructure[$main_id], 'catsStructure'=>@$catStructure ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
            $search = @$request->get("s");
            $cat  = @$request->get("cat");
            $mode = @$request->get("mode");
         
            $url= !empty($search)? $search :"no product much";
            $cat= !empty($cat)? \Wh::get_catbyfield('id', 'cpu', @$cat)  :"";
            
            $wherearr=[['qtu','>',0]];
             
            if(!empty($cat)){
             $wherearr[] = ['cat','=',$cat];  
             \Config::set('catID', $cat);
            }
             
              $product =   Product::where($wherearr)
                                ->where(function ($query ) use ($url) {
                                    if(is_numeric($url)){
                                       $query->where('id', '=',  trim($url) );
                                    }else{
                                       $query->where('title', 'like', '%'.$url.'%')
                                                 ->orWhere('text', 'like', '%'.$url.'%')
                                                 ->orWhere('description', 'like', '%'.$url.'%')   
                                                 ->orWhere('SKU', 'like', '%'.$url.'%');  
                                    }
                                     
                                   }) ;
                                   
                                   
                 $product =\Wh::GetParametrs($product, $request);
                 $product = $product->paginate(20);                    
                      \Config::set('page', 'search');   
                      \Config::set('search', @$search);            
            if($mode == 'ajax'){
                 $template= view()->exists('theme::search') ? 'theme::search' : 'standart.search';
               }else{
                 $template=  'theme::productlist';
             }
             
             
            return view($template, ['products' => $product,'catname'=>"Search for:".$url, 'search'=>$url,'cat_id'=>$cat,'cat_cpu'=> @$request->get("cat"), 'cattitle'=>@\Wh::get_catbyfield('title', 'id', @$cat) ]);
    }
     
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mini_single($request) {
           $id = $request->input('id');
            
           $product  =  $this->constructor->get_single_product('id',$id);                   
            \Config::set('productID', @$product->id);
               $template= view()->exists('theme::layouts.minisingle') ? 'theme::layouts.minisingle' : 'standart.product.minisingle';                     
       return view($template, ['product' => $product,'quickvieid'=>'mini_idis']);
    }
    
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleproduct($params = null) {
        if(empty($params))return view('standart.404'); 
         $array_cpu= explode('/', $params);
         $cpu= end($array_cpu);
         
          $product  = $this->constructor->get_single_product('cpu',$cpu);
           if(empty($product))return view('standart.404'); 
            
           \Config::set('productID', @$product->id);
           \Config::set('catID', \Wh::json_key(($product->cat??[]), 0) );
           \Config::set('productTitle', @$product->title );
           \Config::set('page', 'single'); 
           
        return view('theme::singleproduct', compact('product'));
     }
    
    /**
     * Show Single product by id.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleproduct_by_id($id="") {
        $product = $this->constructor->get_single_product('id',$id); 
         \Config::set('productID', @$product->id);
         \Config::set('page', 'single');
         \Config::set('catID', \Wh::json_key($product->cat, 0) );
         \Config::set('productTitle', @$product->title );
           
           
      return view('theme::singleproduct', ['product' => $product]);
    }
    
    
    /**
     * Add a new comment
     * 
     */
    public function new_comment(Request $request){
        $name = $request->input('comment_author');
        
        $data = [
            'comment_author'=>$request->input('comment_author'),
            'comment_author_email'=>$request->input('comment_author_email'),
            'id_post'=>$request->input('id_post'),
            'stars'=>$request->input('stars'),
            'comment'=>$request->input('comment'),
            'comment_author_IP'=>$request->ip(),
            'id_user'=>$request->input('id_user'),
            'status' =>1,
            'created_at'=> date("Y/m/d h:i:s")
        ];
      
      Comments::insert($data);  
        
      return "<span class='fa_publish'></span>";  
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setupcurrency($currid="") {
        $currid=$currid ==777? "":$currid;
         //Session::put('currency_shop',  $currid);
         setcookie('currency_shop', $currid, time() + (86400 * 100), "/");
        
        return redirect()->back();
    }


   /**
     * Display wishlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function wishlist() {
            $product = Product::where('qtu','>',0)
                       ->leftJoin('wishlist', 'wishlist.idproduct', '=', 'product.id')
                       ->where('wishlist.session','=',@\Wh::get_sesion())
                       ->paginate(21);
            \Config::set('page', 'wishlist');
           // print_r( $product);
            return view('theme::productlist', ['products' => $product,'catname'=>_l('Wishlist'),'cattitle'=>'' ]);
    }
    
     /**
     * Add to wishlist.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function AddToWishlist(Request $request) {
         $pid = $request->input('id');
        
         if(\DB::table('wishlist')->where('idproduct','=',$pid)->where('session','=',@\Wh::get_sesion())->count() == 0){
          $lastid= \DB::table('wishlist')->insertGetId(['session'=>@\Wh::get_sesion(), 'idproduct'=>$pid]); 
          }
           
           return "ok";
      }
    
 
   
}
