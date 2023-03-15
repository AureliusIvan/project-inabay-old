<?php

namespace App\Http\Controllers;

use App\Sales;
use App\User;
use App\UserStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        // Halaman ini hanya bisa diakses oleh admin
        $this->authorize('superadmin');

        $page = "admin";
        $users = User::where('role_id', 1)->orWhere('role_id', 2)->orWhere('role_id', 5)->paginate(25);
        return view('inabay.users.admins.index', compact('users', 'page'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('inabay.users.admins.create');
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);

        $user->no_ktp   = $request->no_ktp;
        $user->address  = $request->address;
        $user->city     = $request->city;
        $user->zipcode  = $request->zipcode;
        $user->phone    = $request->phone;
        $user->shop_name= $request->shop_name;

        $user->bank_name    = $request->bank_name;
        $user->bank_acc_name= $request->bank_acc_name;
        $user->bank_acc_no  = $request->bank_acc_no;

        $user->balance = $request->balance;
        $user->points = $request->points;

        $user->is_active    = $request->is_active;
        $user->role_id      = $request->role_id;

        $user->save();

        return redirect('/users');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('inabay.users.admins.show', compact('user'));
    }

    public function edit($id)
    {
        $this->authorize('admin');
        $user = User::find($id);
        return view('inabay.users.admins.edit', compact('user'));
    }

    public function userEdit(){
        $user = Auth::user();
        $self = true;
        return view('inabay.users.edit', compact('user', 'self'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        ]);

        $user = User::find($id);
        $user->name     = $request->name;
        $user->no_ktp   = $request->no_ktp;
        $user->address  = $request->address;
        $user->city     = $request->city;
        $user->zipcode  = $request->zipcode;
        $user->phone    = $request->phone;
        $user->shop_name    = $request->shop_name;
        $user->bank_name        = $request->bank_name;
        $user->bank_acc_name    = $request->bank_acc_name;
        $user->bank_acc_no      = $request->bank_acc_no;

        if(isset($request->balance)) $user->balance = $request->balance;
        if(isset($request->points)) $user->points = $request->points;

        $user->email            = $request->email;
        $user->role_id  = $request->role_id;

        if(isset($request->is_active)) $user->is_active = $request->is_active;

        if($request->password != null){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('/users');
    }

    public function destroy($id)
    {
        //
    }

    public function get_user_info(Request $request){
        $user = User::find($request->user_id);
        return $user;
    }

    public function my_account_show(){
        $user = Auth::user();
        $current_month = date('n');
        $current_year = date('Y');
        if($current_month == 1) {
            $last_month = 12;
            $last_month_year = $current_year - 1;
        }else {
            $last_month = $current_month - 1;
            $last_month_year = $current_year;
        }

        $current_month_str = $this->month_str($current_month);
        $last_month_str = $this->month_str($last_month);

        $sales_s = Sales::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(25);
        $unpaid_sales_s = Sales::where('user_id', Auth::id())
            ->where('is_paid', false)
            ->where('use_points', false)
            ->where('status', '<>', 3)
            ->orderBy('created_at', 'desc')->get();
        return view('inabay.users.my_account.show', compact('user', 'sales_s', 'unpaid_sales_s', 'current_month_str', 'current_year', 'last_month_str', 'last_month_year'));
    }

    public function user_stock() {
        $user_stocks = UserStock::where('user_id', Auth::user()->id)->paginate(20);
        return view('inabay.users.my_account.stock', compact('user_stocks'));
    }

    private function month_str($month) {
        switch($month) {
            case 1: return 'Januari';
            case 2: return 'Februari';
            case 3: return 'Maret';
            case 4: return 'April';
            case 5: return 'Mei';
            case 6: return 'Juni';
            case 7: return 'Juli';
            case 8: return 'Agustus';
            case 9: return 'September';
            case 10: return 'Oktober';
            case 11: return 'November';
            case 12: return 'Desember';
        }
    }
}
