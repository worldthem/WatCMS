<?php

namespace App\Modules;
use Illuminate\Database\Eloquent\Model;

class Usermeta extends Model {
   
    protected $table = 'usermeta';
    protected $guarded = ['id'];
    public $timestamps = false;
    
    
  public static function updateOrCreateMeta($uID=0,$Data=[]){
       if(empty($Data)) return ;
       
       $meta= (new Usermeta)->getMeta($uID); 
       $metaValue =  !empty($meta)? $meta: [];
       
       foreach($Data as $k=>$v){
        $metaValue[$k]=$v;
       }
     
       Self::updateOrCreate(
                 ['user_id' => $uID],
                  
                 ['user_id'=>$uID, 
                  'meta_value'=>@json_encode(@$metaValue,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)
                  ]
                 ); 
     }  
    
    
    public function getMeta($uID=0, $field="meta_value"){
        $get= Self:: where('user_id', $uID)
                    ->select($field)
                    ->first();
        $return = $field == "meta_value" ?  @json_decode(@$get->meta_value, true) : @$get->$field;
        return @$return ;
    }
    
}