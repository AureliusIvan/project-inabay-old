<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'no_ktp', 'address', 'city', 'zipcode', 'phone',
        'shop_name', 'bank_name', 'bank_acc_name', 'bank_acc_no',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getMemberIdAttribute(){
        $id = $this->attributes['id'];
        return sprintf("%03d", $id);
    }

    public function getRoleAttribute(){
        $role_id = $this->attributes['role_id'];
        switch($role_id){
            case 0: return 0;
            case 1: return "Super Admin";
            case 2: return "Admin";
            case 3: return "Anggota";
            case 4: return "Vendor";
            case 5: return "Finance";
        }
    }

    public function getPointsMaskedAttribute(){
        $points = $this->attributes['points'];
        return number_format($points, 0, ',', '.');
    }

    public function monthlyNumOfTransaction($month, $year){
        $id = $this->attributes['id'];
        $sales_count = Sales::where('user_id', $id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 2)->count();
        return $sales_count;
    }

    public function monthlyTotalSales($month, $year){
        $id = $this->attributes['id'];
        $sales = Sales::where('user_id', $id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 2)->get();
        $total_sales = 0;
        foreach($sales as $s){
            $total_sales += $s->total_sales;
        }
        return $total_sales;
    }

    public function monthlyTotalSalesInProcess($month, $year) {
        $id = $this->attributes['id'];
        $sales = Sales::where('user_id', $id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', [1,4])
            ->get();
        $total_sales = 0;
        foreach($sales as $s){
            $total_sales += $s->total_sales;
        }
        return $total_sales;
    }

    public function getTotalUnpaidAttribute() {
        $id = $this->attributes['id'];
        $sales = Sales::where('user_id', $id)
            ->where('is_paid', false)
            ->whereIn('status', [1,2,4])
            ->get();
        $total_sales = 0;
        foreach($sales as $s) {
            $total_sales += $s->total_sales + $s->delivery_cost;
        }
        return $total_sales;
    }

    public function getCurrentMonthTotalSalesAttribute() {
        $current_month = date('n');
        $current_year = date('Y');
        return $this->monthlyTotalSales($current_month, $current_year);
    }

    public function getCurrentMonthTotalSalesInProcessAttribute() {
        $current_month = date('n');
        $current_year = date('Y');
        return $this->monthlyTotalSalesInProcess($current_month, $current_year);
    }

    public function getLastMonthTotalSalesAttribute() {
        $current_month = date('n');
        $current_year = date('Y');
        if($current_month == 1) {
            $last_month = 12;
            $year = $current_year - 1;
        }else {
            $last_month = $current_month - 1;
            $year = $current_year;
        }
        return $this->monthlyTotalSales($last_month, $year);
    }

    public function getLastMonthTotalSalesInProcessAttribute() {
        $current_month = date('n');
        $current_year = date('Y');
        if($current_month == 1) {
            $last_month = 12;
            $year = $current_year - 1;
        }else {
            $last_month = $current_month - 1;
            $year = $current_year;
        }
        return $this->monthlyTotalSalesInProcess($last_month, $year);
    }

    public function monthlyTotalDeliveryCost($month, $year){
        $id = $this->attributes['id'];
        $sales = Sales::where('user_id', $id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 2)->get();
        $total_delivery_cost = 0;
        foreach($sales as $s){
            $total_delivery_cost += $s->delivery_cost;
        }
        return $total_delivery_cost;
    }

    public function shopping_cart(){
        return $this->hasMany('App\ShoppingCart');
    }

    public function sales(){
        return $this->hasMany('App\Sales');
    }

    public function top_up(){
        return $this->hasMany('App\TopUp');
    }

    public function seller_stock(){
        return $this->hasMany('\App\SellerStock');
    }
}
