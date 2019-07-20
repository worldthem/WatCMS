<?php 

/*
|--------------------------------------------------------------------------
| Stripe Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the Stripe module have to go in here. Make sure
| to change the namespace in case you decide to change the 
| namespace/structure of controllers.
|
*/
 
 
Route::group(['middleware' => 'web', 'namespace' => 'Platform\Modules\Stripe\Controllers'], function() {
     Route::get('/stripe/make-payment/{json}', 'StripeController@make_payment');
 }); 