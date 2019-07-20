<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      try {   
        if(defined('_MAIN_OPTIONS_')){
            $app_url = \Wh::constant_key(_MAIN_OPTIONS_,  "_website_url_"); 
       
            if ( !$request->secure() && substr($app_url, 0, 8) === 'https://' ) {
                return redirect()->secure($request->getRequestUri());
            }
        }
       } catch (\Exception $e) { }  
       
        return $next($request);
    }
}