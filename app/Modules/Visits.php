<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    protected $table = 'visits';
    public $primaryKey = 'id';
    protected $guarded = ['id'];
    //public $timestamps = false;
}
