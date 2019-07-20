<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\array_settings;
class StandartSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
         
         $array=[];
         $constant = VIEW_SETTINGS;
         
         if(isset($constant[$type])){
            $array=$constant;
         } 
         
         
          
         
         return view('admin.pages.page-settings', ['fields'=> $array[$type], 'type'=>$type, 'menu'=>$array['menu'] ]);
    }

     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function store(Request $request){
                $action_field = $request->input('action_field');
                 
                $data = $request->all();
                unset($data['_token']);
                unset($data['action_field']);
                
                 foreach($data as $k=>$v){
                    if(!isset($v['enable']) && ($k != "header" && $k != "enable")){
                        unset($data[$k]);
                    }
                 }
                \Wh::update_settings($action_field,  '',  json_encode($data) );
                 return redirect()->back();     
         }
     
}
