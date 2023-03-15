<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Milon\Barcode\DNS1D;

class Sales extends Model
{

    public function getCourierNameAttribute(){
        $courier_id = $this->attributes['courier_id'];
        $courier = Courier::find($courier_id);
        return $courier->name;
    }

    public function getUserNameAttribute(){
        $user_id = $this->attributes['user_id'];
        $user = User::find($user_id);
        return $user->name;
    }

    public function getShopNameAttribute(){
        $user_id = $this->attributes['user_id'];
        $user = User::find($user_id);
        return $user->shop_name;
    }

    public function getReceiverShortAttribute(){
        return Str::limit($this->attributes['receiver_address'], 20);
    }

    public function getTotalSalesAttribute(){
        $id = $this->attributes['id'];
        $sales_details = SalesDetail::where('sales_id', $id)->get();
        $total_sales = 0;
        foreach($sales_details as $sales_detail){
            $total_sales += $sales_detail->qty * $sales_detail->price;
        }
        return $total_sales;
    }

    public function getTotalSalesAndDeliveryCostAttribute(){
        $total_sales = $this->getTotalSalesAttribute();
        $delivery_cost = $this->attributes['delivery_cost'];
        return $total_sales + $delivery_cost;
    }

    public function getPointsAttribute(){
        $use_points = $this->attributes['use_points'];
        // if use_points == true --> points = 0
        if($use_points){
            $points = 0;
        }else{
            $points = floor($this->getTotalSalesAttribute() / 5000) * 100;
        }
        return $points;
    }

    public function getTrxNoAttribute() {
        $id = $this->attributes['id'];
        $str = "#" . substr(str_repeat(0, 8) . $id, -8);
        return $str;
    }

    public function getReceiverAddressAttribute($value){
        $text = explode("\n", $value);
        $text[0] = "<b>" . $text[0] . "</b>";
        $addr = "";
        foreach($text as $txt) {
            $addr .= $txt . "<br />";
        }
        return $addr;
//        return nl2br($value, true);
    }

    public function getMaskedTotalSalesAttribute(){
        return number_format($this->getTotalSalesAttribute(), 0);
    }

    public function getMaskedDeliveryCostAttribute(){
        return number_format($this->attributes['delivery_cost'], 0);
    }

    public function getMaskedGrandTotalAttribute(){
        $grand_total = $this->getTotalSalesAttribute() + $this->attributes['delivery_cost'];
        return number_format($grand_total, 0);
    }

    public function getGrandTotalAttribute() {
        $grand_total = $this->getTotalSalesAttribute() + $this->attributes['delivery_cost'];
        return $grand_total;
    }

    public function getStatusAttribute($value){
        switch($value){
            case 1: return "Proses";
            case 2: return "Terkirim";
            case 3: return "Batal";
            case 4: return "Siap";
        }
    }

    public function getStatusColorAttribute(){
        $status = $this->attributes['status'];
        switch($status){
            case 1: return "yellow";
            case 2: return "green";
            case 3: return "red";
            case 4: return "blue";
        }
    }

    public function getDateAttribute(){
        $value = $this->attributes['created_at'];
        $date = new DateTime($value);
        return $date->format('d/m/Y');
    }

    public function getTimeAttribute(){
        $value = $this->attributes['created_at'];
        $time = new DateTime($value);
        return $time->format('H:i');
    }

    public function getDeliveryLogoAttribute(){
        $courier = Courier::find($this->attributes['courier_id']);
        $img_path = $courier->logo;
        if($img_path != ""){
            $img_data = fopen(public_path($img_path), 'rb');
            $img_size = filesize($img_path);
            $binary_image = fread($img_data, $img_size);
            fclose ($img_data);

            $img_src = "data:image/jpeg;base64,".str_replace ("\n", "", base64_encode($binary_image));
        }else{
            $img_src = false;
        }
        return $img_src;
    }

    public function getDeliveryBarcodeAttribute(){
        if($this->attributes['booking_code']){
            $barcode = "data:image/png;base64," . DNS1D::getBarcodePNG($this->attributes['booking_code'], 'C128', 1.5, 55);
        }else{
            $barcode = null;
        }
        return $barcode;
    }

    public function sales_detail(){
        return $this->hasMany('App\SalesDetail');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function courier(){
        return $this->belongsTo('App\Courier');
    }
}
