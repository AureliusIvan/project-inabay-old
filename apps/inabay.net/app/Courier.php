<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    public $timestamps = false;

    public function getLogoAttribute(){
        $name = strtolower($this->attributes['name']);
        $logo = "";

        if(strpos($name, 'jne') !== false)
            $logo = "images/logo_kurir/jne.jpg";
        elseif(strpos($name, 'j&t') !== false)
            $logo = "images/logo_kurir/jnt.jpg";
        elseif(strpos($name, 'gosend') !== false)
            $logo = "images/logo_kurir/gosend.jpg";
        elseif(strpos($name, 'grab') !== false)
            $logo = "images/logo_kurir/grab.jpg";
        elseif(strpos($name, 'ninja') !== false)
            $logo = "images/logo_kurir/ninja.jpg";
        elseif(strpos($name, 'sicepat') !== false)
            $logo = "images/logo_kurir/sicepat.jpg";
        elseif(strpos($name, 'antaraja') !== false || strpos($name, 'anteraja') !== false)
            $logo = "images/logo_kurir/anteraja.jpg";
        elseif(strpos($name, 'wahana') !== false)
            $logo = "images/logo_kurir/wahana.jpg";

        return $logo;
    }

    public function sales(){
        $this->hasOne('App\Sales');
    }
}
