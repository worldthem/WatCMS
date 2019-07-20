<?php namespace App\Http\Controllers\Admin;

use App\Modules\Admin\Categories;
use App\Modules\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index($type=""){
        $cat = Categories::where("type",$type)->orderBy('id','asc')->paginate(100);
        return view('admin.pages.categories', compact("cat","type"));
    }

    public function create($type="",$id="") {
        $page = Categories::where('id','=',$id)->first();
        return view('admin.pages.addedit_categories',  compact("page","type","id")); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)  {
         $id = @$request->input('id');
         $title = @$request->input('title');
         $cpu = @$request->input('cpu');
         $productID = @$request->input('productID');
         
         $cpu= !empty($cpu) ? str_slug($cpu, '-'):  str_slug($title, '-'); 
         
         $cpuExist = Categories::where('cpu',$cpu)->where('id','!=',$id)->count();
         $cpu= $cpuExist > 0 ? $cpu."-".rand(999,10000): $cpu;
         
         if( !empty($id)&& !empty($cpu) ){
            $page = Categories::where('id','=',$id)->first();
            \Wh::replaceMenuUpdate($page->cpu, $cpu, $page->title, $title);
         }
          
          $data = [
            'title'  =>@$title,
            'cpu'     => @$cpu,
            'url'     => @$request->input('url'),
            'metad'     => @$request->input('metad'),
            'metak'     => @$request->input('metak'),
            'text'     => @$request->input('text'),
            'parent'     => @$request->input('parent'),
            'type'     => @$request->input('type') 
            //'template'     => $request->input('template')  
            ];
          
             
          Categories::updateOrCreate(
                          ['id' => $id ], $data
                         );
          
          \Wh::update_settings('_categories_structure_', "", @\Wh::get_cat_yerahical_array(@\Wh::getAllCategories_all()) );
           
            //@json_encode(category_structure());
        return !empty($productID) ? 
                      @\Wh::get_cat_yerahical_checkbox(\Wh::getAllCategories_all(@$request->input('type')), 0, 0, @json_decode($productID, true) ) : 
                      redirect()->back();
    }
    
  /**
     * Hide sho.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hide_show($id, $action){
        Categories::where('id', $id)->update(['tip'=> $action]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
         Categories::destroy($id);
         \Wh::update_settings('_categories_structure_', "", @\Wh::get_cat_yerahical_array(@\Wh::getAllCategories_all()) );
         Categories::where('parent', $id)->update(['parent'=>0]);
        return redirect()->back();
    }
    
    
      public function update_category(){
        exit('not active at the moment');
       $product = Product::select( 'id', 'cat')->get();
        
       foreach($product as $val){
              Product::where('id', $val->id)
                      ->update(['cat'=> '-'.$val->cat.'-']);
        }
    }
    
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatebulk(Request $request)  {
       
          $action = $request->input('action');
          $cat = $request->input('catid');
            
       
          if(!empty($action)){
              
              foreach ($cat as $val){
                 if($action=='del'){
                        Categories::where('id', $val)->delete();
                        Categories::where('parent', $val)->update(['parent'=>0]);
                     }elseif($action=='hide'){
                        Categories::where('id', $val)
                                ->update(['tip' => NULL]);
                     }elseif($action=='visible'){
                        Categories::here('id', $val)
                                ->update(['tip' => 1]);
                     }
                     
                 }
                 
                \Wh::update_settings('_categories_structure_', "", @\Wh::get_cat_yerahical_array(@\Wh::getAllCategories_all()) ); 
           }
          
         return redirect()->back() ;
    }
    
    public function move_product_to_another_category(Request $request){
            $from= $request->get("from");
            $to= $request->get("to");
            //return $to."-".$from; 
           $product = Product::select( 'id', 'cat')->where('cat',"like", "%,".$from.",%" )->get();
            $ii=0;
           foreach($product as $val){$ii++;
               Product::where('id', $val->id) 
                          ->update(['cat'=> "01,".$to."," ]);
            }
            // echo $ii."<br/>";
          return redirect()->back();
    }
  
}
