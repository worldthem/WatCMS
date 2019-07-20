<?php
/**
 *  Do not delete this file keep it 
 * in this file are all the settings for the controller StandartSettingsController, Admin
 * 
 */	
 
/**
 * Currency setting
 */
$getCurrentUrl= (string) request()->path();
  
//if (\Wh::instring('admin', $getCurrentUrl)){ 
 
$enable_txt = ['enable'=> 'enable|checkbox|yes']; 


/**
  * Currencies
  */ 
require "currencies.php";

/**
  * Billing Shipping Fields
*/

$option=[ 'show_title'=>_l('Show title').'|checkbox|yes', 
          'required'=>_l('Required').'|checkbox|yes', 
          'mode'=>_l('Field width').'|select|full:half',
          'type'=>_l('Field Type Box').'|select|textbox:textarea', //'|select|textbox:select:textarea'
           //'sugestion'=>_l('Suggestion, one per line(if Field Box is select)').'|textarea'
           ];
               
  
$fields_checkout=    [ 'title'=>_l('Billing Fields'),
                       'header'=> [ 'name'=>_l('Title').'|text|'._l('Billing Address'),'','','','','' ] ,
                       
                       'name'=>array_merge($enable_txt,['name'=>_l('First Name').'|text|'._l('First Name')],$option),  
                       'lastname'=>array_merge($enable_txt,['name'=>_l('Last Name').'|text|'._l('Last Name')],$option),  
                       'email'=>array_merge($enable_txt,['name'=>_l('Email').'|text|'._l('Email')],$option), 
                       'phone'=>array_merge($enable_txt,['name'=>_l('Phone').'|text|'._l('Phone')],$option),
                       
                       'country'=>array_merge($enable_txt,['name'=>_l('Country').'|text|'._l('Country')],$option), 
                       'address'=>array_merge($enable_txt,['name'=>_l('Address').'|text|'._l('Address')],$option), 
                       'address2'=>array_merge($enable_txt,['name'=>_l('Address 2').'|text|'._l('Address 2')],$option),  
                       'zip'=>array_merge($enable_txt,['name'=>_l('Zip / Postal Code').'|text|'._l('Zip / Postal Code')],$option),  
                       'city'=>array_merge($enable_txt,['name'=>_l('City').'|text|'._l('City')],$option),  
                       'county'=>array_merge($enable_txt,['name'=>_l('County').'|text|'._l('County')],$option),  
                       'state'=>array_merge($enable_txt,['name'=>_l('State').'|text|'._l('State')],$option),  
                       'company_name'=>array_merge($enable_txt,['name'=>_l('Company name').'|text|'._l('Company name')],$option), 
                       'fax'=>array_merge($enable_txt,['name'=>_l('Fax').'|text|'._l('Fax')],$option), 
                       
                       'order_notes'=>array_merge($enable_txt,['name'=>_l('Order notes').'|text|'._l('Order notes')],$option), 
                       ];
  
   //$fields_checkout['country']['type'] = _l('Select').'|none|';                    
   $fields_checkout['country']['type'] = '<a href="'.url('/admin/setting/countries').'">'._l('Edit suggestion here').'</a> |none| ';                    
  
   $billing_fields= $fields_checkout;
   
   $billing_fields['password']= array_merge($enable_txt,['name'=>_l('Password').'|text|'._l('Password').'('._l('Create an account to access your orders history').')'],$option); 
   
   $shipping  = [];
   
   $shipping['enable'] = ['enable'=>_l('Enable Shipping').'|checkbox|yes','','','','',''  ];
   $shipping_fields  = array_merge($shipping,$fields_checkout);
   $shipping_fields['title'] = _l('Shipping Fields');  
   $shipping_fields['header'] =  [ 'name'=>_l('Title').'|text|'._l('Shipping Address'),'','','','','' ] ;    
      
  /**
   *  This is the array where you can add new setting
   */     
          
define("VIEW_SETTINGS", [ 
                'billing_fields'=>$billing_fields,
                'shipping_fields'=>$shipping_fields,
                '_currencies_'=>$currencies,
                'menu'=>50     
                                 ]);
 


define("_ALL_CURRENCIES", $currencies); 
 
define("_STATUS_LIST",  ['processing'=>_l('Change status to processing'),
                         'on-hold'=>_l('Change status to on-hold'),
                         'completed'=>_l('Change status to completed'),
                         'cancel'=>_l('Change status to cancel'),
                         'refunded' =>_l('Change status to refunded'),
                         'Incomplete'=>_l('Change status to incomplete') 
                         ]);

 

define("_GENERAL_SETTINGS",  [ 
                               
                               '_developmentMode_'=>['type'=>'checkbox','title'=> _l('Development Mode'), 'option'=>'yes', 'parent'=>'_main_options_'], 
                               '_cachehomepage_'=>['type'=>'checkbox','title'=>_l('Cache Home Page'), 'option'=>'yes','parent'=>'_main_options_'],
                              
                               'admin_mail'=>['type'=>'input','title'=>'<i class="fa fa-at"></i> '._l('Email Address'),'parent'=>'_main_options_'], 
                               'admin_mail'=>['type'=>'input','title'=>'<i class="fa fa-at"></i> '._l('Email Address'),'parent'=>'_main_options_'], 
                               '_website_url_'=>['type'=>'input','title'=>'<i class="fa fa-link"></i> '._l('Site Address (URL)'),'parent'=>'_main_options_' ], 
                               '_site_title_'=>['type'=>'input','title'=>'<i class="fa fa-file"></i> '._l('Site Title'),'parent'=>'_main_options_' ],
                               '_metad_'=>['type'=>'input','title'=>'<i class="fa fa-file"></i> '._l('Meta descriptions'),'parent'=>'_main_options_' ],
                               '_metak_'=>['type'=>'input','title'=>'<i class="fa fa-file"></i> '._l('Meta keyword'),'parent'=>'_main_options_' ], 
                         
                               'freespace_1'=>['type'=>'','title'=>'<h4>'._l('Shop pages').':</h4>' ],
                               '_pageHome_'=>['type'=>'select','title'=> _l('Home Page'),'option'=>'\Wh::getPages', 'function'=>'yes','parent'=>'_main_options_'],
                              
                              //'_acceptcookies_'=>['type'=>['select'],'title'=>_l('Cookies'),'option'=>'\Wh::getPages', 'function'=>'yes'], 
                              '_checkout_termandcondition_'=>['type'=>'select','title'=>_l('Checkout term and condition page'),'option'=>'\Wh::getPages', 'function'=>'yes','parent'=>'_main_options_'],  
                              //'_pageCategories_'=>['type'=>['select'],'title'=>_l('Product Categories'),'option'=>'\Wh::getPages', 'function'=>'yes'], 
                              //'_pageSingleProduct_'=>['type'=>['select'],'title'=>_l('Single Product'),'option'=>'\Wh::getPages', 'function'=>'yes'], 
                              //'_pageCart_'=>['type'=>['select'],'title'=>_l('Cart Page'),'option'=>'\Wh::getPages', 'function'=>'yes'], 
                             // '_pageCheckout_'=>['type'=>['select'],'title'=>_l('Checkout'),'option'=>'\Wh::getPages', 'function'=>'yes'], 
                             // '_pageMyorders_'=>['type'=>['select'],'title'=>_l('Orders Page'),'option'=>'\Wh::getPages', 'function'=>'yes'],
                              '_footerjs_'=>['type'=>'textarea','title'=>_l('Any js like google analitycs code or chat') ], 
                             ]);
  
  
  
  
 $checkout_menu = [];
 foreach(VIEW_SETTINGS as $k => $v){
     if(!empty($v['title'])){
          $checkout_menu['/admin/setting/standart/'.$k] = @$v['title'];
        }
  }
 
define("ADMIN_MENU",  [ 
                          10 => [   
                                  '#'=> _l('eCommerce'),
                                  '/admin'=> _l('Orders'),
                                  '/admin/comments'=> _l('Reviews'),
                                  '/admin/page/emails'=> _l('Email Templates'),
                                  '/admin/page/add-edit/emails/'=>"hidden",
                                  '/admin/cupon'=> _l('Coupons') 
                                 ],
                          20 => ['/admin/statistic'=> _l('Statistic')],              
                                         
                          30 => ['#'=> _l('Pages'), 
                                 '/admin/page/pages'=> _l('Pages'), 
                                 '/admin/contact-form'=> _l('Contact Forms'),
                                 '/admin/editable-blocks/_header_'=> _l('Header'),
                                 '/admin/editable-blocks/_footer_'=> _l('Footer'),
                                 '/admin/editable-blocks/_shop_sidebar_?editor=editor'=> _l('Shop Sidebar'),
                                 '/admin/editable-blocks/product-single?editor=editor'=> _l('Product Single Page Sidebar'),
                                  
                                 'admin/page/add-edit/pages/'=> "hidden"],
                          
                          40 => ['#'=>_l('Blog'), 
                                 '/admin/page/posts'=> _l('Posts'),
                                 '/admin/categories/posts'=> _l('Categories'),
                                 '/admin/categories/tags'=> _l('Tags'),
                                 '/admin/page/add-edit/posts/'=>"hidden",
                                 '/admin/categories/add-edit/posts/'=>"hidden", 
                                 '/admin/categories/add-edit/tags/'=>"hidden", 
                                ],
                          50 =>  
                               ['#'=> _l('Products'),
                                '/admin/view-products'=> _l('All Products') ,
                                '/admin/product/new'=> _l('Add new product'),
                                '/admin/categories/product'=> _l('Product Categories'),
                                '/admin/categories/brand'=> _l('Brands'),
                                '/admin/attributes/variations'=> _l('Variation'),
                                '/admin/attributes/specifications'=> _l('Specification'),
                                '/admin/import-products'=> _l('Import Products from CSV'),
                                '/admin/page/add-edit/tabs/'=> _l('Import Products from CSV'),
                                '/admin/page/tabs'=> _l('Product Tabs'),
                                
                                '/admin/product/'=>"hidden",
                                '/admin/categories/add-edit/product/'=>"hidden",
                                '/admin/categories/add-edit/brand/'=>"hidden",
                                '/admin/page/add-edit/tabs/'=>"hidden",
                                ]  ,
                                         
                          60 =>   array_merge (
                                 ['#' => _l('Checkout')],
                                  $checkout_menu, 
                                 ['/admin/setting/shipping'=>_l('Shipping Method'),
                                  '/admin/setting/countries'=>_l('Countries'),
                                  '/admin/payment'=> _l('Payment')]
                                  ),
                          70 => ['#' => _l('Users'),
                                 '/admin/users' => _l('Users'), 
                                 '/admin/subscribe' => _l('Subscribers'),  
                                 ],  
                                        
                          80 => ['#'=> _l('General Settings'),
                                 '/admin/general-settings'=> _l('General Settings'),
                                 '/admin/general-settings/language'=> _l('Language'),
                                 '/admin/menu'=> _l('Menu'),
                                 '/admin/themes'=> _l('Themes'),
                                 '/admin/modules'=> _l('Modules'),
                                 '/admin/mail'=> _l('Email settings'),
                                 '/admin/language/translate/'=>'hidden'
                                ],
                                          
                          800 => ['/signup/logout' => _l('Log out')]                                                               
  
                          ]);
  



define("CATEGORIES_TYPES",[ 'product'=>["product"=>_l('Product categories'),
                                        "brand"=>_l('Brands')],
                                        
                            'posts'=>["posts"=>_l('Categories'),
                                      "tags"=>_l('Tags'),]
                           ]);
                                                      
define("PAGES_TYPE",[ 'pages'=>['cpu','metad','metak'],
                      'posts'=>['cpu','metad','metak','cat','image'],          
                      'emails'=>['subject','enable','editonly'],
                      'tabs'=>[ 'enable','sort']
                       ]); 
                       
define("UTILS_LINK_FOR_MENU",[  ''=>_l('Select URL'),
                                '/shop'=>_l('Shop'),
                                '/wishlist'=>_l('Wishlist'),
                                '/steps/cart'=>_l('Cart'),
                                '/steps/checkout/'=>_l('Checkout'),
                                '/steps/viewOrder'=>_l('My orders'),
                                '/signup/my-account'=>_l('My Account'),
                                '/categories/posts'=>_l('Blog'),
                                '/signup/logout'=>_l('Logout'),
                                '#login'=>_l('Login'),
                                '#registration'=>_l('Registration') 
                            ]);  
  



//}