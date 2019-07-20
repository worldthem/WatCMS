<?php
 return [
            'root_frontend'=>[
             "/"=>'HomeControler@home',
             "/home-real-live"=>'HomeControler@home',
             "/shop"=>'HomeControler@shop',
             "/wishlist"=>'ProductController@wishlist',
             "/wajax.jsp"=>['get','WajaxController@index'],
             "/wajax.jsp"=>['post','WajaxController@index'],
            
             //Products
             "/cat/{params?}"=>['get','ProductController@showproductfromcategory','where'=>['params','(.*)']],
              
             "/p/{id}"=>"ProductController@singleproduct_by_id",
             "/search/products"=>"ProductController@search",
             "/wajaxcall/mini-single/{id}"=>['post','ProductController@show_single'],
             "/product/{params?}"=>['get','ProductController@singleproduct','where'=>['params','(.*)']],
             "/setup-currency/{id}"=>['get','ProductController@setupcurrency'],
             "/pr/sort/{type}"=>['get','ProductController@sort'],
             
             //checkout
             "/steps/{params?}"=>['get','CartCheckoutController@index','where'=>['params','(.*)']],
             "/quick-buy/{productID}"=>['get','CartCheckoutController@quickBuy'],
             "/wajaxcall/get-shipping/{id}/{kg}"=>['post','CartCheckoutController@shipping_get'],
             "/upload-file/{id}/{orderid}"=> "Download@index",
           
             
             //Signup rute
             "/login"=>['get','UserController@showLoginPage','name'=>'login'],
             "/signup/login-data"=>['post','UserController@authenticate'],
             "/signup/logout"=>['get','UserController@logout'],
             "/signup/new"=>['post','UserController@registration'],
             "/signup/reset"=>['post','UserController@resetpass'],
             "/signup/new-password/{token}"=>['get','UserController@new_password'],
             "/signup/my-account"=>['get','UserController@myaccount'],
             "/signup/updatemyaccount"=>['post','UserController@updatemyaccount'],
             "/loginPage"=>['get','UserController@simpleLoginPage'],
             
             // Colect mails
             "/wajaxcall/subscrible"=>['post','ColectmailController@subscrible'],
             
             //page
             "/page/{cpu}"=>"PageController@index",
             "/page-content/{cpu}"=>"PageController@extrct_justcontent",
             
             //posts
             "/category/{params?}"=>['get','PostsController@index','where'=>['params','(.*)']],
             "/single/{params?}"=>['get','PostsController@single','where'=>['params','(.*)']],
             "/search/posts"=>"PostsController@search",
             
             //Analitics js
             //"/visits"=>"VisitsController@record",
             "/analitic/run"=>"VisitsController@analitycs",
              
              "/install"=>['get','Install\InstallController@install'],
              "/install/database"=>['post','Install\InstallController@database'],
              "/install/admin"=>['get','Install\InstallController@admin_create'],
              "/install/final"=>['post','Install\InstallController@final_step'],
               "/install/get-content"=>['get','Install\InstallController@get_content'],
            ],
            
            
            'root_admin'=>[
            
             //upload for tinimce
             "/admin/upload-tinimc"=>['post','Admin\AdminController@upload'],
             
            
              // Orders
             "/admin"=>['get','Admin\OrdersController@index'],
             "/admin/orders/status/{status}"=>['get','Admin\OrdersController@index'],
             "/admin/orders/status/{status}/{s}"=>['get','Admin\OrdersController@index'],
             "/admin/orders/bulk"=>['post','Admin\OrdersController@bulk_processing'],
             "/admin/vieworder/{id}"=>"Admin\OrdersController@viewOrder",
             "/admin/view-user-orders/{id}"=>"Admin\OrdersController@user_orders",
             "/admin/orders/change-status/{id}/{status}"=>"Admin\OrdersController@change_status",
             
             //Pages
              "/admin/page/{type}"=>"Admin\PageController@index",
              "/admin/page/add-edit/{id}/{type}"=>"Admin\PageController@create",
              "/admin/page/save"=>['post','Admin\PageController@store'],
              "/admin/page/del/{id}"=>"Admin\PageController@destroy",
              "/admin/page/check-block"=>['post','Admin\PageController@loadMore'],
              "/admin/page-enable/{id}"=>['get','Admin\PageController@enableDisable'],
              "/admin/page/destroy-bulk/{type}"=>['post','Admin\PageController@destroy_bulk'],
              "/admin/page/search/{type}/{s}"=>"Admin\PageController@index",
              "/admin/page/show-from-cat/{type}/{catid}"=>"Admin\PageController@showFromCategory",
              
             //Editable Blocks like header and footer
               "/admin/editable-blocks/{type}"=>"Admin\EditableBlocks@index",
               "/admin/editable-blocks/save"=>['post','Admin\EditableBlocks@store'],
              
             //ctegories
             "/admin/categories"=>"Admin\CategoriesController@index",
             "/admin/categories/{type}"=>"Admin\CategoriesController@index",
             "/admin/categories/add-edit/{type}/{id}"=>"Admin\CategoriesController@create",
             "/admin/update-categories"=>['post','Admin\CategoriesController@store'],
             "/admin/cat-hide-show/{id}/{action}"=>"Admin\CategoriesController@hide_show",
             "/admin/del-cat/{id}"=>"Admin\CategoriesController@destroy",
             "/admin/categories-bulk"=>['post',"Admin\CategoriesController@updatebulk"],
             
             
             //product
             "/admin/view-products"=>"Admin\ProductsController@index",
             "/admin/view-products/{s}"=>"Admin\ProductsController@index",
             "/admin/view-products/{s}/{author}"=>"Admin\ProductsController@index",
             "/admin/view-products-cat/{id}"=>"Admin\ProductsController@showproductfromcategory",
             "/admin/products-bulk"=>['post','Admin\ProductsController@updatebulk'],
             "/admin/move-prodduct-from-to-category"=>"Admin\CategoriesController@move_product_to_another_category",
             "/admin/product/{id}"=>"Admin\ProductsController@product_add_edit",
             "/admin/product-delete/{id}"=>"Admin\ProductsController@destroy",
             "/admin/product-hidde/{id}/{action}"=>"Admin\ProductsController@hide_show",
             "/admin/product-save"=>['post','Admin\ProductsController@store'],
             "/admin/upload-image/{type}"=>['post','Admin\ProductsController@upload_images'],
             "/admin/remove-image/{id}/{key}"=>['post','Admin\ProductsController@remove_image'],
             "/admin/product/upload-file"=>['post','Admin\ProductsController@upload_virtual'],
             "/admin/product/remove-file/{id}"=>['post','Admin\ProductsController@remove_file'],
             "/admin/product/upload/{id}/"=>"Admin\ProductsController@getdownloadable",
             "/admin/product/increase-price/"=>["post","Admin\ProductsController@increasePrice"],
             
             //import from csv
       
             "/admin/import-products"=>"Admin\ProductImportController@index",
             "/admin/import-step-one"=>['post','Admin\ProductImportController@upload_csv_step_one'],
             "/admin/import-step-two/{row_number}"=>"Admin\ProductImportController@select_data_from_csv",
             "/admin/import-step-three"=>['post','Admin\ProductImportController@import_products'],
             "/admin/import-step-4"=>"Admin\ProductImportController@importImages",
             "/admin/import-step-5"=>"Admin\ProductImportController@generateImage",
             
             
           //Variation, Specification
             "/admin/attributes/{type}"=>"Admin\AttributesController@index",
             "/admin/attributes/sugestion/{sugestion}"=>['post','Admin\AttributesController@get_sugestion'],
             "/admin/attributes/update"=>['post','Admin\AttributesController@addEditSugestion'],
             "/admin/attributes/remove/{type}/{id}"=>['post','Admin\AttributesController@removeSugestion'],
             "/admin/attributes-save"=>['post','Admin\AttributesController@store'],   
             "/admin/attributes-delete/{type}/{id}"=>"Admin\AttributesController@destroy",
             "/admin/attributes/remove-bulk"=>['post',"Admin\AttributesController@destroy_bulk"],
             
             //Settings
             "/admin/setting/standart/{type}"=>"Admin\StandartSettingsController@index",
             "/admin/setting/standart/store"=>['post','Admin\StandartSettingsController@store'],
             
             
             //shipping 
             "/admin/setting/shipping"=>"Admin\ShippingController@index",
             "/admin/setting/shipping/show-method/{country}"=>"Admin\ShippingController@index",
             "/admin/setting/shipping/destroy-bulk"=>['post','Admin\ShippingController@destroy_bulk'],
             "/admin/setting/shipping/destroy/{id}"=>"Admin\ShippingController@destroy",
             "/admin/setting/shipping/store"=>['post','Admin\ShippingController@store'],
             
             //Countries
             
             "/admin/setting/countries"=>"Admin\CountriesController@index",
             "/admin/setting/countries/destroy-bulk"=>['post','Admin\CountriesController@destroy_bulk'],
             "/admin/setting/countries/destroy/{id}"=>"Admin\CountriesController@destroy",
             "/admin/setting/countries/store"=>['post','Admin\CountriesController@store'],
             
             //statistic
             "/admin/statistic"=>"Admin\StatisticController@visits_last_month",
             "/admin/statistic/{date}"=>"Admin\StatisticController@visits_last_month",
             
             
             //Reviews/Comments
             
             "/admin/comments"=>"Admin\CommentsController@index",
             "/admin/comments/status/{status}"=>"Admin\CommentsController@index",
             "/admin/comments/status/{status}/{s}"=>"Admin\CommentsController@index",
             "/admin/comments/destroy-bulk"=>['post','Admin\CommentsController@destroy_bulk'],
             "/admin/comments/destroy/{id}"=>"Admin\CommentsController@destroy",
             "/admin/comments/comment-status/{id}/{status}"=>"Admin\CommentsController@change_status",
             
             
              // user controllers
             "/admin/users"=>"Admin\UsersController@index",
             "/admin/users/single/{id}"=>"Admin\UsersController@single",
             "/admin/users/search/{s}"=>"Admin\UsersController@index",
             "/admin/users/destroy-bulk"=>['post','Admin\UsersController@destroy_bulk'],
             "/admin/users/destroy/{id}"=>"Admin\UsersController@destroy",
             "/admin/users/store"=>['post','Admin\UsersController@store'],
          
             
             // Cuppon
             "/admin/cupon"=>"Admin\CuponController@index",
             "/admin/cupon/search/{s}"=>"Admin\CuponController@index",
             "/admin/cupon/destroy-bulk"=>['post','Admin\CuponController@destroy_bulk'],
             "/admin/cupon/destroy/{id}"=>"Admin\CuponController@destroy",
             "/admin/cupon/store"=>['post','Admin\CuponController@store'],
             "/admin/cupon/new"=>['post','Admin\CuponController@new_data'],
             
             //General Settins
             "/admin/general-settings"=>"Admin\GeneralController@index",
             "/admin/general-settings/store"=>['post','Admin\GeneralController@store'],
             "/admin/general-settings/language"=>['get','Admin\Language@index'],
             "/admin/general-settings/language/store"=>['post','Admin\Language@setLanguage'],
             "/admin/general-settings/language/fullTranslate"=>['post','Admin\Language@fullTranslate'],
             "/admin/general-settings/language/set"=>['post','Admin\Language@updateLanguage'],
             "/admin/language/translate/{lang}"=>['get','Admin\Language@translatePage'],
             
             //Menu
             "/admin/menu"=>"Admin\MenuController@index",
             "/admin/menu/store"=>['post','Admin\MenuController@store'],
             "/admin/menu/single/{id}"=>"Admin\MenuController@show",
             "/admin/menu/destroy/{id}"=>"Admin\MenuController@destroy",
             
              //Modules
             "/admin/modules"=>"Admin\ModulesController@index",
             "/admin/modules/store"=>['post','Admin\ModulesController@store'],
             "/admin/modules/activate/{module}"=>"Admin\ModulesController@activate",
             "/admin/modules/destroy/{module}"=>"Admin\ModulesController@destroy",
             
             //Themes
             "/admin/themes"=>"Admin\ThemesController@index",
             "/admin/themes/store"=>['post','Admin\ThemesController@store'],
             "/admin/themes/activate/{theme}"=>"Admin\ThemesController@activate",
             "/admin/themes/destroy/{theme}"=>"Admin\ThemesController@destroy",
             
             
              //Payments settings
             "/admin/payment"=>"Admin\PaymentController@index",
             "/admin/payment/activate/{module}/{type}"=>"Admin\PaymentController@activate",
             "/admin/payment/settings/{module}"=>"Admin\PaymentController@settings",
             "/admin/payment/store"=>['post','Admin\PaymentController@store'],
            
            //Widgets
             "/admin/widgets"=>"Admin\WidgetsController@index",
             "/admin/upload-simple/{type}"=>['post','Admin\AdminController@upload_images'],
             
             //Menu
             "/admin/contact-form"=>"Admin\ContactFormsController@index",
             "/admin/contact-form/store"=>['post','Admin\ContactFormsController@store'],
             "/admin/contact-form/single/{id}"=>"Admin\ContactFormsController@show",
             "/admin/contact-form/destroy/{id}"=>"Admin\ContactFormsController@destroy",
            // ""=>"",
            
             // Subscribe
             "/admin/subscribe"=>"Admin\SubscribeController@index",
             "/admin/subscribe/destroy-bulk"=>['post','Admin\SubscribeController@destroy_bulk'],
             "/admin/subscribe/search/{s}"=>"Admin\SubscribeController@index",
             "/admin/subscribe/export/{s}"=>"Admin\SubscribeController@export",
             
            //Settings
             "/admin/mail"=>"Admin\MailController@index",
             "/admin/mail/store"=>['post','Admin\MailController@store'],
             "/admin/mail/send-test"=>['post','Admin\MailController@sendTest'],
             
             "/admin/language/shareTranslate/{lang}"=>['post','Admin\AdminController@shareTranslate'],
             
           ]
     ];
 