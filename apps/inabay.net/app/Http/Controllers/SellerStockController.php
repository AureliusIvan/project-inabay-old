<?php

namespace App\Http\Controllers;

use App\Product;
use App\SellerStock;
use App\UserStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerStockController extends Controller
{
    public function index_user(){
        $user_id = Auth::user()->id;
        $seller_stocks = SellerStock::where('user_id', $user_id)->paginate(20);
        return view('inabay.users.my_account.seller_stocks', compact('seller_stocks'));
    }

    public function store(Request $request){
        $seller_stock = new SellerStock();
        $product = Product::find($request->product_id);
        $seller_stock->user_id = $request->user_id;
        $seller_stock->product_id = $request->product_id;
        $seller_stock->stock = $request->stock;
        $product->stock -= $request->stock;
        $seller_stock->save();
        $product->save();
        return redirect('/products/' . $request->product_id . '#seller-stocks');
    }

    public function update(Request $request, $id){
        $seller_stock = SellerStock::find($id);
        $product = Product::find($seller_stock->product_id);
        $selisih = $request->stock - $seller_stock->stock;
        $seller_stock->stock = $request->stock;
        $product->stock -= $selisih;
        $seller_stock->save();
        $product->save();
        if($seller_stock->stock == 0)
            $seller_stock->delete();
        return redirect('/products/' . $request->product_id . '#seller-stocks');
    }
}
