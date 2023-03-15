<?php

namespace App\Http\Controllers;

use App\Courier;
use App\Product;
use App\ShoppingCart;
use App\UserStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberShoppingCartController extends Controller
{

    public function index()
    {
        $is_po = false;
        $shopping_carts = ShoppingCart::where('is_po', false)->where('user_id', Auth::id())->get();
        $couriers = Courier::where('status', 1)->orderBy('name', 'ASC')->get();

        $total_price = 0;
        foreach($shopping_carts as $cart){
            $subtotal = ($cart->product->price - $cart->product->discount) * $cart->qty;
            $total_price += $subtotal;
        }

        $shopping_carts_exists = ShoppingCart::where('is_po', false)->where('user_id', Auth::id())->exists();
        return view('inabay.member_area.shopping_cart.index', compact('shopping_carts', 'couriers', 'shopping_carts_exists', 'total_price', 'is_po'));
    }

    public function index_po(){
        $is_po = true;
        $shopping_carts = ShoppingCart::where('is_po', true)->where('user_id', Auth::id())->get();
        $couriers = Courier::where('status', 1)->get();
        $total_price = 0;
        foreach($shopping_carts as $cart) {
            $subtotal = ($cart->product->price - $cart->product->discount) * $cart->qty;
            $total_price += $subtotal;
        }

        $shopping_carts_exists = ShoppingCart::where('is_po', true)->where('user_id', Auth::id())->exists();
        return view('inabay.member_area.shopping_cart.index', compact('shopping_carts', 'couriers', 'shopping_carts_exists', 'total_price', 'is_po'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $cart = ShoppingCart::find($id);
        $product = Product::find($cart->product->id);
        if($request->mode == "plus"){
            if($cart->product->stock > 0){
                $cart->qty = $cart->qty + 1;
                $product->stock -= 1;
                $product->save();
            }
//            $cart->qty = $cart->qty + 1;
//            if($cart->qty >= $cart->product->stock){
//                $cart->qty = $cart->product->stock;
//            }
            $cart->save();
        }elseif($request->mode == "minus"){
            $cart->qty = $cart->qty - 1;
            if(!$cart->product->is_open_po){
                $product->stock += 1;
            }
            $product->save();
            if($cart->qty == 0){
                $cart->delete();
            }else{
                $cart->save();
            }
        }

        $shopping_carts = ShoppingCart::where('user_id', Auth::id())->get();
        $total_price = 0;
        foreach($shopping_carts as $s_cart){
            $subtotal = ($s_cart->product->price - $s_cart->product->discount) * $s_cart->qty;
            $total_price += $subtotal;
        }

        $data['qty'] = $cart->qty;
        $data['total_price'] = $total_price;
        $data['total_price_masked'] = number_format($total_price, 0, ',', '.');
        $data['product_stock'] = $product->stock;
        $data['product_is_open_po'] = $product->is_open_po;

        return $data;
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $shopping_cart = ShoppingCart::find($id);
        if(!$shopping_cart->product->is_open_po){
            $product = Product::find($shopping_cart->product->id);
            $product->stock += $shopping_cart->qty;
            $product->save();
        }else{
            $user_stock = UserStock::where('user_id', $user->id)->where('product_id', $shopping_cart->product->id)->first();
            $user_stock->qty += $shopping_cart->qty;
            $user_stock->save();
        }
        $shopping_cart->delete();

        return redirect("/member/cart");
    }

    public function destroy_po($id){
        $shopping_cart = ShoppingCart::find($id);
        $product = Product::find($shopping_cart->product->id);
        $product->stock += $shopping_cart->qty;
        $product->save();
        $shopping_cart->delete();

        return redirect("/member/cart-po");
    }
}
