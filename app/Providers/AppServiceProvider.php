<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        
        \View::addNamespace('theme', base_path() . "/platform/Themes/"._THEME_NAME_."/");
        //\View::addNamespace('theme', base_path() . "/resources/views/themes/"._THEME_NAME_."/");
        \View::addNamespace('assets', base_path() . "/resources/assets/");   
             
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../Helpers/constant.php';
        require_once __DIR__ . '/../Helpers/helpers.php';
        require_once __DIR__ . '/../Helpers/config.php';
   }
}