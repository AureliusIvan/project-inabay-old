<?php

namespace App\Http\Controllers;

use App\Product;
use App\ShoppingCart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $product = Product::find(1249);
        if($product->photo == null) $photo = '/images/300x300.png';
        else $photo = '/images/products/300/' . $product->photo;
        return view('inabay.test.index', compact('product', 'photo'));
    }

    public function formPostProcess(Request $request) {
        $cart_exists = ShoppingCart::where('product_id', $request->product_id)->where('user_id', $request->user()->id)->first();
        $product = Product::find($request->product_id);
        if($cart_exists){
            if($product->is_gift){
                $cart_exists->qty = 1;
            }else{
                if($product->stock < $request->qty) {
                    return "Stok produk tidak mencukupi, silahkan kembali dan refresh halaman produk.";
                }else {
                    $cart_exists->qty = $cart_exists->qty + $request->qty;
                    $product->stock -= $request->qty; // kurangi stock produk ketika disimpan ke keranjang
                    $product->save();
                }
            }
//            if($cart_exists->qty > $product->stock)
//                $cart_exists->qty = $product->stock;
            $cart_exists->save();
        }else{
            $shopping_cart = new ShoppingCart();
            $shopping_cart->product_id = $request->product_id;
            $shopping_cart->user_id = $request->user()->id;
            $shopping_cart->qty = $request->qty;
            if($request->qty > $product->stock)
                $shopping_cart->qty = $product->stock;
            $product->stock -= $request->qty; // kurangi stock produk ketika disimpan ke keranjang
            $product->save();
            $shopping_cart->save();
        }
        return redirect('/member/cart');
    }

    public function addToCart(Request $request){
//        return "error";
        $cart_exists = ShoppingCart::where('product_id', $request->product_id)->where('user_id', $request->user()->id)->first();
        $product = Product::find($request->product_id);
        if($cart_exists){
            if($product->is_gift){
                $cart_exists->qty = 1;
            }else{
                if($product->stock < $request->qty) {
                    return "Stok produk tidak mencukupi, silahkan kembali dan refresh halaman produk.";
                }else {
                    $cart_exists->qty = $cart_exists->qty + $request->qty;
                    $product->stock -= $request->qty; // kurangi stock produk ketika disimpan ke keranjang
                    $product->save();
                }
            }
//            if($cart_exists->qty > $product->stock)
//                $cart_exists->qty = $product->stock;
            $cart_exists->save();
        }else{
            $shopping_cart = new ShoppingCart();
            $shopping_cart->product_id = $request->product_id;
            $shopping_cart->user_id = $request->user()->id;
            $shopping_cart->qty = $request->qty;
            if($request->qty > $product->stock)
                $shopping_cart->qty = $product->stock;
            $product->stock -= $request->qty; // kurangi stock produk ketika disimpan ke keranjang
            $product->save();
            $shopping_cart->save();
        }
        return redirect('/member/cart');
    }

}
