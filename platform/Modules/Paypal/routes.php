<?php 

/*
|--------------------------------------------------------------------------
| Paypal Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the Paypal module have to go in here. Make sure
| to change the namespace in case you decide to change the 
| namespace/structure of controllers.
|
*/
 
 
Route::group(['middleware' => 'web', 'namespace' => 'Platform\Modules\Paypal\Controllers'], function() {
     Route::get('/paypal/process/{order_id}', 'PaypalController@process');
     Route::get('/paypal/prepare/{order_id}/{total}', 'PaypalController@make_payment');
 }); 