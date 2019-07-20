<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';
    protected $guarded = ['id'];
    public $timestamps = false;
}
