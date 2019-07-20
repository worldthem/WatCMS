<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Cupon;
 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($s="" )
    {
        if (empty($s)){
            $Cupon=Cupon::orderby("id",'desc')->whereNull('publish')->paginate(50);
        }else{
             $Cupon=  Cupon::where("cupon",'like','%'.$s.'%')
                            ->whereNull('publish')
                            ->orderby("id",'desc')
                             ->paginate(50);
         }
         
       
        return view('admin.pages.cupon', ['rows' => $Cupon ,"getvar" =>  @$s ]); 
    }
 
     
     /**
     * Edit the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function store (Request $request)
        { 
            $field = @$request->input('field');
            $id = @$request->input('id');
            $data = @$request->input('data');
            
             
            
              $data = [ $field  => $data ];
          
              Cupon::updateOrCreate(
                              ['id' => $id ], $data
                             );
             
           return  "<span class='fa_publish'></span>" ;            
        } 
        
        /**
         * Add specified resource in storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function new_data (Request $request)
        { 
                $id = @$request->input('id');
                 $data = [];
                 
                 $table_columns=new Cupon();
                 $columns=$table_columns->getTableColumns();
                  
             
             foreach(@$request->all() as $k=>$v){
                if(($k !='_token' && $k !='id') &&  in_array($k, $columns)){
                   $data[$k] =  $request->input($k);
                }
             }
          
              Cupon::updateOrCreate(
                              ['id' => $id ], $data
                             );
             
           return redirect()->back() ;            
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
            $s = $request->input('s');
          if(!empty($action) && empty($s)){
              
              foreach ($productid as $val){
                 if($action=='del'){
                         Cupon::where('id', $val)->update('publish','trash');
                     }  
                 }
           }
           
       return !empty($s)? redirect('/admin/cupon/search/'.$s) :  redirect()->back() ;
    }

  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    { 
        Cupon::where('id', $id)->update('publish','trash');
        return redirect()->back() ;            
    } 
    
    
}
