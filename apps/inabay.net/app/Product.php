<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function getTotalStockAttribute(){
        $name = $this->attributes['name'];
        $total_stock = Product::where('name', $name)->sum('stock');
        return $total_stock;
    }

    public function getTotalProductInProcessAttribute() {
        $id = $this->attributes['id'];
        $total = SalesDetail::where('product_id', $id)->whereHas('sales', function($query) {
            $query->where('status', 1);
        })->sum('qty');
//        $total = Sales::where('status', 1)->with(['sales_detail' => function($query, $id){
//            $query->where('product_id', $id)->sum('qty');
//        }])->get();
        return $total;
    }

    public function getTotalProductInCartsAttribute() {
        $id = $this->attributes['id'];
        $total = ShoppingCart::where('product_id', $id)->sum('qty');
        return $total;
    }

    public function getRestockDateAttribute(){
        $value = $this->attributes['restock_at'];
        if($value){
            $date = new DateTime($value);
            return $date->format('d/m/Y');
        }else{
            return null;
        }
    }

    public function getCreateDateAttribute(){
        $value = $this->attributes['created_at'];
        $date = new DateTime($value);
        return $date->format('d/m/Y');
    }

    public function shopping_cart(){
        return $this->hasMany('App\ShoppingCart');
    }

    public function sales_detail(){
        return $this->hasMany('App\SalesDetail');
    }

    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

    public function user_stock(){
        return $this->hasMany('\App\UserStock');
    }

    public function seller_stock(){
        return $this->hasMany('\App\SellerStock');
    }

    public function purchasing_cart(){
        return $this->hasMany('App\PurchasingCart');
    }

    public function deletable(){
        $id = $this->attributes['id'];
        if(SalesDetail::where('product_id', $id)->exists()){
            return false;
        }else{
            return true;
        }
    }

//    public function getNameAttribute($value){
//        $is_gift = $this->attributes['is_gift'];
//        if($is_gift){
//            return "[HADIAH] - " . $value;
//        }else{
//            return $value;
//        }
//    }

    public function getOriginalNameAttribute(){
        return $this->attributes['name'];
    }
}
