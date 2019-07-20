<?php

namespace App\Modules;

use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
     protected $table = 'cupon';
     public $primaryKey = 'id';
     protected $guarded = ['id'];
     
     
   public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
     }
}

