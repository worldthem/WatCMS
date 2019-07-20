<?php

namespace App\Modules\Admin;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {
    protected $table = 'categories';
    protected $guarded = ['id'];
    public $timestamps = false;

/**
 * Check if category exist cpu(converting title to cpu) then return id;
 * if not return 0;
 */
public function category_exist ($title=""){
    $slug = str_slug(@$title, '-');
    $get = Self::where('cpu',$slug)->select("id")->first();
    return !empty($get)? $get->id : 0;
}


/**
 * @insertByTitle
 * Simple insert the cat by title
 */
public function insertCatByTitle($title, $parent= "", $type = "product"){
    $cpu = str_slug(@$title, '-');
    $cpuExist = Categories::where('cpu',$cpu)->count();
    $cpu= $cpuExist > 0 ? $cpu."-".rand(999,10000) : $cpu;
     $data = [
            'title'   =>$title ,
            'cpu'     => $cpu,
            'metad'   => $title,
            'metak'   => $title,
            'type'   => $type, 
        ];
       if(!empty($parent)){ 
           $data['parent']= $parent;
         }
      $id = Self::insertGetId( $data );
    return $id ;
 }


/**
 * Insert category could be many or only one
 * example Woman > Fashion > Dress > Night Dress 
 */
public function insert_categories($cat, $delimit = ">",$type = "product"){
             $explode = explode($delimit, $cat);
             $id = 0;
             $all_id=[];
             
           foreach($explode as $value){
            $is= $this->category_exist($value);
            if($is == 0){
                $id = $this->insertCatByTitle($value, ($id>0 ? $id : ''));
             }else{
                $id = $is;
            }
            $all_id[] = $id;
        }
      return $all_id ;
 }
 
}
