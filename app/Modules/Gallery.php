<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{    
    protected $table = 'gallery';
    public $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;
}