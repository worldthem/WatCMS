<?php

return [

/**
 * @menu
 *  This part will be the menu for theme,If you want to registre any menu just registr it here
 * Example: 
 * 'menu'=>[  'topMenuLogin'=>_l('Top menu when user is login'),
              'topMenuNOTLogin'=>_l('Top menu when user is NOT login'),
              'main'=>_l('Main menu'),
              'footer'=>_l('Footer Menu'),
           ],
  
* 
* and get it in your theme is just like:
* 
* <ul>{!! \Wh::get_menu("topMenuLogin") !!}</ul>
* OR
* <ul>{!! \Wh::get_menu("main") !!}</ul>          
 */
'menu'=>[  'topMenuLogin'=>_l('Top menu when user is login'),
           'topMenuNOTLogin'=>_l('Top menu when user is NOT login'),
           'main'=>_l('Main menu'),
           'footer'=>_l('Footer Menu'),
           ],

/**
 * @hooks
 * In this part are hooks, the hooks are in some parts of theme where you want to run 
 * some function code when people access that page
 * for example:  in some part of your .blade.php is this code
 * {!! \Wh::hooks('afterCheckoutButton') !!} 
 * afterCheckoutButton- is hook name, some of them are defoult some of them are 
 * named by you(the creator of theme)
 * how to declare:
 * 
 * 'hooks'=>['afterCheckoutButton'=>'Controllers\Banner@payment',
 *           'header'=>'Controllers\Header@js_css',
 *           .....
 * ],
 * 
 * Controllers\Banner - is path to your controller what is in theme or Module
 * @- is separator
 * payment- is method from you controller what should return something
 */
'hooks'=>[],

/**
 * @widgets
 * In this part are widgets, the widgets are in some parts of theme where you want to run 
 * some function code when people access that page
 * for example:  in some part of your .blade.php is this code
 * {!! _widgets('leftsidebar') !!} 
 * afterCheckoutButton- is widget name, some of them are defoult some of them are 
 * named by you(the creator of theme)
 * how to declare:
 * 
 * 'widgets'=>['leftsidebar'=>'Controllers\Banner@payment',
 *             'header'=>'Controllers\Header@js_css',
 *           .....
 * ],
 * 
 * Controllers\Banner - is path to your controller what is in theme or Module
 * @- is separator
 * payment- is method from you controller what should return something
 */
'widgets'=>[],
 
/**
 * @shortcode
 * In this part are shortcode, the short code are used in page for example:
 *  
 * [shortcode1]  -
 * [shortcode2 id=5]
 * 
 * how to declare:
 * 'shortcode'=>['shortcode1'=>'Controllers\Shortcode@shortcode1',
 *               'shortcode2'=>'Controllers\Shortcode@shortcode2',
 *               .....
 *               ],
 * 
 * Controllers\Shortcode - is path to your controller what is in theme or Module
 * @- is separator
 * shortcode1- is method from you controller what should return something
 */
'shortcode'=>[],


/**
 * @payment
 * 
 * Here we will add a new method of payment
 * 
 * 'Controllers\BankTransfer' 
 *  
 * Controllers\BankTransfer - Path to your controller 
 *  
 */
'payment'=>'',

/**
 * @adminmenu
 * 
 * 'adminmenu'=>[
                  82 => ['#'=> _l('General Settings'),
                         '/admin/general-settings'=> _l('General Settings'),
                         '/admin/menu'=> _l('Menu'),
                         '/admin/modules'=> _l('Modules'),
                        ] 
                 ]    
 * 
 */
'adminmenu'=> [],
/**
 * @removeAdminMenu
 * This function will remove the admin menu top menu
 * 
 * 'removeAdminMenu'=> [10,20,30,.....]
 * [10,20,30,.....] -is the keys of menu 
 * check the path app/Helpers/config.php  - define("ADMIN_MENU",
 * 10 - eCommerce
 * 20 - Statistic
 * 30 - Pages
 * 40 - Blog
 * 50 - Products   
 * 60 - Checkout
 * 70 - Users
 * 80 - General Settings
 * 800 - Log out
 */
 
'removeAdminMenu'=> [],
/**
 * @customLinks
 * This part you can add new links for sugestion in menu on box "Custom Link"
 * 
 *  'customLinks'=> [
           '/wishlist'=>_l('Wishlist'),
      ],
 */

'customLinks'=> [],


/**
 * @pageType
 * 
 * If you want to add new post type you can do it here
 * 
 *  'customLinks'=>  [ 'pages'=>['cpu','metad','metak'],
                       'posts'=>['cpu','metad','metak','cat','image'],          
                       'emails'=>['subject','enable'],
                       'tabs'=>[ 'enable','sort']
                     ],
 */

'pageType'=> [],


/**
 * @categoriesType
 * 
 * Link type of categories wit type of post 
 * 
 *  'customLinks'=>  [ 'product'=>["product"=>_l('Product categories'),
                                   "brand"=>_l('Brands')],
                       'posts'=>["posts"=>_l('Categories'),
                                 "tags"=>_l('Tags'),]
                     ],

if you want to add new cat type to products bellow is an example:
['product'=>["product"=>_l('Product categories'),
             "brand"=>_l('Brands'),
             "yourcat"=>"Your Cat Name"],
],

*/

'categoriesType'=> [],
 
/**
 * Any description of your theme or module
 */
'description'=>_l("Default theme.")
];