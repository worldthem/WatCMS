<?php

namespace App\Modules\Admin;
use App\Modules\Admin\Categories;
use App\Modules\Product;
use App\Modules\Gallery;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Upload;

class Import extends Model {
   
   
   /**
    * Split from csv the variation and main products
    */
 public function split_row($rowData=[], $condition_parent=[], $condition_parent_input=[]){
         
        // split the variation and main in separated array
        $main=[];
        $variation=[];
        $keySame= array_search('same', $condition_parent);
            // 
     foreach($rowData as $value){  
               $m="";
               // if any condition for main(parent) applay
               if(count($condition_parent)>0){
                   foreach($condition_parent as $key=>$cond){
                      if(($condition_parent[$key] == "empty" && empty($value[$key])) || $condition_parent[$key] == "notempty" && !empty($value[$key]) ){
                            $m="yes";
                           }else{ // if not any of condition then exit the for
                            $m="";
                            break; 
                         }
                    }
                } 
                
                // if any condition for main(parent) applay
               if(count($condition_parent_input)>0){
                   foreach($condition_parent_input as $key=>$cond){
                      if(strtolower($value[$key])==strtolower($cond)){
                            $m="yes";
                           }else{ // if not any of condition then exit the for
                            $m="";
                            break; 
                         }
                    }
                } 
                
                 
               
                if(!empty($m)){
                    if(in_array("same", $condition_parent) && !in_array($value[$keySame], $main) ){
                         $main[]=$value;
                         $variation[]=$value;
                      }else{
                        $main[]=$value;
                      }
                    }else{
                      if(in_array("same", $condition_parent) && !in_array($value[$keySame], $main) ){
                         $main[]=$value;
                      }
                      $variation[]=$value;
                   }
           }
           
          /*  
             echo count($main)."<br/>";
              print_r($main);
          
          echo "<br/><br/>";
            echo count($variation)."<br/>";
           // print_r($variation);
          
          return ;
         */
           
       return ['main'=>$main,'variation'=>$variation];    
  }
  
   /**
      * prepare array for insert or update
      */  
   
  public function prepare_data($array="", $value=[], $settings=[], $product='' ){
     $data = [];
     $construc_cat = new Categories();
     
      
     $meta = !empty($product) ?  @json_decode($product->meta,true) : []; 
     $attributes = !empty($product) ?  @json_decode($product->attr,true) : [];
     $optionsdata = !empty($product) ?  @json_decode($product->optionsdata,true) : [];
     $cat = !empty($product) ?  @json_decode($product->cat,true) : [];
      $gallery= [];
     foreach($array as $k=>$v){
               
                if(!empty($v)){
                    
                     if($v=="title"){
                       $data['title']= @$value[$k];
                       $data['cpu']= @str_slug(@$value[$k], '-');
                    }elseif($v=="SKU"){
                       $data['SKU']= @$value[$k];
                    }elseif($v=="qtu"){
                       $data['qtu']= @$value[$k];
                    }elseif($v=="metad"){
                       $meta['meta']['metad'] = @$value[$k];
                    }elseif($v=="metak"){
                       $meta['meta']['metak'] = @$value[$k];
                    }elseif($v=="id"){
                       $data['id']= @$value[$k];
                    }elseif($v=="cat"){
                       $c= @$construc_cat->insert_categories(@$value[$k]);
                       $cat = !empty($cat)? @array_merge($c, $cat) : $c;
                    }elseif($v=="brand"){
                      $c2= @$construc_cat->insert_categories(@$value[$k]);
                      $cat = !empty($cat)? @array_merge($c2, $cat) : $c2;
                    }elseif($v=="weight"){
                       $data['weight'] =  @round(@preg_replace('/[^0-9.]+/', '', $value[$k]), 2); 
                    }elseif($v=="price"){
                       $data['price'] =  @round($value[$k], 2); 
                    }elseif($v=="sale_price"){
                       $data['sale_price'] =  @round($value[$k], 2); 
                    }elseif($v=="text"){
                       $data['text'] = @str_replace('\n','<br/>',$value[$k]); 
                    }elseif($v=="description"){
                       $data['description'] = @str_replace('\n','<br/>',$value[$k]); 
                    }elseif($v=="cpu_store"){
                       $optionsdata['cpu_store']= @$value[$k];
                    }elseif($v=="main_image"){
                       $optionsdata['image'] = @$value[$k]; 
                    }elseif($v=="gallery"){
                       $gallery[] = @$value[$k]; 
                    }
                    $optionsdata['lang'] ="en";
                    $optionsdata['stock'] ="1";
                    
                    if(!isset($optionsdata['import'])){
                      $optionsdata['import'] ="not";
                    }
                    
                     if(!empty($settings)){
                         
                          foreach ($settings as $k1=>$v1){
                             if($v==$k1){
                                
                                   $key = array_search(@$value[$k], $settings[$k1]["sugestion"]);
                                   if($key === false){ 
                                       $settings[$k1]["sugestion"][] = @$value[$k]; 
                                       $key = count($settings[$k1]["sugestion"]) - 1;
                                     }
                                $attributes['specification'][$k1] = @$key; 
                               } 
                            }
                            
                        }
                        
                         
                    
                    }
              }
               
              
              $data['cat'] = @json_encode(array_values(array_unique($cat)));
              $data['optionsdata'] = @json_encode($optionsdata); 
              $data['attr'] = @json_encode($attributes); 
              $data['hide'] = 1;
               
        return ["data"=>$data, 'new_attrr'=>$settings, "gallery"=>$gallery];     
  }
  
 function prepare_variation($array="", $value=[], $attribute=[] ){
            $data = [];
             
     foreach($array as $k=>$v){
           if(!empty($v)){
                    if($v=="sku"){
                       $data[$v]= @$value[$k];
                     }elseif($v=="price"){
                       $data[$v]= @$value[$k];
                    }elseif($v=="qtu"){
                       $data[$v]= @$value[$k];
                    }elseif($v=="weight"){
                       $data[$v]= @$value[$k];
                    }
                    
                   foreach ($attribute as $k1=>$v1){
                       if($v==$k1){
                           //$data['variation'][$k1] = @$value[$k];
                                  $key = array_search(@$value[$k], $attribute[$k1]["sugestion"]);
                               if($key === false){ 
                                   $attribute[$k1]["sugestion"][] = @$value[$k]; 
                                   $key = count($attribute[$k1]["sugestion"]) - 1;
                                 }
                                   $data[$k1] = @$key;
                        } 
                      }
                 }
           }
       
  return ["data"=>$data, 'new_attrr'=>$attribute] ;   
}  
  
   /**
    * Insert images
    */
   public function import_images($post_id="",$directory='', $type=""){
          if(!empty($directory)){
              $data = ['id_post'=>$post_id, 
                       'directory'=>$directory,
                       'import'=>2];
              if(!empty($type)){
                  $data['main'] = 2;
              }
               Gallery::updateOrCreate(
                                    ['id_post' => @$post_id], $data
                               );
          }  
    }
    
    /**
     * Update id after insert we need to update the random id to the real one
     */
    public function update_gallery_id($id_post, $new_id_post){
       Gallery::where('id_post',$id_post)->update(['id_post',$new_id_post]); 
    }
   
   /**
    * Read CSV
    */
  
    public function read_csv($name, $separator=",", $rows=500000){
      
             $rowData = [];
             $row = 0;
             $nameFile = public_path('/csv/').$name;
           if(file_exists($nameFile)) { 
            if (($handle = fopen($nameFile, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 5000, $separator)) !== FALSE) {
                    $row ++ ;
                     $rowData[]= $data;
                    if($row==$rows) break; 
                }
                fclose($handle);
            }
           }
      
     return $rowData;
 }
 
 /**
  * Return product id by SKU
  */
 public function return_product_data($sku=""){
     $get = Product::where("SKU","=",$sku)
                //->orwhereRaw('JSON_CONTAINS(attr, \'{"sku":"'.$sku.'"}\')')
                ->select("id","optionsdata","attr","meta","cat")
                ->first();
      
     return !empty($get) ? $get : "";
 }
  
  
}