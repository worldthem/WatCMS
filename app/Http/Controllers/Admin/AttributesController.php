<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Settings;
class AttributesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    //public $name_setting = "variation_list";
     
    public function index($type="") {
          
         $input_list = ['specifications'=>['title'=>'Title','type'=>'Type','sugestion'=>'Value(one per line, if <strong>Type is : Select or Checkbox</strong>)'],
                        'variations'=>['title'=>'Title','type'=>'not','sugestion'=>'Sugestion(<strong>One per line</strong>)']];
        
         $data = @\Wh::get_settings_json("_attributes_");
          
         return view('admin.pages.attributes', ['data' => @$data[$type], 'fields'=>@$fields[$type], 'input_list'=>@$input_list[$type], 'type_field'=>$type ]);
    }
   
    public function get_sugestion($sugestion="") {
         
         return view('admin.layouts.sugestion', ['data' => @\Wh::get_settings_json($sugestion), 'sugestion'=>$sugestion]);
    }
    
    
  public function destroy_bulk(Request $request)
    {
           $rowid = $request->input('rowid');
           $action = $request->input('action');
           $attrID = $request->input('attrID');
           $data_settings= @\Wh::get_settings_json($attrID);
            
          if(!empty($action)){
             if($action=='del' ){  
                  foreach ($rowid as $val){
                    unset($data_settings[$val]);
                  } 
                \Wh::update_settings($attrID, '',json_encode($data_settings, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));   
              }
           }
           
       return  view('admin.layouts.sugestion', ['data' => @$data_settings, 'sugestion'=>$attrID]) ;
    }
    
     public function addEditSugestion(Request $request) {
         $attributeID = @$request->input("attributeID");
         $title = @$request->input("title");
         $id = @$request->input("id");
         $return = @$request->input("return");
         $data_settings= @\Wh::get_settings_json($attributeID);
          
         if($id=="new"){
            $t= preg_split('/\r\n|\r|\n/', $title);
            foreach($t as $ittem){
               $data_settings[\Wh::get_random(3)] = @$ittem;
            }
         }else{
            $data_settings[$id] = $title;
         }
         
         \Wh::update_settings($attributeID, '',json_encode($data_settings, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
         
         return empty($return)? view('admin.layouts.sugestion', ['data' => @$data_settings, 'sugestion'=>$attributeID]) : "ok" ;
    }
    
       
     public function removeSugestion($sugestion='',$id='') {
         $data_settings= @\Wh::get_settings_json($sugestion);
         unset($data_settings[$id]);
         \Wh::update_settings($sugestion, '',json_encode($data_settings, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
         
         return view('admin.layouts.sugestion', ['data' => @$data_settings, 'sugestion'=>$sugestion]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)  {
          $field_type = $request->input('field_type');
          $id = $request->input('id');
          
          $name = $request->input('title');
          $type = $request->input('type');
          $sugestion = $request->input('sugestion');
          
          $json =  @\Wh::get_settings_json("_attributes_");
         
          foreach($id as $k=>$value){
          
          $array =  [ 'name'=>$name[$k],
                      'type'=>$type[$k] 
                    ];
           
          $json[$field_type][$k] = $array;
           
          \Wh::update_settings("_attributes_", "", json_encode($json, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) );
          
          }
           
          return redirect()->back();
    }
    
  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($type="",$id){
           $json = @\Wh::get_settings_json("_attributes_");
           unset($json[$type][$id]);
           \Wh::update_settings("_attributes_", "", json_encode($json, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) );
           Settings::where('param', $id)->delete();
       return redirect()->back();
    }
     
}
