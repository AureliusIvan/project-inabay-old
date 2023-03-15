<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $info = null;
        $search = null;
        $user = Auth::user();
        if($user->is_active == 1) {
            if($user->role == "Anggota"){
                $products = Product::where('is_gift', false)->where('stock', '>', 0)->orderBy('name', 'asc')->paginate(20);
                return view('inabay.member_area.products.index', compact('products', 'search', 'info'));
            }else{
                return view('home');
            }
        }else{
            Auth::logout();
            return redirect('/');
        }
    }
}
