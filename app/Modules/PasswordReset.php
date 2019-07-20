<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PasswordReset extends Model
{
    protected $table = 'pass_reset';
    protected $guarded = ['id'];
   /* 
    protected $fillable = [
        'email', 'token'
    ];
    */
}
