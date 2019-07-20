<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use DB;
class View extends Model
{
    public static  function is_role(){
       $prouct= DB::table('product')->where("id","20")->first();
        
        return  $prouct->title;
    }
}
