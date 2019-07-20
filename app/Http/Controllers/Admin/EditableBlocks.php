<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Settings;

use App\Modules\Admin\Categories;
use App\Modules\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditableBlocks extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type='', Request $request)
    {
         $editor= $request->get("editor") ?? 'builder';
         $page = Settings::where('param',$type)->first();
         $val = @explode("~~~~~",@$page->value1) ;
         $jsondata =  $editor =='editor' ?  [] : @json_decode($val[0], true);
         $page = $editor =='editor' ? @$page->value1 : @$val[1];
         
         return view("admin.pages.editableblcoks",compact('page' ,'type','jsondata','editor')); 
    }
 
 
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
          $meta = @json_encode(['lang'=>'en',  
                                'style' =>@$request->input('style'),
                                'cssdirect' =>@$request->input('cssdirect'),
                               ]);
                               
          $param =  $request->input('param') ?? '';
          $editor =  $request->input('editor') ?? '';
          $data = [
                 'param'     => @$param,
                 'value1'    => @$editor =='editor' ? @$request->input('text') :  @$meta."~~~~~".@$request->input('text'),
                 ];
            
          Settings::updateOrCreate(
                          ['param' => $param ], $data
                         );
          
          return redirect()->back();
    }
     
}    