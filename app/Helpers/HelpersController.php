<?php

namespace App\Helpers;

use App\Modules\Page;
use App\Modules\Settings;
use App\Modules\Product;

class HelpersController 
{ 
   
  
/**
   * When customer open the website the website setup a cookie with a unic id for each separated
   * Will return that unic id what you can use for cart or use your imagination
   */  
    
public static function get_sesion(){
    $cookie = @\Cookie::get('tmp_user_id');
    return !empty($cookie) ? $cookie : "";
}
    
  /**
  * Get products from cart
  */
public static function get_cart($typecart=2, $order_id= "n"){
      $where = [];
      $where[]= $order_id == "n"? ['cart.user_id', self::get_sesion()] : ['cart.orderid', $order_id];
      $where[] = ['cart.typecart', $typecart];
      
      
        $cart = \DB::table('cart')
                 ->orderBy('cart.product_id')
                 ->where($where)
                 ->leftJoin('product', 'cart.product_id', '=', 'product.id') 
                 ->select('cart.*','cart.price as cart_price' ,'cart.id as cartid' ,'product.attr','product.qtu',
                          'product.weight' ,'product.id as pid', 'product.title','product.cpu', 'product.sale_price', 
                          'product.price as pr_price', 'product.cat', 'product.optionsdata');
               
                if($typecart==2){
                    $cart= $cart->where('product.qtu','>',0)
                                ->where('product.hide','>',0);
                   }
                $query=$cart->get(); 
                
        
    
    return $query;
}

/**
 * It will return price ittem and will update quantity
 * if the product cuantity are less than cart quantity then will update them
 */
public static function cart_operation($v=[],$options=[]){
      $quantity = !empty($v->optid) ?  @$options->variation[$v->options_id]->qtu : $v->qtu; 
      $quantity_cart = $v->qty > $quantity ? $quantity : $v->qty;
       
      $price =\Wh::get_price_number($v->pr_price, @$v->sale_price, @$options->variation[$v->options_id]->price);
      $total = round($price * $quantity_cart , 2);
       if($v->qty > $quantity){
          \DB::table('cart')
                 ->where([['id', '=', $v->cartid],['user_id', '=', self::get_sesion()]])
                 ->update(['qty'=>$quantity]);
       } 
   return compact('price','total','quantity', 'quantity_cart') ;   
}

/**
 * Get cart total
 */
public static function get_cart_total($arry=[], $type=''){
           $subtotal = 0;
          
           $weight = 0;
          $total_cart = !empty($arry)? $arry : self::get_cart(); 
    foreach($total_cart as $v){
            $options = @json_decode($v->attr);
            $quantity = !empty($v->optid) ? @$options->variation[$v->options_id]->qtu : $v->qtu; 
          
          if($quantity > 0){
              
              $weight = !empty($options->variation[$v->options_id]->weight)? 
                             $weight + @$options->variation[$v->options_id]->weight :  $weight + $v->weight;
               
              $get_price= @\Wh::get_price_number($v->pr_price, $v->sale_price, @$options->variation[$v->options_id]->price);
              $total=round($get_price * $v->qty , 2);
              $subtotal = round($subtotal + $total, 2);
          }
    }
    
    if($type=="cuppon"){
        return @self::get_applied_cupon($subtotal,'yes');
    }elseif($type=="weight"){
        return ['kg'=>$weight, 'total'=> @self::get_applied_cupon($subtotal) ];
    }else{
       return @self::get_applied_cupon($subtotal); 
    }
   
}
 
 
/**
 * Get applied cupon 
 */
public static function get_applied_cupon($subtotal=0, $nr=""){
      $cuppon =\DB::table('cupon_applied')
                    ->where('cupon_applied.user_id', self::get_sesion())
                    ->where('cupon_applied.order_id','1' )
                    ->join('cupon', 'cupon.id', '=', 'cupon_applied.cupon_id')
                    ->whereNull('cupon.publish')
                    ->select("cupon.*")
                    ->first();
      
       if($nr=="name"){
         return $cuppon->cupon;
       }
       $discount_minus = 0;
       if(!empty($cuppon) && $subtotal>0){
       $discount = $cuppon->type =="fix" && $cuppon->amount < $subtotal ?  
                    $subtotal - $cuppon->amount :
                    $subtotal  - ( $subtotal * $cuppon->amount)/100 ;
                    
       $discount_minus = round($subtotal - $discount, 2);             
                  
         }else{
            $discount = $subtotal;
         }  
                    
      return !empty($cuppon) && $nr=="yes"?  ['subtotal'=>$subtotal, 'total'=>round($discount, 2), 'cuppon'=>$cuppon->cupon,  'discount'=> $discount_minus] : 
                                              round($discount, 2);             
 }
 
  public static function calcTotal($total = 0, $price=""){
     $subtotal = @self::get_applied_cupon($total);
     return empty($price) ? $subtotal : @\Wh::get_price_full($subtotal); 
  }   
    
 /**
 *  will return type of rows from table "pages" if you just need in case
 */  
 public static function getPagesQuery($type='pages'){
    $Page = Page::where('type',$type)->orderBY('sort','asc')->get();
    return $Page;
 }   
 /**
 *  will return the right tab for an individual tab 
 */ 
  public static function rightTab($content='', $product=''){
          if (strpos($content, '[reviews]') !== false) {
              return view('standart.product.reviews',compact('product'));
           }elseif (strpos($content, '[specifications]') !== false) {
              return view('standart.product.specification',compact('product'));
           }elseif (strpos($content, '[descriptions]') !== false) {
              return '<div class="col-md-12">'.$product->text.'</div>';
           }else{
              return '<div class="col-md-12">'.$content.'</div>';
           }
  } 
  
 /**
 *   here is all the procces for product tabs 
 */ 
 public static function productTab($product=[]){
    $tabs = @self::getPagesQuery('tabs');
     $i=0;   
     $tabsName='';
    $tabsContent=''; 
    
     foreach($tabs as $valtabs){
      $json = @json_decode(@$valtabs->options, true);
            $i++;
            $activeTab = $i==1 ? " active":"";
          
         $tabsName .= '<li class="tab_buttons  Tab'.$valtabs->id.' '.$activeTab.'">
                        <a href="#Tab'.$valtabs->id.'" class="nav-link" onclick="return setTab(\'Tab'.$valtabs->id.'\');" >'.@$valtabs->title.'</a>
                      </li> '; 
       
       $tabsContent .= ' 
                       <div class="tab-pane'.($i==1 ? '':' display_none').'" id="Tab'.$valtabs->id.'">
                         '.\Wh::rightTab($valtabs->text, $product ) .'
                       </div> 
                                     ';
        }                                  
         if(\Wh::UserRole("admin")){   
           $tabsName .= '<li class="tab_buttons">
                            <a href="'.url('/admin/page/tabs').'" class="nav-link editTabsAdmin" onclick="return \Wh::quickEdit(this);"><i class="fa fa-pencil"></i><i class="fa fa-plus"></i></a> 
                        </li> ';    
            }
       return count($tabs)>0 ? compact('tabsName','tabsContent') : '';
   } 
   
 /**
 *   when customer select a product by parametrs color or size or any other variations or specifications
 *   this function will separate and prepare the query 
 *    so in your query just call it :  
 *    $product = \Wh::GetParametrs($product, $request);  
 *   if is not setup nothing then will not take any resurce
 */ 
   
   public static function GetParametrs($product, $request, $attr=[]){
            $GetData = $request->all();
             
               if(!empty($GetData) && empty($attr)){
                   $getSettins = \Wh::get_settings_json('_attributes_');
                   $variations = @is_array($getSettins['variations'])? $getSettins['variations'] :[];
                   $specifications = @is_array($getSettins['specifications'])? $getSettins['specifications'] :[];
                   $allspec= @array_merge(@$variations, @$specifications );
                   if(!empty($allspec)){
                      foreach($GetData as $k2=>$v2){
                        if(isset($allspec[$k2]))
                          $attr[$k2] = $v2;  
                       } 
                    }
                }
                 
                 if(!empty($attr)){
                         
                       foreach($attr as $k4=>$v4 ){
                           $product = $product ->where(
                              function($query) use ($k4,$v4) {
                                       $Values= explode("-",$v4);
                                        foreach($Values as $v5 ){
                                             $query->orWhere('attr','like','%"'.e($k4).'": "'.e($v5).'"%')  
                                                   ->orWhere('attr->specification->'.e($k4),'like','%"'.e($v5).'"%')
                                                   ->orWhere('attr->variation->'.e($k4),'like','%"'.e($v5).'"%');
                                            }
                                    return $query;             
                                }); 
                            }   
                         } 
               
               if(!empty($GetData['pricemin']))
                  $product->Where('price', '>=', floatval(e($GetData['pricemin'])));
               
               if(!empty($GetData['pricemax']))
                  $product->Where('price', '<=', floatval(e($GetData['pricemax'])));
                  
               $price_sort = @session('priceSort');
               if(!empty($price_sort) && ($price_sort == 'asc' || $price_sort == 'desc')){
                $product= $product->orderBy('price',  e($price_sort ?? ''));
               }
                
           return $product;
        }
   

  /**
     * this funtion will prepare the the data for the variations or specifications,
     * this is when costomers chose from the left or right sidebar an options for sorting
     */
 public static function variationUrl($values=[], $k=''){
     $li = ''; 
     $getData  =  \Input::all()?? '';
     $arrayValues = isset($getData[$k]) ? explode("-", (string)$getData[$k]): [];
    
     foreach($values as $k2=>$v2){
        $array='';
        $newArray = $arrayValues;
        if (($key = array_search($k2, $arrayValues)) !== false) {
                unset($newArray[$key]);
                $array= explode("-",$newArray);
            }else{
                $array = !empty($getData[$k])? $getData[$k]."-".$k2 : $k2; 
            }
            
       $newArray=$getData;
       $newArray[$k] = $array;
       $newArray = array_filter($newArray, 'strlen');
         
       array_walk($newArray, create_function('&$i,$k','$i="&$k=$i";'));
       $url = implode($newArray,"");
       $url = substr($url, 0, 1) == 0 ? substr($url, 1) : $url;
     
     $li .= '<label> <input type="checkbox"'. (in_array((string)$k2, $arrayValues) ? ' checked="" ':'').' 
                     value="" onclick="window.location.href=\'?'.$url.'\'"/> '.$v2.'</label> ';
    }
    
    return $li;
 }  



 /**
 *   Will return the random product from the same category like related products
 *    use:  {!! \Wh::relatedProducts($product->id, $product->cat) !!} 
 */ 
   
   public static function relatedProducts($productID=0, $productCat=0){
     
      $json =  is_numeric($productCat) ? $productCat : @json_decode($productCat,true);
      $json = is_array($json) ? $json[0] : $json;
    
      $products = Product::join_query()
                                  ->whereJsonContains('cat', [$json])
                                  ->where('id', '!=' , $productID)
                                  ->inRandomOrder()
                                  ->paginate(10);
     
     $data = '';
     if(!empty($products)){                            
     $template= view()->exists('theme::layouts.product') ? 'theme::layouts.product' : 'standart.product.product';                            
      
        foreach ($products as $product){
          $data .=  view($template,['product'=>$product,"fullIMG"=>'set']) ;
        }                            
       $data .= '';
     }  
    return $data;
   }

 

/**
 * will show the right css all depends in what you set in General Settings -> Development Mode
 * 
 */
 
 
public static function showCss(){
        $css = _CSSSTYELE_;
        $get_settin = _MAIN_OPTIONS_;
         
        foreach($css as $kcss => $vcss){ 
          if(!empty($get_settin['_developmentMode_'])){
             echo '<link href="'.url($vcss).'" rel="stylesheet"/>';
           }else{
             $file =  @str_replace( ".css" , ".blade.php" ,@$vcss);
             
             echo '<style type="text/css">
                         <!-- ';
             echo   @require base_path(@$file);
             echo '  -->
                        </style>';
          }  
        }
 }
 
 public static function jsonFirstVal($data=''){
     if(!\Wh::isJSON($data))
             return $data;
      
    $val = @json_decode($data, true);
    $value = @reset($val);
    return @$value;
 }
 
 
 /**
  * This will strip_tags an array with 3 lavels
  */
 public static function stripTags($val=""){
  
 return  is_array($val)? array_map(function($v){
                          return Self::stripTags(Self::stripTags($v));
                         }, $val) : trim(strip_tags($val));

 }
 
/**
 * When you want to save something and need to show an message use this public static function and in your
 * controller set the sesion like 
 * session(['status' => _l('Success Saved')]);or
 * session(['status' =>  '<b style="color:red;">Here are some errors with the data</b>' ]);
 */
public static function sucessSavedMsg(){
    $msg='';
     if (session('status')) {
      $msg=' <div class="col-md-12">
              <div class="allertSuccess">
                  '.session('status').'
              </div>  
            </div>';
     session(['status' => '']); 
      }
    
    return $msg;
}

 /**
  * Get child categories if child is empty than show the main categories list
  */
 public static function getCatChild(){
     $catStructure = _CATEGORIES_STRUCTURE_;
     $mainID = @\Config::get('maincatID'); 
     $currentID = @\Config::get('catID');
     
     $mainCPU = @$catStructure[$mainID]['cpu']; 
     $current_cpu = @$catStructure[$currentID]['cpu'];
    
     $child = array_where($catStructure, function($value, $key) use($mainCPU) {
        $explodeCpu = explode('/',  $value['cpufull']);
        return count($explodeCpu)>1 && in_array($mainCPU, $explodeCpu);
      });
    
        // if child is empty than show all the main categories
        $child = empty($child) ?  array_where($catStructure, function($value, $key) {
                                        $explodeCpu = explode('/',  $value['cpufull']);
                                        return !\Wh::instring('/',$value['cpufull']) && $value['type'] =='product' ;
                                     }) : $child;
      
     $li = '';
     foreach ($child as $k => $v){
        $current = $current_cpu  == @$v['cpu'] ? " class='activeCat'":''; 
        $li .= '<li'.$current.'><a href="'.url("/cat/".$v['cpufull']).'">'.$v['title'].'</a>';
        $cp = @$v['cpu'];
        $child2 = array_where($catStructure, function($value, $key) use($cp) {
                $explodeCpu = explode('/',  $value['cpufull']);
                return count($explodeCpu)>1 && in_array($cp, $explodeCpu)   ;
            });
            
          if(!empty($child2)){
           $li .='<ul>'; 
             foreach ($child2 as $k2 => $v2){
                $current2 = $current_cpu  == @$v2['cpu'] ? " class='activeCat'":''; 
                '<li'.$current2.'><a href="'.url("/cat/".$v2['cpufull']).'">'.$v2['title'].'</a></li>'; 
             }
           $li .='</ul>';  
          }
        $li .='</li>';    
      }
      
      
   return $li;
 }
 
 
  
 /**
  * Link to quick edit 
  * url -  is the linkt to admin panel
  * \Wh::quickEdit('/admin/page/add-edit/pages/20')
  */
 public static function quickEdit($url='',$classFix='editPageLink'){
     if(\Wh::currentRole("admin")){
       return ' <a href="'.url($url).'" class="'.$classFix.'" onclick="return \Wh::quickEdit(this);"><i class="fa fa-pencil"></i></a>';
     }
 }
 
 /**
  * Balances tags of string using a modified stack.
  */
 public static function force_balance_tags( $text ) {
    $tagstack = array();
    $stacksize = 0;
    $tagqueue = '';
    $newtext = '';
    // Known single-entity/self-closing tags
    $single_tags = array( 'area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source' );
    // Tags that can be immediately nested within themselves
    $nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );
 
    // WP bug fix for comments - in case you REALLY meant to type '< !--'
    $text = str_replace('< !--', '<    !--', $text);
    // WP bug fix for LOVE <3 (and other situations with '<' before a number)
    $text = preg_replace('#<([0-9]{1})#', '&lt;$1', $text);
 
    while ( preg_match("/<(\/?[\w:]*)\s*([^>]*)>/", $text, $regex) ) {
        $newtext .= $tagqueue;
 
        $i = strpos($text, $regex[0]);
        $l = strlen($regex[0]);
 
        // clear the shifter
        $tagqueue = '';
        // Pop or Push
        if ( isset($regex[1][0]) && '/' == $regex[1][0] ) { // End Tag
            $tag = strtolower(substr($regex[1],1));
            // if too many closing tags
            if ( $stacksize <= 0 ) {
                $tag = '';
                // or close to be safe $tag = '/' . $tag;
            }
            // if stacktop value = tag close value then pop
            elseif ( $tagstack[$stacksize - 1] == $tag ) { // found closing tag
                $tag = '</' . $tag . '>'; // Close Tag
                // Pop
                array_pop( $tagstack );
                $stacksize--;
            } else { // closing tag not at top, search for it
                for ( $j = $stacksize-1; $j >= 0; $j-- ) {
                    if ( $tagstack[$j] == $tag ) {
                    // add tag to tagqueue
                        for ( $k = $stacksize-1; $k >= $j; $k--) {
                            $tagqueue .= '</' . array_pop( $tagstack ) . '>';
                            $stacksize--;
                        }
                        break;
                    }
                }
                $tag = '';
            }
        } else { // Begin Tag
            $tag = strtolower($regex[1]);
 
            // Tag Cleaning
 
            // If it's an empty tag "< >", do nothing
            if ( '' == $tag ) {
                // do nothing
            }
            // ElseIf it presents itself as a self-closing tag...
            elseif ( substr( $regex[2], -1 ) == '/' ) {
                // ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such and
                // immediately close it with a closing tag (the tag will encapsulate no text as a result)
                if ( ! in_array( $tag, $single_tags ) )
                    $regex[2] = trim( substr( $regex[2], 0, -1 ) ) . "></$tag";
            }
            // ElseIf it's a known single-entity tag but it doesn't close itself, do so
            elseif ( in_array($tag, $single_tags) ) {
                $regex[2] .= '/';
            }
            // Else it's not a single-entity tag
            else {
                // If the top of the stack is the same as the tag we want to push, close previous tag
                if ( $stacksize > 0 && !in_array($tag, $nestable_tags) && $tagstack[$stacksize - 1] == $tag ) {
                    $tagqueue = '</' . array_pop( $tagstack ) . '>';
                    $stacksize--;
                }
                $stacksize = array_push( $tagstack, $tag );
            }
 
            // Attributes
            $attributes = $regex[2];
            if ( ! empty( $attributes ) && $attributes[0] != '>' )
                $attributes = ' ' . $attributes;
 
            $tag = '<' . $tag . $attributes . '>';
            //If already queuing a close tag, then put this tag on, too
            if ( !empty($tagqueue) ) {
                $tagqueue .= $tag;
                $tag = '';
            }
        }
        $newtext .= substr($text, 0, $i) . $tag;
        $text = substr($text, $i + $l);
    }
 
    // Clear Tag Queue
    $newtext .= $tagqueue;
 
    // Add Remaining text
    $newtext .= $text;
 
    // Empty Stack
    while( $x = array_pop($tagstack) )
        $newtext .= '</' . $x . '>'; // Add remaining tags to close
 
    // WP fix for the bug with HTML comments
    $newtext = str_replace("< !--","<!--",$newtext);
    $newtext = str_replace("<    !--","< !--",$newtext);
 
    return $newtext;
}
 
/**
 * This public static function show the first 300 words from text
 */
public static function excerpt($contetnt='',$limit=300) {
    $contetnt = @strip_tags($contetnt,'<p>');
  $excerpt = explode(' ', $contetnt, $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return \Wh::force_balance_tags( $excerpt);
}
/**
  * Return the right routes
  */ 
public static function sort_root($array=[]){
    foreach($array as $k=>$get){
        $is= is_array($get)? $get[0] : "get";
        $val= is_array($get)? $get[1] : $get;
        $return = "";
        
      if(isset($get['where'])){
          \Route::$is($k, $val)->where($get['where'][0],$get['where'][1]); 
      }elseif(isset($get['name'])){
          \Route::$is($k, $val)->name($get['name']);
        }else{
          \Route::$is($k, $val);
        }  
     } 
 }

/**
 * Check if is in array
 */
 
 public static function check_arra($arr="", $key="", $value=""){
    $is = "";
    $first = "";
    foreach($arr as $k=>$v){
         if(empty($first)){
            $first = $k;
         }
        if(!empty($v[$key])) { 
              $is = $k; 
               break;
           } 
    }
    
    
    return !empty($is)? $is : $first; 
 }
 
 /**
  * 
  */
  
  public static function check_col($text=""){
       return strpos(@$text, 'col-md') !== false? $text :
                                 '<div class="col-md-12 inside_grid" id="id'.rand(999999,100000).'">'.$text.'</div>';
  }
  
  /**
  * This public static function will return Blcok like Footer header
  */
  
  public static function editableBlocks($conent='',$return = 'content'){
         $val = @explode("~~~~~",@$conent);
          $page = @$val[1];
          return $return == 'content' ? \Wh::shortCode($page) : view("standart.default.header-css",['optionsData'=>@$val[0]]);
  }


  
/**
   * Oance used helper maybe will need for future, for that i keep it
   */  
  public static function remove_dublicate($lang=""){
    $contetn = file_get_contents(base_path("/language/".$lang.".json"));
    $json= json_decode($contetn, true );
     
    $vfinal = [];
    $finalend=[];
    foreach($json as $k=>$v){
        if(!isset($vfinal[trim(strtolower($k))])){
            $vfinal[trim(strtolower($k))] = $v ; 
         }
     }
     
     \File::put(base_path() . '/language/'.$lang.'.json', json_encode($vfinal, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
     printw($vfinal); 
 }
  //remove_dublicate('de'); 
  //exit();
 
public static function firstLetterUpercase($word ='', $original= ''){
    $firstLetter = mb_substr(trim($original),0,1, 'UTF-8');
    if(preg_match('/[A-Z]$/',$firstLetter)==true) {
    
        $first = mb_substr($word,0,1, 'UTF-8'); 
        $last = mb_substr($word,1); 
        $first = mb_strtoupper($first, 'UTF-8');
        $last = mb_strtolower($last, 'UTF-8');
        return $first.$last;
    }else{
        return $word;
    }
}
 
 

/**
 * Get shipping cost
 * id - shipping id
 * $total - cart total; it will calculate the shipping from total
 */

public static function get_shipping_cost($id, $total=0) {
   $shipping = \DB::table('shiping')->where('id', $id)->first();
   $price = @\Wh::check_price($shipping->price);
   $cost= $shipping->type_shipping == 3 ? ($total * $price)/100 :
                                                $price;
    $free = @floatval($shipping->free_delivery);                                            
  $cost=  $free <= $total && $free > 0 ? 0 : $cost;                                              
   
   return round($cost,2);
 }
/**
 * generate link by page id
 * $id - page id
 */
 
 public static function get_link_page($id=0){
    $row=\DB::table('page')->whereid($id)->select("cpu","title")->first();
    
    return !empty($row) ? '<a href="'.url('/page/'.$row->cpu).'">'.$row->title.'</a>':'';
 }
  
 /**
 * Get shipping cost
 * $id- Shipping id 
 * $field - field; like title or cost
 */

public static function get_shipping_field($id, $field='') {
   $shipping = \DB::table('shiping')->where('id', $id)->select($field)->first();
   return $shipping->$field ;
 }
  
  
 /**
   * Will return the image full path 
   * $image - it's aimage from options or just image name
   * $type - thumb or big (full size)
   */ 
  public static function get_thumbnail($image="", $type=""){
    if(\Wh::isJSON($image)){
      $image_json = json_decode($image,true); 
      $image =@$image_json['image'];
    }
     if(strpos($image, '://') !== false){
        return $image;
     }
     $thumb = $type == "big" ? "": "thumb_"; 
     if(strpos($image, '/') === false){
        return url("/public/imgproduct/".$thumb.$image);
     }
     
    $img = end(explode("/",$image));
    
    return url("/public/imgproduct/".str_replace($img, $thumb.$img, $image));
  }
   
   /**
   * Will return the image full path 
   * $image - it's aimage from options or just image name
   * $type - thumb or big (full size)
   */ 
  public static function getThumbGallery($image="", $type=""){
    if(empty($image))
         return url('/public/img/thumb_noimage.jpg'); 
    
    if(\Wh::isJSON($image))
      $image = \Wh::jsonFirstVal($image,true); 
    
     if(strpos($image, '://') !== false) 
        return $image;
      
       
     $thumb = $type == "big" ? "": "thumb_"; 
     
     
     if(strpos($image, '/') === false)
        return url("/public/imgproduct/".$thumb.$image);
     
     
     $img = end(explode("/",$image));
    
    return url("/public/imgproduct/".str_replace($img, $thumb.$img, $image));
  }
  
/**
  * Get product gallery
  * $idp - id Product
  */ 
public static function get_images($idp) {
  $img = \DB::table('gallery')->where('id_post', $idp)->first();
  $arry= @json_decode(@$img->directory, true);
  return !empty($arry) ? $arry:[];
 }
  
/**
 * Get gallery of the product for admin 
 */
 public static function get_admin_gallery($idp){
   $imgs = \DB::table('gallery')
              ->where('id_post', $idp)
              ->first();
       $return = ""; 
        if(empty($imgs)) return ''; 
        $all_images = json_decode($imgs->directory,true);
        
     foreach ($all_images as $k=>$img){ 
      $return .= '<div class="gallery_product">'.
                  '<a class="delete_image" href="#" onclick="access_url(\''.\URL::to('/').'/admin/remove-image/'.$imgs->id.'/'.$k.'\',\'.show_result_gallery\', \'.response_gallery\',\'none\');return false;">x</a>'.
                  '<a href="#"><img src=\''.@\Wh::get_thumbnail($img).'\'></a>'.  
               '</div>';
     }
     $return  .= "<div class='clear'></div>";
     return $return;     
}

/**
 * return main image for admin
 */

  public static function return_main_image($img=[]){
            
            $return1= '<input type="hidden" name="image_main" id="input_img" value="'.$img.'" />'; 
            $return  = '
                  <div class="gallery_product" id="main_img">
                     <a class="delete_image" href="#" onclick="remove_main_image(\'#main_img\',\'#input_img\');return false;">x</a>
                     <a href="#">
                       <img src="'.@\Wh::get_thumbnail($img).'"  />
                     </a>
                 </div>
                 <div class="clear"></div>
                 ';
             return !empty($img)?  $return1.$return : $return1; 
    }
    
/**
 * Get gallery of the product for admin 
 */
 public static function  get_admin_files($idp, $foreach=""){
   $files = \DB::table('uploads')
          ->where('id_post', $idp)
          ->orderBy('id', 'asc')
          ->get();
     
     if(!empty($foreach)){
        return  $files;
     }     
          
       $return = ""; 
        
     foreach ($files as $file){ 
        
     $return .= '<div class="col-md-5">'
                      .$file->file_title.  
               '</div>
                <div class="col-md-5">
                  <a href="'.url("/admin/product/upload").'/'.$file->id.'">'.$file->originalFileName.'</a> 
                </div>
                <div class="col-md-2">
                <a class="fa_delete" href="#" onclick="access_url(\''.\URL::to('/').'/admin/product/remove-file/'.$file->id.'\',\'.listOfFiles\', \'.load_iacon\',\'none\');return false;"></a>
                </div>
                <div class="height10px"></div>
               '
             ;
      }
     $return  .= "<div class='clear'></div>";
   
   return $return;     
}



 /**
  *  return categories in array
  */
 
   public static function show_array(){
           $get_id =\DB::table('categories')->select('cpu','id','parent')->get();
           $data2=[];
            foreach ($get_id as $v){
              $data2[$v->id]= ['cpu'=>$v->cpu,'parent'=>$v->parent] ;
            }
      return $data2 ;     
    } 
 

/**
 * generate product URL
 */

public static function get_product_cpu($id="",$admin=""){
   return !empty($admin) ?  \URL::to('/')."/admin/product/".$id : "";
 }


/**
 * Will get any field from product table
 * id-id product
 * $field - title or price any field
 */
public static function get_product_field($id="",$field="title"){
    $product= \DB::table('product')
                ->where('id',$id)
                ->select($field)->first();
    return @$product->$field;
}
  
/**
 *  Will get all the Comments(Reviews) for the post or product
 * $id_post - product id 
 */
public static function get_comments($id_post = 0){
    $comments = \DB::table('comments')
                       ->where('status','=',2)
                       ->where('id_post', $id_post)
                       ->get();
    return $comments;
}

/**
 * Will return the number of commnets in array 
 * for eaxample [5=>10, 4=>2, 3=>1, 2=>7, 1=> 5]
 * where array key is stars number and value is the number of comments with key stars
 */
public static function nr_comments($commnets=[]){
     $total = [];
      foreach ($commnets as $commnet){
        if(isset($total[$commnet->stars])){
            $total[$commnet->stars] = $total[$commnet->stars] +1;
        }else{
           $total[$commnet->stars] = 1; 
        }
      }
  return $total;
}

/*
Get medium Overall all comments
*/
public static function comments_Overall($commnets=[]){
    $media=0;
    $nr_coments = 0;
    
     $array_commnts = @nr_comments($commnets);
    
     foreach ($array_commnts  as $k_s=>$v_s){
       $media= $media +  ($k_s *$v_s );
       $nr_coments= $nr_coments + $v_s;
     }
  return  @round($media / $nr_coments , 1) ;
}


/*
  Return the Medium Stars by product id
  $id_post- product id
*/
public static function product_stars($id_post=0){
    $media=0;
    $nr_coments = 0;
    
     $comments = \DB::table('comments')
                       ->where('status','=',2)
                       ->where('id_post', $id_post)
                       ->select('stars')                       
                       ->get();
                 
   $media = count($comments)>0 ? \Wh::comments_Overall(@$comments):0;
   
 return count($comments)>0 ? '<span class="stars'.round($media).'"></span>':"";
}

/**
 * Will return the number of commnets in array 
 * for eaxample [5=>10, 4=>2, 3=>1, 2=>7, 1=> 5]
 * where array key is stars number and value is the number of comments with key stars
 */
public static function comments_count($status){
     $comments = \DB::table('comments')
                       ->where('status','=',2)
                       ->where('id_post', $id_post)
                       ->get();
    return $comments;
}
 
 /**
  * Will return true or false if the string is a json 
  */
 public static function isJSON($string=''){
   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}
 
 /**
  * Get products from cart
  */
public static function subTotal($v=""){
            $options = @json_decode($v->attr);
            $quantity = !empty($v->optid) ? @$options->variation[$v->options_id]->qtu : $v->qtu; 
            $subtotal =0;
          if($quantity > 0){
              $get_price= @\Wh::get_price_number($v->pr_price, $v->sale_price, @$options->variation[$v->options_id]->price);
              $total=round($get_price * $v->qty , 2);
              $subtotal = round($subtotal + $total, 2);
          }
       
       return $subtotal ;  
  }

/**
 * check if variation exist
 */
 
public static function check_opt($variation=''){
         $v=json_decode($variation,true);
                  
 return !empty($v['variation']) ? true : false;
}

/**
 * Get Shipping
 */

public static function get_shipping($id=0, $kg=0, $total= 0){
  $order= \DB::table('shiping')
              ->where(function($query) use ($id) {
                  $query->where('country', $id)
                        ->orWhere('country','=',0);
              });
              if(!empty($kg)){
              $order = $order->where(function($query) use ($kg) {
                          $query->where('weight', '>=', $kg)
                                    ->orWhere('weight','=',0);
                          });
              }
              //->where('weight', '>=', $kg)
              $order = $order->where('hide_show','!=','3')
                      ->orderBy('price', 'asc')
                      ->get();
              
        $result="";
        $checkarray=[];
        $i=0;
        $cost=[];
        //printw($order) ; return '';
        if(count($order)>0){
             
            foreach($order as $v){
             if(!in_array(strtolower(trim(@$v->shipping_name)), $checkarray) ){ 
                 $i++;
                 $free= @floatval($v->free_delivery);
                 
                $cost= $v->type_shipping ==3 ? round(($total * $v->price)/100, 2) : \Wh::check_price($v->price, 'none');
                $cost=  @$free <= $total && $free > 0 ? 0 : $cost; 
                                              
                $price_shipping = $cost > 0 ? \Wh::get_price_full($cost, 0, 'not')   : _l("FREE");
                
                $total_price = $cost + $total;
                
                $result .= '<li> '
                             .'<label>'
                                   . '<input type="radio" autocomplete="off" onclick="shipping_calculate(\''.\Wh::get_price_full($cost,0,'not').'\', \''.\Wh::get_price_full($total_price,0,'not').'\');" value="'.$v->id.'" name="deliverymethod" class="cl_deliverymethod" > '
                                   . $v->shipping_name. ' '
                             .'</label><span> '.$price_shipping.'</span></li>';
             }
             $checkarray[] = strtolower(trim($v->shipping_name));
         }
        }
      
      return count($order)>0 ? $result: "" ;
             
}

public static function check_shipping(){
    $order= \DB::table('shiping')
                  ->where('hide_show','!=','3')
                  ->select('id')
                  ->count();
    return $order>0? true : false ;
}

 

public static function return_js($array=[], $data=[], $form="#checkoutform"){
    $js2="";

    foreach ($array as $check ){
        if(empty($data[$check])){
            $type="$form input[name='$check'] , $form select[name='$check'], $form textarea[name='$check']";
            $js2 .= ' $("'.$type.'").css({"outline":"1px solid red", "box-shadow":"0px 0px 4px red","-moz-box-shadow":"0px 0px 4px red","-webkit-box-shadow":"0px 0px 4px red" });  ';
       }
     }
return $js2;
}
/**
 * Get list of countries
 */
public static function list_countries_db($id="",$field=""){
        $country = !empty($id)? \DB::table('shippcountry')->find($id) : \DB::table('shippcountry')->get();
        return !empty($id)? $country->$field : $country ;
}
/**
 * Get country by code
 */
public static function get_countrybycode($code, $field) {
  $country_cost = \DB::table('shippcountry')->where('code', $code)->first();
  return  $country_cost->$field;
 }

/**
 * Get country field by id
 * id- id country
 * field - any field
 */
 public static function get_countrybyid($id, $field) {
  $country_cost = !empty($id)? \DB::table('shippcountry')->find($id) : [];
  return !empty($country_cost)? $country_cost->$field : '';
 }
 
 /**
  * Get category by title,
  * if title category with this title not exist than insert it
  * may need when import 
  * return category id 
  */
 
public static function get_catbytitle($title=0){
   $categories = \DB::table('categories')
                       ->where('title', 'like', '%'.$title.'%')
                       ->first();
   if(empty($categories)){
        $id = \DB::table('categories')->insertGetId( [ 
              'title' => $title,
              'metad' => $title,
              'metak' => $title,
              'cpu' => str_slug($title)   
              ]);
        //echo $id;
   }
    return empty($categories)? $id : $categories->id;
}


/**
  * Get category by field,
  *  return category field
  * $field = cpu
  * $where = id (field name)
  * $equal = 2 (any value)
  * it will be: get 'cpu' where 'id' = '2' select 'cpu'
  *  \Wh::get_catbyfield($field, $where, $equal
  */
public static function get_catbyfield($field, $where, $equal){
   $categories = \DB::table('categories')
                       ->where($where,$equal)
                       ->select($field)
                       ->first();
    return $categories->$field;
}
/**
  * Get categores by list,
  *  return categories list in array
  *  you have tu use in foreach
  */

public static function catList($parent=0, $admin="" ){
        
   $categories = !empty($parent) && $parent == "cat" ?  \DB::table('categories') : \DB::table('categories')-> where('parent','=',$parent) ;
        
  if(empty($admin)){ 
    $categories = $categories -> where('tip','!=',2); 
  }            
 return $categories->get();
}


public static function getAllCategories_all($type=""){
   return !empty($type) ?  
            \DB::table('categories')->where('type', $type)->orderBy("id","asc")->get():
            \DB::table('categories')->orderBy("id","asc")->get();  
}
 
 
public static function get_cat_yerahical($cat=[], $parent="", $nr= 0, $type=""){
    $return ="";
    $split=" <span style='margin-left:".$nr."px;'>></span> ";
     $nr= $nr + 15;
    $split = $parent==0? "": $split; 
    foreach($cat as $maincat){
       if($maincat->parent==$parent){
            $return .=view('admin.layouts.categoryleft', compact("maincat","split","type")); 
            $return .= \Wh::get_cat_yerahical($cat, $maincat->id, $nr, $type);
       }  
    }
  return $return;  
} 

/**
 * will return the category for select
 * $cat - categories array
 * $parrent - if you want to be selected
 */
public static function get_cat_yerahical_option($cat=[], $parent="", $nr= 0, $url="", $is_in=''){
     $return ="";
     $split="";
     for($i=1;$i<=$nr;$i++){
       $split .= "&nbsp;"; 
     }
      $nr= $nr + 2;
     //$split = $parent==0? "": $split; 
     foreach($cat as $maincat){
       if($maincat->parent==$parent){
             $id_or_url=  strpos($url, 'admin') !== false ? $maincat->id : 
                                                            \Wh::generate_cat_url($maincat->id);
                                                            
             $val= !empty($url) ? $url."/".$id_or_url : $maincat->id;
             
              
            $selected = @$maincat->id == $is_in? 'selected=""': "";
            $return .='<option value="'.$val.'" '.$selected.'> '.$split.$maincat->title.'</option>'; 
            $return .= \Wh::get_cat_yerahical_option($cat, $maincat->id, $nr, $url, $is_in);
       }  
     }
  return $return;  
} 

/**
 * will return the category in checkbox list
 * $cat - categories array
 * $parrent - if you want to be checked
 */

public static function get_cat_yerahical_checkbox($cat=[], $parent="", $nr= 0, $isin=[]){
     $return ="";
      $nr= $parent == 0 ? 0 : $nr + 7;
      
     foreach($cat as $maincat){
       if($maincat->parent==$parent){
          $if_class = @in_array($maincat->id, $isin) ? " anchor_scroll" : "";
          $if_check = @in_array($maincat->id, $isin) ? "checked=''" : "";
          
            $return .='
                    <label class="product_cat_single'.$if_class.'">
                      <input style="margin-left:'.$nr.'px;" name="cat[]" '.$if_check.' type="checkbox" value="'.$maincat->id.'"> '.$maincat->title.' 
                    </label>  '; 
            $return .= \Wh::get_cat_yerahical_checkbox($cat, $maincat->id, $nr, $isin);
       }  
     }
  return $return;  
} 
 
 /**
  * this public static function is necesary to mimify the calls to database
  * it will generate for each category or subcategory the URL, so use it when call product
  * 
  */
 public static function get_cat_yerahical_array($cat=[]){
     $return = [];
      
     foreach($cat as $maincat){
       if($maincat->parent== 0){
          $return [$maincat->id] =  ["cpufull"=>$maincat->cpu, 
                                     "cpu"=>$maincat->cpu, 
                                     "title"=>$maincat->title,
                                     "type"=>$maincat->type
                                     ];
           
          foreach($cat as $maincat2){
                if($maincat2->parent== $maincat->id){
                     $return [$maincat2->id] =  
                                     ["cpufull"=>$return[$maincat2->parent]["cpufull"]."/".$maincat2->cpu, 
                                     "cpu"=>$maincat2->cpu, 
                                     "title"=>$maincat2->title,
                                     "type"=>$maincat2->type
                                     ];
                     
                     //$return [$maincat2->parent]."/".$maincat2->cpu;
                      
                    foreach($cat as $maincat3){
                      if($maincat3->parent== $maincat2->id){
                             $return [$maincat3->id] =  
                                     ["cpufull"=>$return[$maincat3->parent]["cpufull"]."/".$maincat3->cpu, 
                                     "cpu"=>$maincat3->cpu, 
                                     "title"=>$maincat3->title,
                                     "type"=>$maincat3->type
                                     ];
                        
                              //$return [$maincat3->id] =   $return [$maincat3->parent]."/".$maincat3->cpu;
                             
                                foreach($cat as $maincat4){
                                  if($maincat4->parent== $maincat3->id){
                                          //$return [$maincat4->id] =   $return [$maincat4->parent]."/".$maincat4->cpu;
                                           $return [$maincat4->id] =  
                                                 ["cpufull"=>$return[$maincat4->parent]["cpufull"]."/".$maincat4->cpu, 
                                                 "cpu"=>$maincat4->cpu, 
                                                 "title"=>$maincat4->title,
                                                 "type"=>$maincat4->type
                                                 ];
                                         
                                           foreach($cat as $maincat5){
                                                  if($maincat5->parent== $maincat3->id){
                                                          //$return [$maincat5->id] =   $return [$maincat5->parent]."/".$maincat5->cpu;
                                                           $return [$maincat5->id] =  
                                                                 ["cpufull"=>$return[$maincat5->parent]["cpufull"]."/".$maincat5->cpu, 
                                                                 "cpu"=>$maincat5->cpu, 
                                                                 "title"=>$maincat5->title,
                                                                 "type"=>$maincat5->type
                                                                 ];
                                                          
                                                         }  
                                                   }
                                         }  
                                   }
                             }  
                       } 
                }  
            }
            
        }  
     }
      
  return @json_encode($return, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);  
}
 
/**
* all the time forget strpos so i renamed it like instring is easy to remember, right? 
* any one know what instring mean 
*/  
public static function instring($word="", $string=""){
    if( strpos( $string, $word ) !== false) {
        return true; 
    }
    return false; 
}   
   
 /**
 * when get response from array_where it return the full array
 * so we need to get the first key of array what public static functions bellow do 
 * return the first key of array
 * for example 
 * [ 3 =>["main", 34, 25 ] ]
 * it will return the number 3
 */   
public static function getKey_array_where($array=[]){
     @reset($array);
     return @key($array);
}    
   
/**
 * here we return the cat id by cpu and setup the config variable "catID" and "maincatID" with the right ID
 * 
 */    
public static function getCatParent($cpu='', $ret=''){
    $catStructure = _CATEGORIES_STRUCTURE_;
    $mainid= 0;
     
    $idCat = \Arr::where($catStructure, function($value, $key) use ($cpu )  {
        if($value['cpu'] == $cpu){
            \Config::set('catID', $key);
         } 
        return $value['cpu'] == $cpu && ($value['type']=="product" || $value['type']=='brand'); 
     });
    
     $idCat = @\Wh::getKey_array_where($idCat);
    
      if(\Wh::instring("/", @$catStructure[$idCat]['cpufull'])){  
          $cpuMain = @head(explode("/", $catStructure[$idCat]['cpufull']));
          
          $idMainCat = \Arr::where($catStructure, function($value, $key) use ($cpuMain )  {
            if($value['cpu'] == $cpuMain){
                \Config::set('maincatID', $key);
             } 
            return $value['cpu'] == $cpuMain; 
           });
           
            $idMainCat =\Wh::getKey_array_where($idMainCat);
        }else{
            \Config::set('maincatID', $idCat);
            $idMainCat = $idCat;
        } 
        
   return empty($ret)? $idCat : compact('idCat', 'idMainCat');
}     

    
public static function generate_cat_url($cat_id=""){
    $arr=@_CATEGORIES_STRUCTURE_;
     $json = @\Wh::isJSON($cat_id)? @json_decode($cat_id,true) : [$cat_id];
    
     $config_cat_id =  \Config::get('catID' );
     
    return !empty($config_cat_id) ? @$arr[$config_cat_id]['cpufull'] :  @$arr[@$json[0]]['cpufull'];
}    
/**
* Will return the full product url
* $cpu- product cpu 
* $cat - is a product json 
*/        
 public static function product_url($cpu="",$cat=""){
   return \URL::to('/')."/product/".\Wh::generate_cat_url($cat)."/".$cpu;
 }  

/**
* Will return the Breadcrumbs of product
* $row - product array
*/        
 public static function productBreadcrumbs($row=[]){
    return \Wh::breadcrumbs(); 
 } 
 
 /**
  * This public static function will create a breadcrumbs based on config variable what you set up on your controler
  */
 public static function breadcrumbs(){
     $arr=@_CATEGORIES_STRUCTURE_;
     $catid= @\Config::get('catID');
     $productTitle = @\Config::get('productTitle');
     $page= @\Config::get('page');
     $pageTitle= @\Config::get('pageTitle');
     $search= @\Config::get('search');
     $fullUrl = '<ul class="breadcrumbNav">
                <li><a href="'.url("/").'">'._l('Home').'</a></li>';
     
    if(!empty($catid)){   
     $cpuFull = @$arr[@$catid]['cpufull'];
     $explode = explode("/",$cpuFull);           
     foreach($arr as $k=>$v ){
       $fullUrl .= in_array($v['cpu'], $explode) ? '<li><span>/</span> <a href="'.url("/cat/".$v['cpufull']).'">'.$v['title'].'</a></li>' : '';
     }
     } 
     if(!empty($productTitle)){
       $fullUrl .=  '<li><span>/</span> <a href="#">'.@$productTitle.'</a></li>';
     }
     if($page == 'page'){
       $fullUrl .=  '<li><span>/</span> <a href="#">'.@$pageTitle.'</a></li>';
     }
     if($page == 'search'){
        $fullUrl .=  '<li><span>/</span> <a href="'.url('/shop').'">'.@_l('Shop').'</a></li>';
        $fullUrl .=  '<li><span>/</span> <a href="'.url('/search/products').'?s='.@$search.'">'.@_l('Search').'</a></li>';
       $fullUrl .=  '<li><span>/</span> <a href="'.url('/search/products').'?s='.@$search.'">'.@$search.'</a></li>';
     }
     if($page == 'cart'){
       $fullUrl .=  '<li><span>/</span> <a href="'.url('/steps/cart').'">'. _l('Cart').'</a></li>';
     }
     if($page == 'checkout'){
       $fullUrl .=  '<li><span>/</span> <a href="'.url('/steps/checkout').'">'. _l('Checkout').'</a></li>';
     }
     
     $fullUrl .= '</ul>';
     
    return @$page == 'home' ? '': $fullUrl; 
 } 



public static function catChildsId($catID){
            $catStructure = @_CATEGORIES_STRUCTURE_;
            $arr=[$catID];
            $cpu = $catStructure[$catID]['cpu'];
            foreach($catStructure as $k=>$cat){
               $explod = explode("/",$cat['cpufull']); 
               if(in_array($cpu,$explod) && $cat['cpu'] != $cpu && ($cat['type']=='product' || $cat['type']=='brand')){
                  $arr[]=$k;
                }
            }
            return $arr;  
 }
   
public static function get_categoryarr($query){
    foreach ($query as $child1){
       $arr[]= $child1->id; 
        foreach ( catList($child1->id) as $child2){
           $arr[]= $child2->id; 
        }
    }
   return $arr; 
}
 /**
  * Will generate a randon string
  * $n- length 
  * $only_letters - only letter not numbers
  */
public static function get_random($n, $only_letters = ""){
  $arr = !empty($only_letters)?
                      array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z','A','B','C','D','E','F', 'G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z') 
                      : 
                      array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z','A','B','C','D','E','F', 'G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0');
   $new = "";
    for($i = 0; $i <$n; $i++){
        $index = rand(0, count($arr) - 1);
        $new.= $arr[$index];
    }
    return $new;
}
 
 
public static function url_s(){
  return str_replace(["http://", "https://"], ["",""], url('/'));
}

 

/**
  * get current user ID if is login
  */
public static function id_user($id="") {
  $idc = empty($id) ? 0 : 9999999987;   
  return \Auth::check() ?  \Auth::id() : $idc;
} 
  

/**
  * get user role by id role
  * id- role id
  */
public static function get_role($id){
  $role = \DB::table('role')
                       ->where("id",$id)
                       ->select("role_name")
                       ->first();
    return $role->role_name;  
}

/**
  * 
  * get current user role admin or editor or none
 
    \Wh::UserRole(); return admin;

    if curent user role is admin it will return true other cases false

     \Wh::UserRole('admin'); return true or false
*/
public static function UserRole($name=''){
  
  try{  
    $id = \Wh::id_user();
   if($id>0){ 
         $role = \DB::table('users')
                       ->where("users.id",$id)
                       ->join('role as r','users.user_role', '=', 'r.id' )
                       ->select('r.role_name')
                       ->first();
        if(!empty($name)){
           return !empty($role) && $role->role_name == $name ? true : false;
        }else{
           return !empty($role) ? @$role->role_name : "none"; 
        }
       }     
                  
        return !empty($name)? false : "none";   
   } catch (\Exception $e) {
        return !empty($name)? false : "none";     
    }                 
      
}
public static function setVariable(){
    @\Config::set('userRole', @\Wh::UserRole()  );
    return "";
 }

public static function currentRole($role=''){
    $current =  @\Config::get('userRole');
    return  $role == $current ? true : false ;
 }

/**
  * get user name or email by user id
  */
public static function get_user_name($id, $field="name"){
    $id = $id=="current" ? \Wh::id_user() : $id; 
  $role = \DB::table('users')
                       ->select('name','email')
                       ->where("id",$id)
                       ->first();
    return @$role->$field;  
}

/**
  * get list of pages
  */
public static function getPages($type="pages"){
  $pages = \DB::table('page')
                    ->where("type",$type)
                       ->get();
     
    
     $array= []; 
      foreach($pages as $v){
        $array[]=[$v->id,$v->title];
      } 
        
    return @$array;  
}
 

 

 /**
  * Return field from table setting by id 
  */ 
 public static function returnvalue($id, $field="value"){
     $get = \DB::table('settings')->where('id',$id)->first();
     return  $get->$field;
 }
 
/**
* Return field from table setting by param 
* $param - is any param(any word) 
* $field - value or value1 or value2
* $field2 - if you want to geth botth like $get->$field ."~". $get->$field2 and after use explode("~", $data)  
* 
*/
  public static function get_settings($param, $field="value", $field2=""){
    try { 
       $get = \DB::table('settings')->where('param',$param)->first();
       return !empty($field2)? $get->$field ."~". $get->$field2 : $get->$field; 
      
    } catch (\Exception $e) {  
       return ""; 
    } 
 }
 
 /**
  * Return field from table setting by param 
  *  $param - is any param(any word) 
  *  $field - value or value1 or value2
  */
  public static function get_settings_json($param, $field="value1" ){
      try { 
     $get = \DB::table('settings')->where('param',$param)->first();
     return !empty($get)? @json_decode($get->$field, true) : [];
     } catch (\Exception $e) {  
       return ""; 
    } 
 }
 
 
/**
 * Will return value from array by key
 */
public static function get_settings_key($param, $key=""){
   $settings = \Wh::get_settings_json($param, "value1"); 
   return isset($settings[$key]) ? $settings[$key] : ""; 
 }
 
 /**
 * Will return value from _CONSTANT_ array by key
 */
public static function constant_key($constant="", $key=""){
   return isset($constant[$key]) ? $constant[$key] : ""; 
 }
 
 /**
 * Will return value from _CONSTANT_ array by key
 */
public static function json_key($json="", $key=""){
    $constant = \Wh::isJson($json)? @json_decode($json,true): $json;
   return $constant[$key] ?? ""; 
 } 
  
 
 /**
  * Return loop data from table setting by param
  * 
  */
  public static function return_bulck_settings($param){
     $get = \DB::table('settings')->where('param',$param)->get();
     return  $get;
 }
 
  /**
  * Update or insert if param is not existing
  * $param - is the parametr where you can recognise your data 
  * $value  - varchar(255)
  * $value1 - text accept big data
  * $value2 - varchar(255)
  */
  public static function update_settings($param, $value="", $value1="", $value2="", $autoload=""){
    $check = \Wh::return_bulck_settings($param);
    $value1 =  !empty($value1) && is_array($value1)? json_encode($value1, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) : $value1;  
    if(count($check)>0){
        
       $get = \DB::table('settings')
                ->where('param', $param)
                ->update(
                      ['value' => $value, 'value1' => $value1, 'value2' => $value2, "autoload"=>$autoload]
                 ); 
    }else{
       $get = \DB::table('settings')->insert(
                ['param' => $param, 'value' => $value, 'value1' => $value1, 'value2' => $value2, "autoload"=>$autoload]
            ); 
    }
  }
  
  
    /**
  * Update or insert if id is not existing
  * $id -  id settings 
  * $value  - varchar(255)
  * $value1 - text accept big data
  * $value2 - varchar(255)
  */
  public static function update_settingsID($id, $value="", $value1="", $value2=""){
     $get = \DB::table('settings')
                ->where('id', $id)
                ->update(
                      ['value' => $value, 'value1' => $value1, 'value2' => $value2]
                 ); 
     
  }
  
  
  /**
   * Get product variation and specification
   */
   
 public static function get_variation($param=''){
        $settings = @\Wh::get_settings_json($param);
        $array=[];
       
       foreach($settings as $k0=>$v0){ 
            foreach($v0 as $k=>$sugestion){
               $array[$k0][$k]['sugestion']=@\Wh::get_settings_json($k);  
               $array[$k0][$k]['all']=@$sugestion;
            }
        } 
    return $array;
 }  
 
 /**
  *  return the option name and value 
  */
  public static function ret_option($variations="", $list=""){
      $settings_variation =  !empty($list)? $list : \Wh::get_variation("_attributes_") ;
      
      $return = [];
      foreach ($variations as $k=>$val){
        $value = @$settings_variation['variations'][$k]['sugestion'][$val];
         if(is_numeric($val)&& isset($settings_variation['variations'][$k]) && !empty($value)){
            $return [] = $settings_variation['variations'][$k]['all']['name'] ." : ".$value; 
         } 
      }  
      //printw($settings_variation);
     //$size = !empty($size)? " ; Size : ". returnsize($size, $typ_size) :"";
     return implode(" ; ",$return);
}
 
public static function get_specifications($key="", $data="",$attributes=[]){
    $specification = [];
    if(is_array($data)){
         foreach($data as  $v){
           $specification[] = @$attributes['specifications'][$key]['sugestion'][$v];
         }
     }else{
           $specification[] = @$attributes['specifications'][$key]['sugestion'][$data];
     }
   return implode(", ",$specification);  
}  
 
 public static function returnsize($s,$typ_size=""){
     $eu=["4"=>"32", "6"=>"34", "8"=>"36", "10"=>"38", "12"=>"40", "14"=>"42", "16"=>"46", "18"=>"48", "20"=>"50", "22"=>"52", "24"=>"54", "26"=>"56"];
     $us=["4"=>"1", "6"=>"2", "8"=>"4", "10"=>"6", "12"=>"8", "14"=>"10", "16"=>"12", "18"=>"14", "20"=>"16", "22"=>"18", "24"=>"20", "26"=>"22"];
      
     $eu_shos=["3"=>"35.5","3.5"=>"36", "4"=>"37", "4.5"=>"37.5", "5"=>"38", "5.5"=>"38.5", "6"=>"39", "6.5"=>"40", 
               "7"=>"40.5", "7.5"=>"41", "8"=>"42", "8.5"=>"42.5","9"=>"43", "9.5"=>"43.5"];
               
     $us_shos=["3"=>"5.5","3.5"=>"6", "4"=>"6.5", "4.5"=>"7", "5"=>"7.5", "5.5"=>"8", "6"=>"8.5", "6.5"=>"9", 
               "7"=>"9.5", "7.5"=>"10", "8"=>"10.5", "8.5"=>"11","9"=>"11.5", "9.5"=>"12"];
      
      if(is_numeric($s)){
        $size =empty($typ_size)? "UK".$s." - EU".$eu[$s]." - US".$us[$s] : "UK".$s." - EU".$eu_shos[$s]." - US".$us_shos[$s]; 
      }else{
        $size =$s;
      }
      
   return $size ;
 }


  /**
  * will return the current currency icon
  */ 
public static function currency(){
      return @CURENCY_CODE;
}

 /**
  * get price with currency icon
  * $price - normal price
  * $sale_price - sale price 
  * $type - if it's empty than will return the price + incrise what you setup on 
  *         Setting page link:  yourwebsite.domain/admin/general-settings/
  * if is not empty will return a clear price.
  */
public static function get_price_full($price, $sale_price=0, $type=''){
    $position = CURENCY_POSITION;
    $p= !empty($type)? $price: @\Wh::check_price($price);
    $sp = !empty($type)? @$sale_price: @\Wh::check_price(@$sale_price);
    $p = "<span>". @number_format($p, 2)."</span>";
    $sp = "<span>". @number_format($sp, 2)."</span>";
   if($position == "left with space"){
     $price_return  = $sale_price > 0 ? "<del class='pricesale'>".\Wh::currency()." ". $p."</del> ".\Wh::currency()." ".$sp :
                                         \Wh::currency()." ". $p;
   }elseif($position == "right with space"){
     $price_return  = $sale_price > 0 ? "<del class='pricesale'>". $p." ".\Wh::currency()."</del> ".$sp." ".\Wh::currency() :
                                           $p." ".\Wh::currency();
   }elseif($position == "right"){
     $price_return  = $sale_price > 0 ? "<del class='pricesale'>". $p.\Wh::currency()."</del> ".$sp.\Wh::currency() :
                                          $p.\Wh::currency();
   }else{
     $price_return  = $sale_price > 0 ? "<del class='pricesale'>".\Wh::currency(). $p."</del> ".\Wh::currency().$sp :
                                         \Wh::currency().$p;
   } 
  
   return $price_return;
}

 /**
  * get price only number
  * $price - normal price
  * $sale_price - sale price 
  * $price_option - if it's empty than will return the price + incrise what you setup on 
  *         Setting page link:  yourwebsite.domain/admin/general-settings/
  * if is not empty will return a clear price.
  */

public static function get_price_number($price=0,$sale_price=0, $price_option=0){
     
    if($price_option > 0){
       return \Wh::check_price($price_option); 
    }elseif($price_option === 0 && $sale_price >0 ){
       return \Wh::check_price($sale_price);  
    }else{
        return \Wh::check_price($price); 
    }
 }
  
public static function check_price($price=0, $none=""){
   $rate = CURENCY_RATE;
   $currency = !empty($rate) ? floatval($rate): 1;
   
   $addition_price = \Wh::constant_key(_MAIN_OPTIONS_,  "_additional_price");
   $additional_type = \Wh::constant_key(_MAIN_OPTIONS_,  "_additional_type");
   
   
   
   $my_plus = !empty($addition_price)? floatval($addition_price) : 0; 
   
   $price1=  $my_plus >0 && $additional_type == 'fix' ? 
                               round ((@$price + $my_plus) * $currency , 2):
                               round ((@$price + (@$price * $my_plus)/100) * $currency , 2);
                               
   return !empty($none)? round ($price * $currency, 2):  $price1;
}
 
 
  

public static function get_last_address(){
   $vorder = \DB::table('orders')
                 ->orderBy('id', 'desc')
                 ->select('shipping')
                 ->where('user_id', Self::id_user())
                 ->first();
                       
    return !empty($vorder) ? @json_decode($vorder->shipping, true) : [];
}
 

public static function prepareMenu($data=""){
    $getCurrentUrl= (string) request()->path();
     
    $menu = str_replace(['<a href="#" class="fa_delete fa_small delete_ittem"></a>',
                           '<a href="#" class="fa_edit fa_small"></a>',
                           '<a href="#" class="fa_move move_bdn"></a>',
                           '<a href="#" class="fa_move move_bdn ui-sortable-handle"></a>',
                           'class="simple_link"',
                           'style="opacity: 1;"',
                           ' ui-sortable-handle'  
                            ], "",$data);
      $menu= str_replace('<ul>','<ul class="sub-menu">', $menu);
       
       if($getCurrentUrl !="/"){                  
          $menu= str_replace($getCurrentUrl.'"', $getCurrentUrl.'" class="active-menu"', $menu);  
       }else{
          $menu= str_replace(['"/"','"'.url("/").'"'], ['"'.$getCurrentUrl.'" class="active-menu"'], $menu); 
       }
return $menu;
}
 
/**
 * Get menue
 * $value2 - top_menu or any what you selected
 */

public static function get_menu($value2="none"){
    $get = \DB::table('settings')->where('value2', $value2)->first();
    $menu= !empty($get)? \Wh::prepareMenu($get->value1) : ""; 
   return $menu;
}

/**
  * This public static function will add new ittem to admin menu
  */ 
 public static function doAdminMenu(){
    $menu= ADMIN_MENU; 
    
    $module = \Wh::get_all_configs("adminmenu");
    $theme = \Wh::get_config(_THEME_NAME_, "adminmenu"); 
    $removeMenu = \Wh::get_config(_THEME_NAME_, "removeAdminMenu");  
    
    $get= !empty($module)? $module : [];
    
    if(!empty($theme)){
       $get[_THEME_NAME_] = $theme;    
     }
     
    if(!empty($get)){
      foreach($get as $k=>$v){
         foreach($v as $k1=>$v1){
            if(isset($menu[$k1])){
                  $menu[$k1] = @array_merge($menu[$k1],$v1);
              }else{
                  $menu[$k1] = $v1;
              }
        }       
      }
    }
    ksort($menu);
    if(!empty($removeMenu)){
        foreach($removeMenu as $remove){
            unset($menu[@$remove]); 
        }
    }
    
    
   return $menu; 
 }
 
 
/**
 * This public static function will generate a list from array 
 * ADMIN_MENU - is a constant from array_settings_admin.php 
 */
public static function generateAdminMenu($k=[], $type = ''){
     $return = "";
     $global_menu= \Wh::doAdminMenu();
     $is_in= 0;
     $getCurrentUrl= (string) request()->path();
      
       if(!empty($type)){
             foreach($global_menu as $k_is=>$v){
               foreach($v as $k1=>$v1){ 
                  
                    if(@\Wh::instring(ltrim($k1,"/"), $getCurrentUrl) !== false && $k1 !="/admin"){
                        $is_in = $k_is ;
                        break;
                      }
                  }   
             }
         }   
     
     $menu = !empty($type)? @$global_menu[$is_in] : $k;
     
     unset($menu['#']);
       if(is_array($menu)){
         foreach($menu as $k_sub=>$v_sub){
            if($v_sub !="hidden"){
                $return .=   '<li>
                                 <a href="'.url($k_sub).'">
                                     '.$v_sub.'
                                 </a>
                           </li>';
                 }
             }
         }   
     
    return $return;
}

/**
 * This will replace data in menu when update page or categories
 */

public static function replaceMenuUpdate($cpu='', $newCpu='', $title='', $newTitle){
              $menu = \Wh::return_bulck_settings('_website_menu_');
           foreach($menu as $m){
          
            $ittem = !empty($cpu) && !empty($newCpu) ? 
                      str_replace("/".trim($cpu),"/".trim($newCpu), htmlspecialchars_decode($m->value1) ) : $m->value1;
            
            $ittem = !empty($title) && !empty($newTitle) ? 
                      str_replace(">".trim(htmlspecialchars_decode($title))."<",">".trim(htmlspecialchars_decode($newTitle))."<", htmlspecialchars_decode($m->value1) ) : 
                                                    $m->value1;
            
            \Wh::update_settingsID($m->id, $m->value, $ittem, $m->value2);
          }
}

/**
 * This is a simple helper check if class and method in the class exist 
 * if exists then return the method
 */
public static function check_clas_is($string="", $data=[] ){
        $class_is = explode('@',$string);
        $class_ =@$class_is[0];
        $method =@$class_is[1];
        $return = '';
       if (class_exists(trim($class_))) {
                $obj = new $class_;
                   
             if(method_exists($obj,$method)){
                 $return =  empty($data)? $obj->$method() : $obj->$method($data); 
               }
        }
        
   return $return;     
 } 

public static function simple_check($data="", $name="",$type='module',$vars=[]){
       if($type=="module"){
        $is= "Platform\Modules\\".ucfirst($name)."\\".$data;
       }elseif($type=="theme"){
         $is= "Platform\Themes\\".ucfirst($name)."\\".$data;
       }elseif($type=="cms"){
          $is= "App\Http\Controllers\\".$data;
       }                   
                          
                          
     $return = strpos($data, '@') !== false? \Wh::check_clas_is($is, $vars): $data;
    return $return; 
}

/**
 * Simple hook public static function 
 * in your theme in blade or controller you can add many hooks and from config.php you can add on that part of the page any code you want
 */  
public static function hooks($hook='', $data=[]){
     $module = \Wh::get_all_configs("hooks");
     $theme = \Wh::get_config(_THEME_NAME_, "hooks");
     
    $return='';
    if(!empty($module)){
        foreach($module as $k=>$v){
              if(isset($v[$hook])){
                 $return .=\Wh::simple_check($v[$hook], $k);
               }
          }
     }
     
     if(!empty($theme) && isset($theme[$hook])){
        $return .=\Wh::simple_check($theme[$hook], _THEME_NAME_, 'theme', $data ); 
      } 
       
    return $return;    
 }
 
 
 /**
 * Simple Widgets public static function 
 * 
 */  
public static function _widgets($widget=''){
     $module = \Wh::get_all_configs("widgets");
     $theme = \Wh::get_config(_THEME_NAME_, "widgets");
     
    $return='';
    if(!empty($module)){
        foreach($module as $k=>$v){
              if(isset($v[$widget])){
                 $return .=\Wh::simple_check($v[$widget], $k);
               }
          }
     }
     
             if(!empty($theme) && isset($theme[$widget])){
                $return .=\Wh::simple_check($theme[$widget], _THEME_NAME_, 'theme'); 
              } 
       

 }
 
 
 /**
  * Will return the value of array from config.php file of all activated modules by array key
  *  
  */
 public static function get_all_configs($key=""){
    $data = defined('_ACTIVE_MODULES_') ? _ACTIVE_MODULES_ : [] ;
    $return =[];
 
    foreach($data as $v){
         $check = \Wh::get_config($v, $key);
       if(!empty($check)){
         $return[$v]=$check;  
       }
    }
    
    return $return;
 }
 
 /**
  * Return the value by key from config.php of all active modules an themes
  * $key - is the key of array 
  * 
  */
 public static function configByKey($key=""){
     if(empty($key))
                     return [];

     $module = Self::get_all_configs($key);
     $theme = Self::get_config(_THEME_NAME_, $key);
    return (($module ?? []) + ($theme ?? [])) ;
 } 
 
public static function mergeConstantAnConfig($constant=[], $config='') {
    $array = Self::configByKey($config);
    return !empty($array)? array_merge($constant, $array) : $constant;
}
 
 
/**
 * Read config file from theme or module
 */
 
public static function get_config($module="", $field='description'){
     $path_module = base_path('platform/Modules/'.$module.'/config.php');
     $path_theme = base_path('platform/Themes/'.$module.'/config.php');
     
     $is_theme =  \File::exists($path_theme)? require $path_theme : [];
     
     $is_module = empty($is_theme) && \File::exists($path_module)? require $path_module : [];
     
     $is = !empty($is_theme) ? $is_theme : $is_module;
     
    return $field =="all" ? @$is :@$is[$field] ;
}  
 
 /**
 * This is a short code public static function if you need to use the short code in page
 * 
 */
public static function shortCode($text = ''){ 
     //$activate_plugins = _ACTIVE_MODULES_;
    $module = \Wh::get_all_configs("shortcode");
    $theme = \Wh::get_config(_THEME_NAME_, "shortcode");
    $default = SHORTCODE; 
     
  if(!empty($module) || !empty($theme) || !empty($default)){
    
    $regex = "/\[(.*?)\]/";
    preg_match_all($regex, $text, $matches);
    
   if(count($matches[1])>0) {
    for($i = 0; $i < count($matches[1]); $i++)
    {
        $match = $matches[1][$i];
        $short_code =trim(@$match);
        $data=[];
        
        if (strpos($match, '=') !== false) {
            $array = explode(' ', $match);
            $short_code= trim(@$array[0]);
         
            unset($array[0]); 
            foreach($array as $v){
             $split = explode("=", $v);
             if(empty($split[1])){
                 end($data);         // move the internal pointer to the end of the array
                 $key = key($data);  // fetches the key of the element pointed to by the internal pointer 
                 @$data[@$key] = @$data[@$key]." ".@$split[0]; //@$split[1];
                  
             }else{
                @$data[@$split[0]] = @$split[1];
             }
          }
        
        }
         
            
              if(!empty($module)){
                
                foreach($module as $k=>$v){
                  if(isset($v[$short_code])){
                      $return =\Wh::simple_check($v[$short_code], $k,'module', $data);
                      $text = str_replace("[".$match."]", $return, $text);
                    }
                }
              }
      
              if(!empty($theme) && isset($theme[$short_code])){
                $return =\Wh::simple_check($theme[$short_code], _THEME_NAME_, 'theme', $data);
                $text = str_replace("[".$match."]", $return, $text); 
              }
               
              if(!empty($default) && isset($default[$short_code])){
                $return =\Wh::simple_check($default[$short_code], '', 'cms', $data);
                $text = str_replace("[".$match."]", $return, $text); 
              }  
      
       
      }
     }
   } 
 
 return $text;
 } 
 
  /**
  * This will return from activated plugins a hook
 */
 
 public static function object_module($module="", $type="", $clean=''){
    $config= \Wh::get_config(@$module, $type);
    $var = is_array($config) ? $config[$type][0] : $config; 
  return empty($clean)? @"Platform\Modules\\".$module."\\".$var : $var;
 } 
 
 
 /**
  * Just return logo path
  */
 public static function logo_payment($logo=''){
    return !empty($logo)? url('/public/img')."/".$logo : "";
 }
 
 /**
  * will return the logo from the settings page
  */
 public static function _logo(){
    $logo = @\Wh::constant_key(_MAIN_OPTIONS_,  "_logo_");
    return !empty($logo)? '<a href="'.url("/").'"><img class="logo" src="'.url('/public/img/'.$logo).'"/></a>' : '';
 }
 
  /**
  * will return the favicon from the settings page
  */
 public static function _favicon(){
    $_favicon_ = @\Wh::constant_key(_MAIN_OPTIONS_,  "_favicon_");
    return !empty($_favicon_)? '<link rel="shortcut icon" type="image/png" href="'.url('/public/img/'.$_favicon_).'"/>' : '';
 }
 
 

 /**
  *  This public static function will convert post data to nice array like [[...],[...],[...],[...]]
  */

public static function convert_variation_array($variation = []){
           $var=[];
           $var_inside = [];
           $i=1;
           foreach($variation as $v1){
                   reset($v1);
                   $key = key($v1);
                if(isset($var_inside[$key]) || ($i==count($variation)) ){
                    
                    if($i==count($variation))
                                       $var_inside[$key]= $v1[$key];
                                       
                    $var[] = $var_inside;
                    $var_inside = [];
                   }
                $var_inside[$key]= $v1[$key];
                 $i++;
             }
    return $var;           
}

 /**
  *  This public static function will check if variation is than will return 
  */

public static function convert_variation($data = [], $type="", $array_type='', $attribut=[]){
    
           $attributes =!empty($attribut)? $attribut: @\Wh::get_variation('attributes');
           $variation_data =@$attributes[$type]; 
            
           $sugestion= "";
           if(empty($data))  return [];
            
           foreach($data as $k=>$v1){
               if(is_array($v1)){
                  foreach($v1 as $k2=>$v2){  
                     $_k =  is_numeric($k) ? $k2 : $k;
                      if(isset($variation_data[$_k]["sugestion"])){
                        $key = array_search($v2, $variation_data[$_k]["sugestion"]);
                           if($key === false){ 
                               $variation_data[$_k]["sugestion"][] =$v2; 
                               $key = count($variation_data[$_k]["sugestion"]) - 1;
                               $sugestion=  "yes";
                             }
                             
                           $data[$k][$k2]=$key; 
                        }
                     }
                 } 
                   else {
                    if(isset($variation_data[$k]["sugestion"])){
                           $key = array_search($v1, $variation_data[$k]["sugestion"]);
                           if($key === false){ 
                               $variation_data[$k]["sugestion"][] =$v1; 
                               $key = count($variation_data[$k]["sugestion"]) - 1;
                               $sugestion=  "yes";
                             }
                             
                           $data[$k]=$key;
                    }  
                 } 
              }
             
             if(!empty($sugestion)){
                foreach($variation_data as $k=>$v){
                    @\Wh::update_settings($k,  "",  json_encode($variation_data[$k]["sugestion"]));
                  }
             }
             
             
    return @$data;           
} 
  
 
public static function checkEmpty($check="",$before="",$after=""){
    return !empty($check) || $check==="0" || $check===0 ? $before.$check.$after : ''; 
} 

public static function checkDefault($check="", $default=''){
    return !empty($check) || $check==="0" || $check===0 ? $check  : $default; 
} 

public static function checkArrayIs($array=[],$key='', $value=''){
    $data = false;
    if(empty($array)) return false;
                    
    foreach($array as $k=>$v){
        if(is_array($v) && $v[$key] === $value ){
           $data = true; break;
        }
    }
    return $data;
}

/**
 * Crop image easy and eficient
 */

public static function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80, $crop=true){
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
 
    switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
 
        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
 
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = $quality;
            break;
 
        default:
            return false;
            break;
    }
     
   
    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    $r = $width / $height;
    $h_point =0;
    $w_point=0;
    $w_last = $width;
    $h_last = $height;
    
     if($crop){ 
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        
        $h_last = $height_new;
         
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        $w_last = $width_new;
     }
     
    }else{
        // No crop
         if ($max_width/$max_height > $r) {
            $max_width = $max_height*$r;
         } else {
            $max_height = $max_width/$r;
          }
     }
    
    
    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);
     
    //copy image
    imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, $h_point, $max_width, $max_height, $w_last, $h_last);
    
    $image($dst_img, $dst_dir, $quality);
 
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
}

public static function resize($source_image, $destination, $tn_w, $tn_h, $quality = 95, $wmsource = false)
{
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
            break;
        default:
            die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }

    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    $backgroundColor = imagecolorallocate($final, 255, 255, 255);
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    #if we need to add a watermark
    if ($wmsource) {
        #find out what type of image the watermark is
        $info    = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

    }
    if (imagejpeg($final, $destination, $quality)) {
        return true;
    }
    return false;
}


public static function clearUrl($url=''){
    
    $input = trim($url, '/');
     // If scheme not included, prepend it
    if (!preg_match('#^http(s)?://#', $input)) {
        $input = 'http://' . $input;
    }
    $urlParts = parse_url($input);
    
    // remove www
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
    return $domain;
}

public static function  AnaliticsURL(){
    $userAgent1 = @(string) request()->server('HTTP_USER_AGENT');
    $userAgent2 = @(string) request()->header('User-Agent');
    $userAgent = @!empty($userAgent2) ? @urlencode($userAgent2) : @urlencode($userAgent1);
    
    $referer = @urlencode((string) request()->path()); 
    $url = @urlencode(@str_replace(\URL('/'), '', \URL::previous()));
    
    return url("/analitic/run")."?userAgent=".$userAgent."&referer=".$referer."&previos=".$url ;
}

        
/**
 * it will call an external url by curl
 */
       

public static function get_by_curl($url, $no_return = "") {
        $user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36';

    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => $user_agent, // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return !empty($no_return)? "" : $content;
    }
 

/**
 * ----------------------------------------------------------------------------------------
 * Based on `https://github.com/mecha-cms/mecha-cms/blob/master/engine/plug/converter.php`
 * ----------------------------------------------------------------------------------------
 */
// HTML Minifier
public static function minify_html($input) {
    if(trim($input) === "") return $input;
    // Remove extra white-space(s) between HTML attribute(s)
    $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function($matches) {
        return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
    }, str_replace("\r", "", $input));
    // Minify inline CSS declaration(s)
    if(strpos($input, ' style=') !== false) {
        $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function($matches) {
            return '<' . $matches[1] . ' style=' . $matches[2] . \Wh::minify_css($matches[3]) . $matches[2];
        }, $input);
    }
   /* 
    if(strpos($input, '</style>') !== false) {
      $input = preg_replace_callback('#<style(.*?)>(.*?)</style>#is', function($matches) {
        return '<style' . $matches[1] .'>'. \Wh::minify_css($matches[2]) . '</style>';
      }, $input);
    }
    if(strpos($input, '</script>') !== false) {
      $input = preg_replace_callback('#<script(.*?)>(.*?)</script>#is', function($matches) {
        return '<script' . $matches[1] .'> '. minify_js($matches[2]) . ' </script>';
      }, $input);
    }
    */
    return preg_replace(
        array(
            // t = text
            // o = tag open
            // c = tag close
            // Keep important white-space(s) after self-closing HTML tag(s)
            '#<(img|input)(>| .*?>)#s',
            // Remove a line break and two or more white-space(s) between tag(s)
            '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
            '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
            '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
            '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
            '#<(img|input)(>| .*?>)<\/\1>#s', // reset previous fix
            '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
            '#(?<=\>)(&nbsp;)(?=\<)#'//, // --ibid
            // Remove HTML comment(s) except IE comment(s)
            //'#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
        ),
        array(
            '<$1$2</$1>',
            '$1$2$3',
            '$1$2$3',
            '$1$2$3$4$5',
            '$1$2$3$4$5$6$7',
            '$1$2$3',
            '<$1$2',
            '$1 ',
            '$1'//,
            //""
        ),
    $input);
}
// CSS Minifier => http://ideone.com/Q5USEF + improvement(s)
public static function minify_css($input) {
    if(trim($input) === "") return $input;
    return preg_replace(
        array(
            // Remove comment(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            // Remove unused white-space(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            // Replace `:0 0 0 0` with `:0`
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            // Replace `background-position:0` with `background-position:0 0`
            '#(background-position):0(?=[;\}])#si',
            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            // Minify string value
            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            // Minify HEX color code
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            // Replace `(border|outline):none` with `(border|outline):0`
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            // Remove empty selector(s)
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ),
        array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ),
    $input);
}
// JavaScript Minifier
public static function minify_js($input) {
    if(trim($input) === "") return $input;
    return preg_replace(
        array(
            // Remove comment(s)
            '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
            // Remove white-space(s) outside the string and regex
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
            // Remove the last semicolon
            '#;+\}#',
            // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
            '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
            // --ibid. From `foo['bar']` to `foo.bar`
            '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
        ),
        array(
            '$1',
            '$1$2',
            '}',
            '$1$3',
            '$1.$3'
        ),
    $input);
}

public static function removeSlashes($url=''){
    $explode = explode("/",$url);
    $count  = (count($explode) - 2);
    $str = '';
    for($i=0;$i<$count ; $i++){
      $str .=  $explode[$i].'/';  
    }
    return $str;
}

 /**
 * this function is for not run all the time the foreach 
 */
 
public static function get_current_currency($all_curencies=[], $field = ""){
       $sesion_currency = \Cookie::get('currency_shop');
       
      if(!empty($sesion_currency)){
          return $field=='key'? $sesion_currency : @$all_curencies[$sesion_currency][$field];
       }
     
     $default="";
     if(count($all_curencies)>0){
         foreach ($all_curencies as $k=>$v){
              if(isset($v['default'])){
                $default= $k; 
                break;
              }
         }
         
         $key = !empty($default)? $default : key($all_curencies);
         
         $return = $field=='key'? $key : $all_curencies[$key][$field] ; 
         
      }else{
        $return = $field=="type"? 'left': "USD";
     }
     $sesion_currency =  null;
     $field  = null;
     $key = null;
   return  $return ;
}  
 
/**
  * Setup the default constants
  */
  
 public static function load_settings_defoult(){
       $arr= [
              "_theme_name_"=> ["_THEME_NAME_", "value", "not"],
              "_categories_structure_"=> ["_CATEGORIES_STRUCTURE_", "value1", "yes"], 
              "_currencies_"=> ["_CURRENCIES_", "value1", "yes"],
              "_active_modules_" => ["_ACTIVE_MODULES_", "value1", "yes"],
              "_attributes_" => ["_ATTRIBUTES_", "value1", "yes"],
              "_main_options_" => ["_MAIN_OPTIONS_", "value1", "yes"],
              "_categories_fields_" => ["_CATEGORIES_FIELDS_", "value1", "yes"],
              "_header_" => ["_HEADER_", "value1", "not"],
              "_footer_" => ["_FOOTER_", "value1", "not"],
              "_shop_sidebar_" => ["_SHOP_SIDEBAR_", "value1", "not"],
              "_lang_view_"=> ["_LANG_VIEW_", "value1", "not"],
              "_lang_admin_"=> ["_LANG_ADMIN_", "value1", "not"],
              "_footerjs_"=> ["_FOOTERJS_", "value1", "not"],
             ];
     
      try {  
        $get = \Schema::hasTable('settings') ?  \DB::table('settings')->whereIn('param',array_keys($arr))->orWhere('autoload','yes')->get(): [];
       if(count($get)>0){ 
        foreach($get as $v_start){
           if(isset($arr[$v_start->param])){ 
             $name=@$arr[$v_start->param][1];    
             $data= @$arr[$v_start->param][2]=="yes"?  json_decode($v_start->$name, true) : $v_start->$name ;
             define($arr[$v_start->param][0], @$data);
           }else{
             define(strtoupper($v_start->param), (\Wh::isJson($v_start->value1) ? json_decode($v_start->value1, true) : $v_start->value1));
           }  
             $data=null; 
             $name=null;
         }
       }
       $get = null;
       $arr = null;
       
     } catch (\Exception $e) {
        } 
      
 }

}
 