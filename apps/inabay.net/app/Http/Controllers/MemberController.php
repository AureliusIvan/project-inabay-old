<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    public function index()
    {
        // Halaman ini hanya bisa diakses oleh admin
        $this->authorize('admin');

        $page = "member";
        $users = User::where('role_id', 3)->paginate(25);
        return view('inabay.users.index', compact('users', 'page'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('inabay.users.create');
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
        $user->role_id      = 3; // member

        $user->save();

        if(isset($request->self) && $request->self  == 1){
            return redirect('/user');
        }else {
            return redirect('/members');
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('inabay.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('inabay.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        ]);

        $current_user = Auth::user();
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

        if($current_user->role_id == 0 || $current_user->role_id == 1){
            if(isset($user->balance)) $user->balance = $request->balance;
            if(isset($user->points)) $user->points = $request->points;
        }
        if($current_user->role_id == 0 || $current_user->role_id == 1 || $current_user->role_id == 2){
            $user->is_active = $request->is_active;
        }

        $user->email            = $request->email;

        if($request->password != null){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('/members/' . $user->id);
    }

    public function destroy($id)
    {
        //
    }
}
