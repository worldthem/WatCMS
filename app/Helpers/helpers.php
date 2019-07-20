<?php

 /**
 * this will get the translate
 */
 
function _l($word=""){
      $getCurrentUrl= (string) request()->path();
      $view  = @strpos($getCurrentUrl, "admin")!==false ?  @_TRANSLATE_ADMIN_  : @_TRANSLATE_VIEW_;
     
       //$getData= file_get_contents(base_path('/language/en.json'));
       //$data_en = @json_decode($getData, true); 
     
      $data_en = @_TRANSLATE_DATA_;
      $data_en = !empty($data_en) ? $data_en : [];
      if(!in_array(trim(strtolower($word)), $data_en)){
         $data_en[] = trim(strtolower($word));
         \File::put(base_path() . '/language/en.json', json_encode($data_en, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
     }
     
    return  !empty($view[trim(strtolower($word))]) ?  \Wh::firstLetterUpercase($view[trim(strtolower($word))], $word) : $word;
 }
 
 /**
 * Print a nice array
 */
  function printw($array=[]){
     echo '<pre style="color:#000 !important;overflow: visible !important; font-size:12px;">'; print_r($array);  echo '</pre>';
 }
