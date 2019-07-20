<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'meta';
    protected $guarded = ['id'];
    public $timestamps = false;
}