<?php namespace App\Http\Controllers\Admin;

use App\Modules\Admin\Categories;
use App\Modules\Product;
use App\Modules\Gallery;
use App\Modules\FileUpload;
use App\Modules\Admin\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class ProductsController extends Controller
{
    
    public function __construct() {  
         //$this-> quickChanges('2') ;
    }
    /**
     * Some Examples how to work with json maybe will need some time who knows
     *     
            $users = Product::whereRaw('JSON_CONTAINS(gallery->"$[*].color",\'"blue"\')')
            $users = Product::whereRaw('JSON_CONTAINS(gallery, \'{"color":"blue"}\')')
            $users = Product::where('gallery->title','like', '%afone%')
                 
                   ->first();
                   printw($users);
             
             $adsa = Product:: where("optionsdata->date", '>', date("Y-m-d"))->paginate(20);
             
             foreach($adsa as $d){
                echo "".$d->id."<br />";
              }   
            
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index($s="",$author="") {
         
           $product = Product::orderBy("id",'desc');
            
          if(!empty($s) && empty($author)){
           $product = $product->where('title','like','%'.$s.'%')
                      ->orWhere('text','like','%'.$s.'%')
                      ->orWhere('description','like','%'.$s.'%');
          } elseif(!empty($author)){
           $product = $product->where('user_id','=',$author);
          }                                
                                           
          $paginate = $product->paginate(50);                          
         
          return view('admin.pages.productlist', ['products' => $paginate, 'urlis'=>'', 'cat_url'=> \Wh::show_array(), 'count_products'=> @$product->count()]);
    }
    

       /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function showproductfromcategory($idcat ){
           $get_id =Categories:: where('id',$idcat)
                                ->first();
           
           $product = Product::whereJsonContains('cat', [intval($idcat)]) ; 
           $paginate= $product->paginate(50);
              
       return view('admin.pages.productlist', ['products' => @$paginate,'id_cat'=>@$get_id->id, 'catname'=>@$get_id->title, 'cat_url'=> \Wh::show_array(), 'count_products'=> @$product->count()]);
    }
    
    
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatebulk(Request $request)  {
       
          $action = $request->input('action');
          $cat = $request->input('category_id');
          $productid = $request->input('productid');
          $s = $request->input('s'); 

          if(!empty($action) && empty($s)){
              
              foreach ($productid as $val){
                if(!empty($cat) && $action=='move'){ 
                    
                     Product::where('id', $val)
                        ->update(['cat' => json_encode([$cat])]);
                     
                     }elseif($action=='del'){
                        //Product::where('id', $val)->delete();
                        $this->destroy($val, "nothing");
                     }elseif($action=='hide'){
                        Product::where('id', $val)
                                ->update(['hide' => NULL]);
                     }elseif($action=='visible'){
                        Product::where('id', $val)
                                ->update(['hide' => 1]);
                     }
                     
                 }
           }
          
        return !empty($s)? redirect('/admin/view-products/'.$s) :  redirect()->back() ;
    }
    
    /**
     *  Upload images for product
     */
    public function upload_images(Request $request, $type="")  {
        
                $parent_id = $request->input('parent_id');
                $upload = new Upload();
                $val = $upload->upload($request);
                
                  if($type=="main"){
                     return  \Wh::return_main_image($val[0]); 
                   }
                
                $get = Gallery::where('id_post', @$parent_id)->first();
                if(!empty($get)){
                   $existing = json_decode($get->directory);
                   $val = !empty($existing)? array_merge($existing, $val) : $val; 
                }
                
                 Gallery::updateOrCreate(
                               ['id_post' => @$parent_id ],  
                               ['id_post' => @$parent_id, 
                                 'directory' => json_encode($val)]
                              );
                  
                
            return \Wh::get_admin_gallery($parent_id);   
     }
    
   
    
    /**
     *  Upload images for product
     */
    public function remove_image($id=0,$key=0)  {
          
        $imgs = Gallery::where('id','=', $id)
                         ->first();
          $img = json_decode($imgs->directory,true);      
          $image = $img[$key];
             
            unset($img[$key]);  
            Gallery::where('id',$imgs->id)->update(['directory'=>json_encode($img)]);
             
             
           @\File::delete(public_path("imgproduct/".$image), public_path("imgproduct/thumb_".$image));
           
           return \Wh::get_admin_gallery($imgs->id_post);       
    }
    
     
    /**
     * Go to product edit or add page so if is new then the id=new 
     */
     
     public function product_add_edit($id="") {
        $page = Product::where('id','=',$id)->first();
        $id= $id=="new"? mt_rand(1000000, 9999999) : $id;
         
         return view('admin.pages.product', ['page' => $page, 'id'=>$id, 
                                             "attributes"=>@json_decode($page->attr,true), 
                                             'settings_attributes'=>@\Wh::get_variation("_attributes_") ]); 
    }
     
     
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */  
    public function store(Request $request){
          $id = $request->input('id');
           
          $meta_json = [
                   'metad' => @$request->input('metad'),
                   'metak' => @$request->input('metak') 
                ];
                
         $option_json = [
                   'cpu_store'=> @$request->input('cpu_store'),
                   'lang' => @$request->input('lang'),
                   'stock' =>@$request->input('stock'),
                   'image' =>@$request->input('image_main'),
                   ];      
          
            $variation =@$request->input('variation');
             
             $sugestions = @\Wh::convert_variation(@$request->input('specification'),"specifications","true");
             $new_sugestion = [];
             foreach ($sugestions as $k5 =>$v5){
               if(is_array($v5)){
                foreach($v5 as $v6){
                    $new_sugestion[] =  [$k5=>$v6];
                }
               }else{
                 $new_sugestion[$k5]=$v5;
               }
             }
             
             
             
           $variation_json = [
                   'variation'=> @\Wh::convert_variation(@\Wh::convert_variation_array($variation),"variations"),
                   'specification' => $new_sugestion,
                 ]; 
              
              $qty_variation = 0;
             if(!empty($variation)){       
                foreach($variation as $qty_v){
                   $qty_variation = $qty_variation + intval (@$qty_v['qtu']) ;
                 }
              }
             $qtu = $qty_variation>0? $qty_variation :  @$request->input('qtu');
           
        
          $cpu= @$request->input('cpu');
          $cpu= empty($cpu) ? str_slug(@$request->input('title'), '-') :
                              str_slug(@$request->input('cpu'), '-');
                              
          $cat= @json_encode($request->input('cat'));
          $cat = @str_replace(['"',"'"],'', $cat);
           
          $data = [
            'title'       =>@$request->input('title') ,
            'cpu'         => @$cpu,
            'SKU'         => @$request->input('SKU'),
            'price'       => number_format(@$request->input('price'), 2, '.', ''),
            'sale_price'  => number_format(@$request->input('sale_price'), 2, '.', ''),
            'qtu'         => @$qtu,
            'weight'      => @$request->input('weight'),
            'meta'        => @json_encode($meta_json),
            'text'  => @$request->input('text'),
            'description'=> @$request->input('description'),
            'optionsdata' => @json_encode($option_json),
            'attr' => @json_encode($variation_json),
            'cat'=> @$cat,
            'hide'=> 1
            ];
            
            $count_id =strlen($id);
            
            // only user add new product
            if($count_id == 7){
              $data['user_id'] = \Wh::id_user();
            }
           
             $object = Product::updateOrCreate(
                               ['id' => @$id ], $data
                              );
         
           //get the last id
            $id_parent = $object->id;
              
            // if is new product we need to update the post id in the gallery with new id
           if($count_id == 7){      
            Gallery::where("id_post",$id)->update(['id_post'=> $id_parent]);
            FileUpload::where("id_post",$id)->update(['id_post'=> $id_parent]);
           }
           
           session(['status' => _l('Success')]);
           
        return redirect('/admin/product/'.$id_parent);
    }
    
    
  /**
     * Hide product
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hide_show($id, $action){

        Product::where('id', $id) ->update(['hide'=> $action]);
       
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $return = ""){
        $pr =  Product::where('id', $id)->first();
        $mainIMG= json_decode($pr->optionsdata,true);
        if(!empty($mainIMG["image"])){
            @\File::delete(public_path("imgproduct/".$mainIMG["image"]), public_path("imgproduct/thumb_".$mainIMG["image"]));
        }
         Product::destroy($id);
         
         $idG = Gallery::where('id_post',$id)->first();
        if(!empty($idG)){
            $gallery = json_decode($idG->directory,true);
            if(!empty($gallery)){
                foreach($gallery as $data){
                  @\File::delete(public_path("imgproduct/".$data), public_path("imgproduct/thumb_".$data));  
                }
            }
            
          Gallery::destroy($idG->id);  
        }
         
       return  empty($return)? redirect()->back():'';
    }
    
    
   
/**
* This is for virtual products, will upload file if product is downloadable
*/     
 public function upload_virtual(Request $request){
       $upload = new Upload();
       $file = $upload->upload($request, 'product-files/', 'file');
       $file_title= @$request->input('field1');
       $product_id= @$request->input('parent_id');
        
        
          FileUpload::insert(
                            ['id_post' => @$product_id, 
                             'file_title' =>@$file_title,
                             'file'=> @$file[0][0],
                             'originalFileName'=> @$file[0][1],
                             'date'=>date("Y-m-d h:i:s")
                             ]
                        );
                        
       return  \Wh::get_admin_files($product_id);
   } 
    
   /**
    * remove product upload file, for downloadable products
    */
  public function remove_file($id){
         $files = FileUpload::where('id','=', $id)
                         ->first();
                 
          \File::delete(public_path("product-files/".$files->file));
              
         FileUpload::destroy($files->id); 
         return \Wh::get_admin_files($files->id_post); 
  }  
  
   /**
    * remove product upload file, for downloadable products
    */
  public function getdownloadable($id){
         $get_file= FileUpload::where('id',$id)->first();
         return empty($get_file) ? redirect()->back() : 
                 response()->download( public_path('product-files/'.$get_file->file), $get_file->originalFileName) ;
  }  
    
   
   
   
      
/**
* Incrise Price 
*/     
 public function increasePrice(Request $request){
         $_additional_price= @$request->input('_additional_price');
         $_additional_type= @$request->input('_additional_type');
         $setting = \Wh::get_settings_json("_main_options_");
         $setting['_additional_price'] = $_additional_price;
         $setting['_additional_type'] = $_additional_type; 
         @\Wh::update_settings('_main_options_','',@json_encode($setting) );
       return  redirect()->back();
   } 
    
    
    /**
     * Move product from one category to other
     */
    public function move_product_to_another_category(Request $request) {
            $from= $request->get("from");
            $to= $request->get("to");
            //return $to."-".$from; 
            
       $product = Product::select( 'id', 'cat')->whereJsonContains('cat',  [intval($from)] )->get();
        $ii=0;
       foreach($product as $val){$ii++;
           Product::where('id', $val->id) 
                      ->update(['cat'=> '['.$to.']']);
        }
        session(['status' => _l('Total moved products').":".$ii]);
        return redirect()->back();
        
    }
    
  protected function quickChanges($d='1'){
     exit();
    if($d=='1'){ 
     $product = Product::select( 'id', 'cat')->get();
     
     foreach($product as $val){
          Product::where('id', $val->id) 
                      ->update(['cat'=> '['.rand(1, 8).']']);
        }
     }else{
         $product = Product::get();
              $j=1;
              
              $ar= [1, 4, 7, 10, 14, 17, 20, 23, 26, 29, 32, 35, 38, 41, 44, 47, 50];
              $count = count($ar) - 1;
             foreach($product as $val){
                // if($j==13){
                    //$j = 14;
                  // }
                    //echo $j.", "; 
                   $op= json_decode($val->attr, true);
                   //$op["variation"]["qtu"] =  rand(50,200); 
                   //unset($op["variation"]["qtu"]);
                    
                  // Product::where('id', $val->id) 
                   //            ->update(['attr'=>  str_replace('"qtu": "','"qtu": "'.rand(1,9),$val->attr)]);
                   /*
                   $rand= rand(0, $count);
                   $op= json_decode($val->optionsdata,true);
                   $op["image"] =  $ar[$rand].".jpg"; 
                  
                    Product::where('id', $val->id) 
                               ->update(['optionsdata'=> json_encode($op)]);
                              
                    Gallery::insert(['directory'=> json_encode( [($ar[$rand] + 1).".jpg",($ar[$rand] + 2).".jpg"]),
                                        'id_post'=>$val->id, 'id_user'=>1  ]);   
                  */       
                }
         }
         
  
  }
}
