<?php
 namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use DB;
 
class Role extends Model
{
  
    protected $table = 'role';
    protected $guarded = ['id'];
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        
       return $this->hasMany('App\User');
    }
}


