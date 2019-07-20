<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Shippcountry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
       $countries= Shippcountry::get();
        return view('admin.pages.countries', ['rows' => $countries]);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
        $country = @$request->input('country');
        $code = @$request->input('code');
        
        $field = @$request->input('field');
        $id = @$request->input('id');
        $data = @$request->input('data');
        
        $data = !empty($field)?
          [ $field  =>$data ]: [  'country'  =>$country, 'code' =>$code ];
          
            //print_r($data);
          Shippcountry::updateOrCreate(
                          ['id' => $id ], $data
                         );
         
       return  !empty($field)? "<span class='fa_publish'></span>": redirect()->back();
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_bulk(Request $request)
    {
          $productid = $request->input('productid');
           $action = $request->input('action');
          if(!empty($action) && empty($s)){
              
              foreach ($productid as $val){
                 if($action=='del'){
                        Shippcountry::where('id', $val)->delete();
                     } 
                     
                 }
           }
      return redirect()->back() ;
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    { 
       Shippcountry::where('id', $id)->delete();
       return redirect()->back() ;            
    }
}
