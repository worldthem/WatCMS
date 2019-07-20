<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public $primaryKey = 'id';
    protected $guarded = ['id'];
    
 public function getOrer($orderid=0, $uid=null){
    
    $order = Orders::where("user_id", ($uid ?? \Wh::id_user()))
                      ->where('id',$orderid) 
                      ->first();
    return $order;                  
   }
}
