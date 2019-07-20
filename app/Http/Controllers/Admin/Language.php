<?php
//https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=ru&dt=t&q=hello
//https://stackoverflow.com/questions/8085743/google-translate-vs-translate-api
	
namespace App\Http\Controllers\Admin;
 
use App\Modules\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Language extends Controller
{
  
  
  /**
     * Show page language 
     */  
 public function index(){
    $lang = @require app_path('Helpers/lang.php');
    $lang_view = \Wh::get_settings('_lang_view_', 'value1');
    $lang_admin = \Wh::get_settings('_lang_admin_', 'value1');
    $rows = @_TRANSLATE_DATA_;
    $translateView  = @_TRANSLATE_VIEW_;
    $translateAdmin = @_TRANSLATE_ADMIN_;
    return view('admin.pages.language',  compact('lang', 'lang_view', 'lang_admin', 'rows','translateAdmin','translateView'));
 }  
 
  
    /**
     * Save editabled data in csv file 
     */
 public function setLanguage(Request $request){
    $langView  = @$request->input('langView');
    $langAdmin  = @$request->input('langAdmin');
    $dataView  = @$request->input('dataView');
    $dataAdmin  = @$request->input('dataAdmin');
    
    $this->updateLang($dataView, $langView);
    $this->updateLang($dataAdmin, $langAdmin); 
    
    return redirect()->back();
 }
 
 private function updateLang($data, $lang){
    if(!empty($data)){
        $file= base_path() . '/language/'.$lang.'.json';
        $dd = @json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
       \File::put($file, $dd);
     }
 }
 

 public function translatePage($lang='' ){
    $rows = @_TRANSLATE_DATA_;
    return view('admin.pages.translade', compact('rows', 'lang' ));
  }
 
   /**
     * If you use google translate and copy paste so it will create the json file with the data in like
     * de.json 
     */
 public function fullTranslate(Request $request){
     $text  = @$request->input('text');
     $lang  = @$request->input('lang');
     $begin  = @$request->input('begin');
     $end  = @$request->input('end');
     
     $data = explode("\n",$text);
     $file = base_path('/language/'.$lang.'.json') ;
     
 if(!empty($text) && count($data)>10){
     $new_data=[];
     if(\File::exists($file)){
        $getData = file_get_contents($file);
        $new_data = @json_decode($getData, true); 
     }
      $rows = @_TRANSLATE_DATA_;
      $j=0;
      for($i=0; $i<count($rows); $i++){ 
        if($i>=$begin && $i<=$end){
            $new_data[$rows[$i]] = !empty($data[$j]) ? trim($data[$j]) :'';
            $j++;
         } 
       }
      
       
      $dd = json_encode($new_data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
      \File::put($file, $dd);
  }   
      return redirect()->back(); 
      
 }    
  
  /**
   * This function will set the language in table settings 
   */
 public function updateLanguage(Request $request){
    $langView  = @$request->input('_lang_view_');
    $langAdmin  = @$request->input('_lang_admin_');
    
    // if the row with param is not it will add a new row in database,
    // if the row is it will update it 
    \Wh::update_settings('_lang_view_', '', $langView);
    \Wh::update_settings('_lang_admin_', '', $langAdmin);
    return redirect()->back(); 
 }   
 
 
    
}