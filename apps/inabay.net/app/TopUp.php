<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
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

    public function getStatusAttribute(){
        $is_confirm = $this->attributes['is_confirm'];
        $is_cancel = $this->attributes['is_cancel'];

        if($is_confirm == false && $is_cancel == false){
            return "Proses";
        }
        if($is_confirm == true && $is_cancel == false){
            return "Masuk";
        }
        if($is_confirm == false && $is_cancel == true){
            return "Batal";
        }
        if($is_confirm == true && $is_cancel == true){
            return "Unknown";
        }
    }
}
