<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shiping';
    protected $guarded = ['id'];
    public $timestamps = false;
}
