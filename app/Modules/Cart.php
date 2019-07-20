<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
     protected $table = 'cart';
     protected $guarded = ['id'];
}
