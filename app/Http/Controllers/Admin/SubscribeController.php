<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Colectmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($s="" )
    {
        if (empty($s)){
            $rows=Colectmail::orderby("id",'desc')->paginate(50);
        }else{
             $rows=  Colectmail::where("email",'like','%'.$s.'%')
                                  ->orderby("id",'desc')
                                  ->paginate(50);
        }
   
        
        return view('admin.pages.subscribe', ['rows' => $rows,"getvar" =>  @$s ]); 
    }
    
     public function destroy_bulk(Request $request)
    {
          $rowid = $request->input('rowid');
           $action = $request->input('action');
            $s = $request->input('s');
          if(!empty($action) && empty($s)){
              
              foreach ($rowid as $val){
                 if($action=='del'  ){
                         Colectmail::where('id', $val)->delete();
                     }  
                 }
           }
           
       return !empty($s)? redirect('/admin/subscribe/search/'.$s) :  redirect()->back() ;
    }
    
     public function export($s='')
      {
       if (empty($s) || $s=="all"){
             $rows=Colectmail::orderby("id",'desc')->get();
        }else{
             $rows=  Colectmail::where("email",'like','%'.$s.'%')
                                  ->orderby("id",'desc')
                                  ->get();
        }
        
          $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=subscribers.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

             
            $columns = ['Email', 'Date'];
        
            $callback = function() use ($rows, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
        
                foreach ($rows as $val){
                    fputcsv($file,  [$val->email, $val->date]);
                }
                fclose($file);
            };
            
            return Response::stream($callback, 200, $headers);
          
     }
    
}