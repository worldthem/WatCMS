<?php namespace App\Providers;
 
/**
* ServiceProvider
* The service provider for the Themes. 
* @package App\Providers
*/
class ThemeServiceProvider extends \Illuminate\Support\ServiceProvider
{
     
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {
       // For each of the registered modules, include their routes and Views
         
      try { 
        
        $theme = @\Wh::get_settings('_theme_name_','value');
        
       if(empty($theme)) return ;
           // Load the routes for activated theme
          
          if(file_exists(base_path('platform/Themes/'.$theme.'/routes.php'))) {
                require base_path('platform/Themes/'.$theme.'/routes.php');
            }
        
         } catch (\Exception $e) { 
            
         }  
         
    }

    public function register() {}

}
