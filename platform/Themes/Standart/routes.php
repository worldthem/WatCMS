<?php 

/*
|--------------------------------------------------------------------------
| Beauty Routes
|--------------------------------------------------------------------------
|
| All the routes related to the Beauty theme have to go in here. Make sure
| to change the namespace in case you decide to change the 
| namespace/structure of controllers.
|
*/
 
// front end routes
Route::group(['middleware' => 'web', 'namespace' => 'Platform\Themes\Beauty\Controllers'], function() {
   //Route::get('/just-test-result', 'Test@run');
}); 

//admin routes
Route::group(['middleware' =>  ['CheckRole'], 'roles' =>'admin', 'namespace' => 'Platform\Themes\Beauty\Controllers'], function () {
    
});