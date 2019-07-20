<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Route;
use App\Modules\Visits;

class VisitsController extends Controller
{
     
 public function analitycs(Request $request){
        
        //$userAgent1 = @(string) request()->server('HTTP_USER_AGENT');
        //$userAgent2 = @(string) request()->header('User-Agent');
        //$userAgent = @!empty($userAgent2) ? $userAgent2 : $userAgent1;
        $userAgent = $request->get('userAgent');
        $referer =$request->get('referer'); 
        $url = $request->get('previos');
        
        // if is cron then ignore
        if( (strpos(\Request::ip(), "174.136.57") !== false) || 
             \Wh::instring("google", @$userAgent ) || 
             \Wh::instring("baidu", @$userAgent) ||
             \Wh::instring("bot", @$userAgent) 
             ){ 
                return '';
            } 
       
         
     try {    
      $query = Visits::where('ipvisit',\Request::ip())
                        ->where('date',date("Y-m-d"))
                        ->select('id','pagevisit')
                        ->first();
                    
           // $referer = (string) request()->path(); 
           // $url = @str_replace(\URL('/'), '', \URL::previous());
             
       if(empty($query->id)){
        Visits::create([
            'ipvisit' => @(string) request()->ip(),
            'url' => @$url,
            'pagevisit' => @json_encode([$referer]),
            'user_agent' => @$userAgent,
            'date' => date("Y-m-d"),
            'browser_language' => @(string) request()->server('HTTP_ACCEPT_LANGUAGE'),
        ]);
        }else{
            $pageVisit=  @json_decode($query->pagevisit, true);
           if(!in_array(@$referer,@$pageVisit)){
            $pageVisit[] = @$referer;
                Visits::where('id',$query->id)
                       ->update(['pagevisit' => @json_encode($pageVisit)]);
            }
        }
         
         } catch (\Exception $e) {
           return  "" ;  
        }
    
 }
 
    
}