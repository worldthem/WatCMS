<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product extends Model
{
    protected $table = 'product';
    protected $guarded = ['id'];
    //public $timestamps = false;
    public function qtu(){
        return Product::where('qtu','>',0)->paginate(21);
    }
    
   protected function join_query(){
             return Self::where('product.qtu','>',0)
                           ->where('product.hide', '>' ,0);
                     
    }
    
 
  public function get_single_product($field, $value=""){
       $product  =  Product::where($field,$value)
                             //->where('qtu','>', '0')
                             ->first(); 
                            
     return $product; 
  }
   
   
  
    
}
