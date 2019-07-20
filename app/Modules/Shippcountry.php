<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Shippcountry extends Model
{
    protected $table = 'shippcountry';
    protected $guarded = ['id'];
    public $timestamps = false;
}
