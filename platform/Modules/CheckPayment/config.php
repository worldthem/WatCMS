<?php
return [

/**
 * @urlsettings
 * 
 * Url to settings, enter it if you have one, if not leave empty
 * 
 * /admin/payment/settings/Strip - Url to settings option of module   
 * 
 */
'urlsettings'=>'/admin/payment/settings/CheckPayment',

/**
 * Any description of your theme or module
 */
'description'=>_l("Check Payment"),

/**
 * @run
 * Accept only one line 
 * 
 * 'run'=>'Controllers\SomeControler@run',
 */
'run'=>'',

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
'menu'=> '',

/**
 * @hooks
 * In this part are hooks, theo hooks are in some parts of theme where you want to run 
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
'hooks'=>'',

/**
 * @payment
 * 
 * Here we will add a new method of payment
 * 
 * 'payment'=>'Controllers\BankTransfer',
 *  
 * Controllers\BankTransfer - Path to your controller  
 */
 
'payment'=>'Controllers\CheckPayment',

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
 * ],
 * 
 * Controllers\Shortcode - is path to your controller what is in theme or Module
 * @- is separator
 * shortcode1- is method from you controller what should return something
 */
'shortcode'=>'',

/**
 * @adminmenu
 * 
 * 'adminmenu'=>[
          80 => ['#'=> _l('General Settings'),
                 '/admin/general-settings'=> _l('General Settings'),
                 '/admin/menu'=> _l('Menu'),
                 '/admin/modules'=> _l('Modules'),
               ],
        ]    
 * 
 */
'adminmenu'=>'',


];