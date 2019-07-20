<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

 
use App\Http\Controllers\Controller;
use App\Modules\Visits;
//use App\Modules\DBCity;
 

class StatisticController extends Controller
{
    function visits_last_month($date=""){
        
         //$city= new DBCity();
         //$info = $city->return_location();
         require app_path("Helpers/GeoLocation/geoip.php");
         
      $query =empty($date)? Visits::whereRaw('date > DATE_SUB(NOW(), INTERVAL 1 MONTH)')
                                  ->orderBy('date', 'asc')
                                  ->get() :
                            Visits::where("date",$date) 
                                  ->orderBy('date', 'asc')
                                  ->get() ;
              
           $date_count=[];  
           $country = [];
           $Source = []; 
           $page_visit=[];
           
           $json_IP = file_get_contents(app_path("Helpers/GeoLocation/IPList.json"));
           $json_IP = json_decode($json_IP, true); 
           $json_IP['geoipcount'] = count($json_IP['geoipaddrfrom']);
           $json_IP['geoipcache'] = [];
           
          foreach($query as $one){ 
             $date_count[$one->date][] =  [$one->url,$one->user_agent,$one->pagevisit,$one->country,$one->city,$one->browser_language];
             //$country_info = $info->get();
             $country_info = getCountryFromIP($json_IP, $one->ipvisit, " NamE ");
              
             $country[@$country_info][] = @$country_info;
             $url= empty($one->url)? "Direct":$one->url;
             $Source[$url][] = [$url];
             $page_visit[]= [@$country_info." ".$one->ipvisit,$one->pagevisit];  
          }             
                 
                      
         return view('admin.pages.statistic', ['general' => $date_count,'country'=>$country,'source'=>$Source,"page_visit"=>$page_visit]);                 
        
    }
    
    
}