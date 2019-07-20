<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $guarded = ['id'];
    public $timestamps = false;
}
