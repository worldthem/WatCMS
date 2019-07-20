<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
 $root= \File::exists(app_path("Helpers/roots.php"))? require app_path("Helpers/roots.php") : []; 
 
 Route::group(['middleware' => 'web','root'=>$root], function() use ($root) {
    \Wh::sort_root($root['root_frontend']);
  // Auth::routes();
 });


Route::group(['middleware' =>  ['CheckRole'], 'roles' => 'admin','root'=>$root], function () use ($root) {
     \Wh::sort_root($root['root_admin']);
 });
