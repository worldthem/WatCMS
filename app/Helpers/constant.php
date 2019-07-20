<?php
/**
 * Here will setup all the constant for the shop
 * 
 */
 
 //setup all the default data from table settings all where autoload = yes
\Wh::load_settings_defoult();
 
if(!defined('_THEME_NAME_')){
    define("_THEME_NAME_", "none");   
}
 
//define("CURRENT_USER_ROLE", @get_current_user_role());
 try { 
       $getData= file_get_contents(base_path('/language/en.json'));
       $data_en = @json_decode($getData, true); 
       define("_TRANSLATE_DATA_", $data_en );
        
} catch (\Exception $e) {  } 

 try { 
       $langView =  _LANG_VIEW_; 
      if(!empty($langView) && $langView !='en') {
           $getData= file_get_contents(base_path('/language/'.$langView.'.json'));
           $data_en = @json_decode($getData, true); 
           define("_TRANSLATE_VIEW_", $data_en );
       }else{
           define("_TRANSLATE_VIEW_", [] );
       }
} catch (\Exception $e) {  }
 
 try { 
       $langAdmin =  _LANG_ADMIN_; 
      if(!empty($langAdmin) && $langAdmin !='en') {
           $getData= file_get_contents(base_path('/language/'.$langAdmin.'.json'));
           $data_en = @json_decode($getData, true); 
           define("_TRANSLATE_ADMIN_", $data_en );
       }else{
           define("_TRANSLATE_ADMIN_", [] );
       }
     $langAdmin = null; 
     $data_en = null;
     $getData = null;
     $langView = null;
} catch (\Exception $e) {  }
  
define("THEME", "themes."._THEME_NAME_."." );
define("CURENCY_CODE", @\Wh::get_current_currency(_CURRENCIES_, "code") );
define("CURENCY_POSITION", @\Wh::get_current_currency(_CURRENCIES_, "type") );
define("CURENCY_RATE", @\Wh::get_current_currency(_CURRENCIES_, "rate") );
define("CURENCY_CODE_KEY", @\Wh::get_current_currency(_CURRENCIES_, "key") );
define("USER_CART_ID", @\Cookie::get('tmp_user_id'));
define("_THEME_PATH_", url("/platform/Themes")."/"._THEME_NAME_);
define("SHORTCODE", 
               ['form'=>'ShortCode@form',
                'menu'=>'ShortCode@menu',
                'cart'=>'ShortCode@cart',
                'currency'=>'ShortCode@currency',
                'menulogged'=>'ShortCode@menulogged',
                'search'=>'ShortCode@search', 
                'category'=>'ShortCode@category', 
                'products'=>'ShortCode@products',
                'subcategory'=>'ShortCode@subcategory',
                'variations'=>'ShortCode@variations',
                'categories'=>'ShortCode@categories',
                'button'=>'ShortCode@button',
                'subscribe'=>'ShortCode@subscribe',
                'pricesort'=>'ShortCode@pricesort',
               ] 
 ); 
 
define("_CSSSTYELE_",[
             "/resources/assets/css/style.css", 
             "/resources/assets/css/pageBuilderDefault.css" 
]);