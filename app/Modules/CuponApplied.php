<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class CuponApplied extends Model
{
     protected $table = 'cupon_applied';
     public $primaryKey = 'id';
     protected $guarded = ['id'];
}
