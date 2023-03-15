<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    public $timestamps = false;

    public function sales(){
        return $this->belongsTo('App\Sales');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function getMaskedPriceAttribute(){
        return number_format($this->attributes['price'], 0);
    }

    public function getMaskedSubTotalAttribute(){
        $subtotal = $this->attributes['qty'] * $this->attributes['price'];
        return number_format($subtotal, 0);
    }
}
