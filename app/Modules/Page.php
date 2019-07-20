<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Page extends Model
{
    protected $table = 'page';
    public $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = false;
}
