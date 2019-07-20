<?php

namespace App\Http\Controllers\Admin;
use App\Modules\Settings; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactFormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $forms = Settings::where("param","_contact_forms_")->get();
        return view('admin.pages.contactforms', ['rows' =>$forms ]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $field = Settings::where("id",$id)->first();
          $row = json_decode($field->value1, true); 
          $title= $field->value;
          $value2= $field->value2;
          
         return view('admin.pages.contactforms', compact('row','id','title','value2'));
     
    }
 
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $id = $request->input('id'); 
          $new_form = '{"fields":{"name":["name1543742509882","name1543742510467","name1543742510842"],"label":["Name","Email","Message"],"placeholder":["Name","Email","Message"],"type":["text","text","text"],"required":["yes","yes"]},"submit":"Send Message","message":"Thank you we will be in touch soon!"}';
           
          $unic_id= $id=="new" ? rand(999,10000): $request->input('value2');
          $text=  $id=="new" ? $new_form:  @json_encode(@$request->input('value1'));
           
          $data = [
                'value'   =>@$request->input('value'),
                'value1'  => @$text,
                'value2'  => @$unic_id,
                'param'   => '_contact_forms_',
                  
            ];
            
            //print_r($data);
          Settings::updateOrCreate(
                          ['id' => $id ], $data
                         );
          
          return redirect()->back();
        
    }

   
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id)
    { 
        Settings::where('id', $id)->delete();
        return redirect()->back() ;            
    } 
    
}
