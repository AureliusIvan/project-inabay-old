<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerStock extends Model
{
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('\App\Product');
    }

    public function user(){
        return $this->belongsTo('\App\User');
    }
}
