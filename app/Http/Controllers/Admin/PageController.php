<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Page;
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $pagesType; 
     
  public function __construct() { 
          $this->pagesType = \Wh::mergeConstantAnConfig(PAGES_TYPE, "pageType");
     }
     
     
    public function index($type='',$s='') {
        
            $page =empty($s)? Page::where('type',$type)->paginate(50) :
                              Page::where('type',$type)
                                  ->where(
                                    function($query) use ($s) {
                                             $query= $query->where("title",'like','%'.$s.'%')
                                                           ->orWhere("text",'like','%'.$s.'%')
                                                           ->orWhere("cpu",'like','%'.$s.'%'); 
                                         return $query;    
                                     })
                                 ->orderby("id",'desc')
                                 ->paginate(50);
             $categories = @\Wh::getAllCategories_all($type); 
             
            return view('admin.pages.page', ['page' => $page,'type'=>$type, 'post_type'=>$this->pagesType, 'categories'=>$categories ]);
    }
    
    
  /**
    * Show posts from category
    */  
    
 public function showFromCategory($type='', $catid='') {
            $page = Page::whereJsonContains('cat', [intval($catid)]) 
                            ->orderby("id",'desc')
                            ->paginate(50);
             
             $categories = @\Wh::getAllCategories_all($type); 
             
            return view('admin.pages.page', ['page' => $page,'type'=>$type, 'post_type'=>$this->pagesType, 'categories'=>$categories, 'catid'=>$catid ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type='',$id="")
    {
        $page = Page::where('id','=',$id)->first();
        $json = @json_decode(@$page->options, true);
         
        return view('admin.pages.page-add-edit', ['page' => $page, 'type'=>$type, 'post_type'=>$this->pagesType, 
                                            "jsondata"=>$json ]); 
    }
     /**
     * Enable Disable Block.
     *
     * @return \Illuminate\Http\Response
     */
    public function enableDisable($id="")
    {
        $page = Page::where('id','=',$id)->first();
        $json = @json_decode(@$page->options, true);
         
        $json['enable'] = $json['enable']=='enable' ? '':'enable';
        $object =  Page::where('id',$id)->update(['options'=>@json_encode($json)]);  
        return redirect()->back(); 
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
          $title = @$request->input('title');
          $cpu= @$request->input('cpu');
          $cpu = !empty($cpu)? str_slug(@$cpu, '-') : str_slug(@$title, '-');  
          
          if($id != "new" && !empty($id)){
           $page = Page::where('id','=',$id)->first();
           \Wh::replaceMenuUpdate($page->cpu, $cpu, $page->title, $title);
        }
        
        
          $meta = json_encode(['metad'=>@$request->input('metad'),'metak'=>@$request->input('metak'),
                               'lang'=>'en', 'subject'=>@$request->input('subject'),
                               'enable'=>@$request->input('enable'),'template'=>@$request->input('template'),
                               'image' =>@$request->input('image_main'),
                               'style' =>@$request->input('style'),
                               'cssdirect' =>@$request->input('cssdirect'),
                               ]);
          $cat = @json_encode($request->input('cat')); 
          $cat = @str_replace(['"',"'"],'', @$cat);
         
          $type = @$request->input('type');
          $data = [
                'title'    =>@$title,
                'cat'    =>@$cat,
                'cpu'      => @$cpu,
                'type'     => @$type,
                'options'    => @$meta,
                'text'     => @$request->input('text'),
                'sort'     => @$request->input('sort'),
                ];
            
          \Wh::hooks("save_page");  
          
        $object =  Page::updateOrCreate(
                          ['id' => $id], $data
                         );
          
          $url = url('/admin/page/add-edit/'.$type.'/'.$object->id);
          session(['status' => _l('Success')]);
          
           $get_settin = _MAIN_OPTIONS_;
           if(!empty($get_settin['_cachehomepage_']) && $get_settin['_pageHome_'] == $object->id ){
             $contentHome = str_replace( "%-" , "% - " , $contentHome);
             \File::put(base_path('/resources/views/standart/cache/home.blade.php'),\Wh::minify_html($contentHome));
           } 
          
          return redirect($url) ;
    }
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::destroy($id);
       return redirect()->back();
    }
    
    
    /**
     * Load more block.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loadMore()
    {
          $data = @\Wh::get_by_curl("https://watcms.com/json/");
         if(!empty($data)){ 
           \Wh::update_settings("_page_builder_", "", $data, "");
           }
       return view("admin.layouts.ready-blocks");
    }
    
    
    
      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_bulk(Request $request, $type='')
    {
            $rowid = $request->input('rowid');
            $action = $request->input('action');
            $s = $request->input('s');
          if(!empty($action) && empty($s)){
              
              foreach ($rowid as $val){
                 if($action=='del' &&  $val != "1" ){
                         Page::where('id', $val)->delete();
                     }  
                 }
           }
       return !empty($s)? redirect('/admin/page/search/'.$type.'/'.$s) :  redirect()->back() ;
    }
    
    
}
