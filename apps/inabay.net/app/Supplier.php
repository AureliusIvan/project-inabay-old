<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    public $timestamps = false;

    public function product(){
        return $this->hasMany('App\Product');
    }
}
