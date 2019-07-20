<?php namespace App\Providers;
 
/**
* ServiceProvider
* @package App\Providers 
*/
class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {
        
        
        // For each of the registered modules, include their routes and Views
        try { 
        
        $modules = @\Wh::get_settings_json('_active_modules_');
        
       if(empty($modules)) return ;
        
        foreach($modules as $module){
            // Load the routes for each of the modules
            if(file_exists(base_path('platform/Modules/'.$module.'/routes.php'))) {
                require base_path('platform/Modules/'.$module.'/routes.php');
            }
 
            // Load the views
            if(is_dir(base_path('platform/Modules/'.$module.'/Views'))) {
                 $this->loadViewsFrom(base_path('platform/Modules/'.$module.'/Views'), $module);
            }
         }
          
        } catch (\Exception $e) { 
            
         }
         
    }

    public function register() {}

}
