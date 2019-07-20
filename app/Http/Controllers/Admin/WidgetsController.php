<?php
namespace App\Http\Controllers\Admin;
use App\Modules\Settings;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WidgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //$settings = Settings::where('param','_website_menu_')->orderBy("id",'desc')->get();
         //return view("admin.pages.widgets",['rows'=>$settings]); 
    }
 
 
  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          
     
    }
 
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         /* 
          $id = $request->input('id');  
          
          $data = [
                'value'   =>@$request->input('value'),
                'value1'  => @$request->input('value1'),
                'value2'  => @$request->input('value2'),
                'param'   => '_website_menu_',
                  
            ];
            
            //print_r($data);
          Settings::updateOrCreate(
                          ['id' => $id ], $data
                         );
          
          return redirect()->back();
          */
        
    }

   
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    { 
        //Settings::where('id', $id)->delete();
        //return redirect()->back() ;            
    } 

     
}
