<?php

namespace App\Http\Controllers;

use App\Modules\Page;
use App\Modules\Product;
use App\Modules\Settings;
use App\Modules\Cart;
use Illuminate\Http\Request;

class ShortCode extends Controller
{
   
/**
 * Contact form Short code
 * [form id=2]
 */
     public function form($data= []) {
           $id = @$data['id'];  
           $field = Settings::where("value2",$id)->first();
           $row = json_decode($field->value1, true); 
           $random = \Wh::get_random(10); 
         return view("standart.default.ContactForm", compact('row','id','random'));
     }
     
  
     
/**
 * Menu Short code
 * [menu id=2 class=topMenu align=center]
 */  
     public function menu($data= []) {
           $id = @$data['id'];  
           $align = !empty($data['align']) ? ' center-text' : '';
           $field = Settings::where("id",$id)->first();
           if(empty($field)) return "";
           $menu = @$field->value1; 
           $class= !empty($data['class'])? " ".$data['class'] : "";
           $randon_class= \Wh::get_random(10, "yes");
          return '<div class="container_menu_icon" onclick="menu_show_is(this,\'.'.$randon_class.$class.'\')"><div class="bar1"></div><div class="bar2"></div><div class="bar3"></div> </div>
                  <ul class="ulmenu '.$randon_class.$class.$align.'" > '.\Wh::prepareMenu($menu).'</ul>' ;
     }
     
     
 /**
 * It will shou double menu if you want to show a menu when user is logged and user is not login than use it  
 * [menulogged loggedin=44 loggedout=53]
 */  
     public function menulogged($data= []) {
           $loggedin = @$data['loggedin']; 
           $loggedout = @$data['loggedout']; 
           $id= \Auth::check() ? $loggedin : $loggedout;
           $field = Settings::where("id",$id)->first();
           if(empty($field)) return "";
           $menu = @$field->value1; 
           $class= !empty($data['class'])? " ".$data['class'] : "";
           $randon_class= \Wh::get_random(10, "yes");
          return '<div class="container_menu_icon" onclick="menu_show_is(this,\'.'.$randon_class.$class.'\')"><div class="bar1"></div><div class="bar2"></div><div class="bar3"></div> </div>
                  <ul class="ulmenu '.$randon_class.$class.'">'.@\Wh::prepareMenu(@$menu).'</ul>' ;
     }    
    
/**
 *  Add to cart Short code, it allow you to add produc to cart by using product ID
 *  [cart title=Add to cart id=21 redirect=cart]
 *  redirect=cart  - it's mean after add to cart will redirect to cart Page
 *  redirect=checkout  - it's mean after add to cart will redirect to checkout Page
 */     
    public function cart($data= []) {
           $id = @$data['id'];  
           $title = @$data['title'];
           $random = \Wh::get_random(10, "yes");
           $redirect = !empty($data['redirect']) ? "&redirect=".url('/steps/'.$data['redirect']) : '';
            
         return   '<a href="#" class="btn btn-big" onclick="wajax(\'.'.$random.'\', \'action=AddToCart&id='.$id.'&qtu=1&max_qtu=200&oneQty=yes'.$redirect.'\' ); return false;">
                      <span class="'.$random.'">'.$title.'</span>
                  </a>'; 
     }  
     
     
/**
 * Switch currency short code
 * [currency]
 */     
    public function currency($data= []) {
          return view('standart.default.currency-switch-button'); 
     } 
   
 /**
 * Search form short code
 * [search title=search type=posts]
 * title - placeholder; example: title=Search for products
 * type - posts or products or page; example: type=products
 * mode - ajax or enter; example:  mode=ajax
 * cat - is the category where you want to search only ; example: cat=23
 * attribute - is the class or id of container ajax search; example: attribute=.search 
 * 
 * [search title=Search type=posts mode=ajax  cat=23 attribute=.search]
 * 
 */     
      public function search($data= []) {
         $title =  $data['title'] ?? _l('Search');  
         $type =  $data['type'] ?? '';
         $cat = !empty($data['cat']) ? '<input type="hidden" name="cat" value="'.$cat.'">': '';
         $url =  $type == "posts" ? url('/search/posts') : url('/search/products');
         $mode =  @$data['mode'] =='ajax' ? 'ajax' : 'enter' ;
         $attribute =   $data['attribute'] ??  '#livesearch' ;
         $type = null;
        return view('standart.default.searchForm',compact('title' ,'url', 'mode', 'cat', 'attribute')); 
      }     
     
  /**
 * Get last 10 products from product category where id category equal 8 
 * [category id=10] 
 * id - product category
 * limit- Limit 
 */     
    public function category($data= []) {
           $id =  $data['id'] ?? 0;
           $limit = @!empty($data['limit']) ? $data['limit'] : 8; 
           $products =  Product::join_query() 
                           ->orderBy('id','desc')
                           ->whereJsonContains('cat', [intval($id)])
                           ->paginate($limit) ;
                         
             $view_file = view()->exists('theme::layouts.product')? 'theme::layouts.product' : 
            
                                                                     'standart.product.product';   
            $view='<div class="productListBlcok">'; 
                foreach ($products as $product){
                   $view .= view($view_file,compact('product')); 
                }
            $view .='</div>';          
          return $view;
    }     
        
 /**
 * Get products where id's products equal 10,15,12 
 * [products id=10,15,12] 
 * id - product products separated by coma
 */     
    public function products($data= []) {
            $ids= $data['id'] ?? 0;
            $id = \Wh::instring(",",$ids)? explode(",", $ids) : [$ids];
           
             $products =  Product::join_query(); 
             $products = count($id) >1 ? $products->whereIn('id', $id)->get() :
                                         $products->where('id', $ids)->first(); 
                                         
              $view_file = view()->exists('theme::layouts.product')? 'theme::layouts.product' : 
                                                                     'standart.product.product';             
              $view='<div class="productListBlcok">'; 
            if(count($id) >1){                
                foreach ($products as $product){
                   $view .= view($view_file, compact('product')); 
                }
            }else{
                   $view = view($view_file, ['product'=>$products]);
               }
         $view .='</div>';       
                     
          return $view;
            
     } 
     
 /**
 * Get main category subcategory, it's good for left sidebar
 * [subcategory]
 */     
    public function subcategory($data= []) {
           $maincat = \Config::get('maincatID');
           $catStructure = _CATEGORIES_STRUCTURE_;
           
          $title = !empty($maincat)? '<h2 class="catTitleLeft">
                                       <a href="'.url("/cat/".@$catStructure[$maincat]['cpufull']).'">'.@$catStructure[$maincat]['title'].'</a>
                                     </h2>': '';
          return '<div class="sidebar-categories sidebarBlock">'.$title.'<ul class="categoriesList">'. \Wh::getCatChild().'</ul></div>';
     }  
     
 /**
 * if you need to add additional options for your costomers to sort products by color or size or any options  use it
 *   
 * [variations id=JhOIysPmfa title=Color]
 * id - id of variation or specification
 * title - is the title Color or Size or Price range
 * catid - is the main category id for example if you have on website many different products and want to show 
 *   the variation only for one category and subcategories, that will be the best to add cat id 
 */     
    public function variations($data= [] ) {
            $id =  $data['id'] ?? '';
            $catid = $data['catid']?? "none" ;
            $title = $data['title']  ?? '';
            
            $maincat = \Config::get('maincatID');
             if($catid != "none" && $catid != $maincat) return "";
            
            $getSettins = \Wh::get_settings_json($id);
           if(empty($getSettins)) return "";
           
             // get full url and parse the query from it meant this ?THFYOzjlyv=0-2&jyrJjuxndM=1-4
             $url = @parse_url(url()->full()); 
             $query = @ $url["query"] ;
             
             parse_str(@$url["query"], $get_array);
             
             $values= @$get_array[$id];
             // put the values in array
             $arrayValues= !empty($values) ? @explode("-", @$values): [];
              
            // sho the variations in checkbox
             $li ='<div class="sidebarBlock"> <div class="titleVariation"> '.$title.' </div> <div class="variationsList">';
             
               $li .=\Wh::variationUrl($getSettins, $id);
               
              $li .= '</div> </div>';
              return $li;
          
     }
     
 public function getChildCat($cat='', $type='', $count=2, $view=''){
       $catStructure = _CATEGORIES_STRUCTURE_;
       $return  = '';
       $catID = \Config::get('catID'); 
       $selectType = \Config::get('selectType');
       $space = '';
       for($i=0;$i<$count;$i++){
        $space .= '&nbsp;' ;
       }
       $space = $count==1? '' :$space;
       
       $currentCpuFull = explode("/", ($catStructure[$catID]['cpufull']?? ''));
         if(!empty($catStructure)){ 
            $urlBegin= $type == 'product' ? 'cat':'categories/'.$type;
           foreach($catStructure as $k=>$v){
             
                 $cpuFull= explode("/", $v['cpufull']);
                 if($v['type']==$type && (in_array($cat, $cpuFull) || $cat=='none') && count($cpuFull) == $count){
                    
                   $child =  $this->getChildCat($v['cpu'], $type, ( $count +1 ), $view ); 
                   
                   if(!empty($view)){
                       $value = !empty($selectType) ? $k : url('/'.$urlBegin.'/'.$v['cpufull']) ; 
                       $selected = $catID == $k ? ' selected=""':''; 
                       $parentbg = !empty($child) ? 'style="background-color:#F0F0F0;"':'';
                       $return .= '<option '.$parentbg.$selected.' value="'.$value.'"> '.$space.$v['title'].'</option>';  
                       $return .=  $child; 
                   }else{
                        
                        $class= !empty($child)? 'catWithSubcat':'';
                        $currentParr = in_array($v['cpu'], $currentCpuFull) ? ' currentParrent ':''; 
                        $currentCat = $catID == $k ?  ' currentCat':"";
                        $return .= '<li class="'.$class.$currentParr.$currentCat.'"><a href="'.url('/'.$urlBegin.'/'.$v['cpufull']).'">'.$v['title'].'</a> '.$child.'</li>'; 
                    }
                      
                  }
           }
         }  
    return !empty($return)? (!empty($view) ? $return :($count ==1? $return : '<ul class="subCategoriesList">'. $return .'</ul>')): '';
 }    
     
 /**
 * Get categories
 *  
 * [categories title=Product Categories type=product view=select select=simple ]
 */     
    public function categories($data= [] ) { 
       $type =  $data['type']?? 'product';
       $title =  $data['title'] ?? '';
       $catStructure = _CATEGORIES_STRUCTURE_;
       $view = $data['view'] ?? '';
       $select = $data['select'] ?? '';
       if($view=="select")
           return $this->categoriesSelect($type, $title, $catStructure, $select);
       
       
       $title = !empty($title)? '<h2 class="catTitleLeft">'.@ $title.'</h2>': '';
       $return= '<div class="sidebar-categories sidebarBlock"> '.$title.'<ul class="categoriesList">';

          if(!empty($catStructure)){
             $return .= $this->getChildCat('none', $type, 1);
           }
           
       $return .= '</ul></div>';
       
       return  $return;
       
    }    

/**
 * Get categories
 *  
 * [categoriesSelect title=Product Categories type=product]
 */     
    public function categoriesSelect($type='', $title='', $catStructure=[], $select ='') { 
     $return= '<select name="cat" class="selectNice" '.(empty($select) ? 'onchange="if (this.value) window.location.href=this.value"' : '').'>';
        \Config::set('selectType', $select); 
        $return .= '<option value="">'._l("Category").'</option>';
         if(!empty($catStructure)){
            $return .= $this->getChildCat('none', $type, 1, 'select' );
           }
       $return .= '</select>';
       
       return  $return;
       
    } 


/**
 * Simple nice Button  
 *  [button url=# title=SHOP NOW color=black]
 */
 
   public function button($data= [] ) { 
       $color = !empty($data['color'])? @$data['color'] : 'white';
       $title = @$data['title'];
       $url = @$data['url'];
       $style = $color !='white'? 'style="color:'.$color.'; border-color:'.$color.';"' : '';
       
       return '<a class="niceButton" '.$style.' href="'.$url.'">'.$title.'</a>';
       } 
       
 /**
 * Simple nice Button  
 *  [subscribe]
 */
 
   public function subscribe($data= [] ) { 
         return view('standart.default.subscribe');
       }
 
  /**
     *  Price sort shortcode [pricesort]
     */              
   public function pricesort(){
         $pricemin = \Input::get("pricemin") ?? '';
         $pricemax  =  \Input::get("pricemax")?? '';
        return view('standart.default.pricesort', compact('pricemin', 'pricemax'));
   }    
}