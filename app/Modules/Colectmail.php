<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Colectmail extends Model
{
    protected $table = 'colectmail';
    protected $guarded = ['id'];
}
