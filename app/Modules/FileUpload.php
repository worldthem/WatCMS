<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $table = 'uploads';
    protected $guarded = ['id'];
    public $timestamps = false;
}
