<?php

namespace App\Http\Controllers\Admin;

use App\Modules\Admin\Upload;
use App\Modules\Admin\Import;
use Illuminate\Http\Request;
use App\Modules\Product;
use App\Modules\Gallery;
use App\Modules\Admin\Categories;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductImportController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.productimport');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_csv_step_one(Request $request)
    {
        $rows = $request->input('rows');
        $separator = $request->input('separator');
        $upload = new Upload();
        $import = new Import();
        $name = $upload->upload_csv($request, "import" );
        
         \Wh::update_settings('import_data_from_csv_file_name', $name);
         \Wh::update_settings('import_data_from_csv_separator', $separator);
         
        $rowData = $import->read_csv($name, $separator, $rows);
           
          
       return view('admin.pages.productimport', ['row'=>$rowData]); 
         
    }
    
    
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function select_data_from_csv($row_number=0)
    {
         $import = new Import();
         
         $name=  \Wh::get_settings('import_data_from_csv_file_name' );
         $separator= \Wh::get_settings('import_data_from_csv_separator' );
         
         $rowData = $import->read_csv($name, $separator );
         
         if($row_number != 0){
          $Data[0]= @$rowData[0];
         }
         $Data[1]= @$rowData[$row_number];
         $count1 = @count($rowData[0]);  
         $count2 = @count($rowData[$row_number]);
         //check withc count is big 
         $count = @$count1> $count2 ? $count1 : $count2;
          
        return view('admin.pages.productimport', ['row_single'=>$Data, 'count_total'=>$count]); 
   }
    
        
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import_products(Request $request)
     {
          $import = new Import();
         
          $name=  \Wh::get_settings('import_data_from_csv_file_name' );
          $separator= \Wh::get_settings('import_data_from_csv_separator' );
         
          $rowData = $import->read_csv($name, $separator );
          
          
          $parent = $request->input('parent');
          $child = $request->input('child');
          $images = $request->input('images');
          $condition_parent = @array_filter($request->input('condition_parent'));
          $condition_parent_input = @array_filter($request->input('condition_parent_input'));
           
          $condition_child = @array_filter($request->input('condition_child'));
          reset($condition_child);
          $var_key = key($condition_child);
          
          //get SKU key 
           $key_SKU= array_search('SKU', $parent);
          
           
           
           $split = count($condition_parent)>0 || count($condition_parent_input)>0 ? $import->split_row($rowData, $condition_parent, $condition_parent_input) :
                                               ['main'=>@$rowData,'variation'=>[]];
           
            //printw($split); 
            
           $settings_specification= @json_decode(\Wh::get_settings('specification_list', "value1"), true);
           $settings_variation= @json_decode(\Wh::get_settings('variation_list', "value1"), true);
           $attributes = @\Wh::get_variation("_attributes_");
           $i=0; 
           $i_main= 0;
           $i_variation = 0;
           $new_data= [];
           
           foreach($split['main'] as $value){
                 $real_id='';
                
                 $product = $key_SKU !== false ?  @$import->return_product_data($value[$key_SKU]): "";
                 $formated_data = $import->prepare_data($parent, $value, $attributes['specifications'], $product);
                 $data =@$formated_data["data"];
                 $attributes['specifications'] = @$formated_data["new_attrr"]; 
                 
                  if(empty($data['SKU'])){
                    $real_id=Product::insertGetId($data);
                    $i_main++;
                  }else{
                    
                  if(!empty($split['variation'])){ 
                          $variation=[];
                          $qtu = 0;
                          $check= "";
                         foreach($split['variation'] as $val){
                             if($val[$var_key]==$data['SKU']){
                                $formated_var = $import->prepare_variation($child, $val, $attributes['variations'], $product );
                                
                                $attributes['variations']= $formated_var['new_attrr'];
                                $variation[]= @$formated_var['data'];
                                $qtu = $qtu + intval(@$formated_var['data']['qtu']);
                                $check= "is";
                                
                                $i_variation ++;
                             }
                         }
                         
                         if(!empty($check)){ 
                              $get_attr = @json_decode($data['attr'],true);
                              $get_attr['variation'] = $variation;
                              $data['attr'] =  json_encode($get_attr); 
                              $data['qtu'] =  $qtu; 
                          }
                         
                    }
                    
                         $object = Product::updateOrCreate(
                                    ['SKU' => @$data['SKU']], $data
                               );
                               
                        //$new_data[]=$data;         
                        $real_id = $object->id;          
                    $i_main++;           
                  }
                  
                   if(!empty($formated_data["gallery"])){
                    $import->import_images($real_id, @json_encode(@$formated_data["gallery"]));
                   }
                  
                  //$import->update_gallery_id($id_post, $real_id); 
                $i++;
               // if($i==1200)break;
            }
           
            
           
          
           if(!empty($attributes)){
                  foreach($attributes as  $v_new){
                   foreach($v_new as $k_1 => $v_1){ 
                     @\Wh::update_settings($k_1,  "", json_encode( $v_1['sugestion']));
                   } 
                  }
              }
            
            
            
           $updated = [$i_main,$i_variation];
          
        return view('admin.pages.productimport', ['final'=>"final", 'updated'=>$updated]); 
   }
    
    
   public function importImages(){
      return view('admin.pages.productimport', ['images_import'=>"yes" ]); 
   } 
  
   public function generateImage(){
      $path_import= public_path('import');
      $path_images= public_path('imgproduct');
      $get_products = Product::where('product.optionsdata->import','like', '%not%')
                             ->leftJoin('gallery', 'product.id', '=', 'gallery.id_post')
                             ->select('product.id','product.optionsdata', 'gallery.id as galid', 'gallery.directory', 'gallery.import')
                             ->paginate(50);
       
       if(!empty($get_products)){ 
         foreach($get_products as $value){
          $main= @json_decode($value->optionsdata, true);
          $gallery = @json_decode($value->directory, true);
          
          if(!empty($main['image'])){
              $img= $this->move_and_crop($main['image']);
              $main["import"]= "yes";
              $main["image"]= $img;
               Product::where("id",$value->id)->update(['optionsdata'=>@json_encode($main)]);
            }
          
           if(!empty($gallery)&& $value->import == "2"){
            $new_array=[];
             foreach ($gallery as $v){
                 $new_array[]= $this->move_and_crop($v);
              }
             
             Gallery::where("id",$value->galid)->update(['directory'=>@json_encode($new_array), 'import'=>'4']);
           }
            
        
       }
      }
        $count = count($get_products);
    
       return $count>0? "continue": "done"; 
   }
   
 private function move_and_crop($img=""){
    $path_import= public_path('import');
    $path_images= public_path('imgproduct');
     
    if(!File::exists($path_import."/".$img) || empty($img)){ 
       return "noimage.jpg";
     }
     
    $extension = @explode(".",$img);
    $extension = @end($extension);
    $new_name= \Wh::get_random(25).'.'.$extension; 
    
     
    if (strpos($img, '/') !== false) {
        $img_name = @explode("/",$img);
        $img_name = @end($img_name);
        $img_new = @str_replace($img_name, $new_name, $img);
     }else{
        $img_new =$new_name;
     }
      
       File::move($path_import."/".$img, $path_images."/".$img_new);
       \Wh::resize_crop_image(255, 383, $path_images."/".$img_new,  $path_images."/thumb_".$new_name, 90);
         
    return $img_new;
 }   
   
}
