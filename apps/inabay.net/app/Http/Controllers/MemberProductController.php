<?php

namespace App\Http\Controllers;

use App\Product;
use App\SellerStock;
use App\ShoppingCart;
use App\UserStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class MemberProductController extends Controller
{
    public function index()
    {
        $mode = 'home';
        $info = null;
        $search = null;
        $user = Auth::user();
        if(isset($user) && $user->is_active == 1) {
            if($user->role == "Anggota"){
                $products = Product::where('is_gift', false)->where('stock', '>', 0)->orderBy('name', 'asc')->paginate(20);
                return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
            }else{
                return view('home');
            }
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function gifts() {
        $mode = 'gifts';
        $info = null;
        $search = null;
        $products = Product::where('is_gift', true)
            ->where('stock', '>', 0)
            ->orderBy('name', 'asc')
            ->paginate(20);
        return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
    }

    public function sale() {
        $mode = 'sale';
        $info = null;
        $search = null;
        $products = Product::where('is_sale', true)
            ->where('stock', '>', 0)
            ->orderBy('name', 'asc')
            ->paginate(20);
        return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
    }

    public function new_products() {
        $mode = 'updates';
        $info = "Produk baru dalam 30 hari terakhir";
        $from = date('Y-m-d H:i:s', strtotime('-30 days'));
        $to = date('Y-m-d H:i:s');
        $search = null;
        $products = Product::where('is_gift', false)
            ->whereBetween('created_at', [$from, $to])
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
    }

    public function restock_products() {
        $mode = 'updates';
        $info = "Re-stok produk dalam 30 hari terakhir";
        $from = date('Y-m-d H:i:s', strtotime('-30 days'));
        $to = date('Y-m-d H:i:s');
        $search = null;
        $products = Product::where('is_gift', false)
            ->whereBetween('restock_at', [$from, $to])
            ->where('stock', '>', 0)
            ->orderBy('restock_at', 'desc')
            ->paginate(20);
        return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
    }

    public function empty_stock_products() {
        $mode = 'empty';
        $info = "Produk yang stoknya kosong dalam 30 hari terakhir";
        $from = date('Y-m-d H:i:s', strtotime('-30 days'));
        $to = date('Y-m-d H:i:s');
        $search = null;
        $products = Product::where('is_gift', false)
            ->where('stock', 0)
            ->whereBetween('updated_at', [$from, $to])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
    }

    public function open_po() {
        $mode = 'po';
        $info = "Produk Open PO";
        $search = null;
        $products = Product::where('is_open_po', true)
            ->orderBy('name', 'asc')
            ->paginate(20);
        return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
    }

    public function search(){
        $mode = 'search';
        $info = null;
        $search_words = Input::get('q', '');
        $search_words = explode(" ", $search_words);
        $search_term = "";
        $search_size = "";
        foreach($search_words as $search_word){
            if($search_word == "s" || $search_word == "m" || $search_word == "l" || $search_word == "xl"){
                $search_size = "% " . strtoupper($search_word) . " %";
            }else{
                $search_term .= "%" . $search_word;
            }
        }
        $search_term .= "%";

        if($search_size != "") {
            $products = Product::where('stock', '>', 0)
                ->where('name', 'like', $search_size)
                ->where('name', 'like', $search_term)
                ->orWhere('model', 'like', $search_term)
                ->orWhere('code', 'like', $search_term)
                ->orderBy('name', 'asc')
                ->paginate(20);
        }else{
            $products = Product::where('stock', '>', 0)
                ->where('name', 'like', $search_term)
                ->orWhere('model', 'like', $search_term)
                ->orWhere('code', 'like', $search_term)
                ->orderBy('name', 'asc')
                ->paginate(20);
        }

        $search = Input::get('q');
        $products->appends(['q' => $search]);
        return view('inabay.member_area.products.index', compact('products', 'search', 'info', 'mode'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        $curr_user_id = Auth::id();

        //user has stock?
        $user_stock_qty = 0;
        $user_stock_exists = UserStock::where('product_id', $product->id)->where('user_id', $curr_user_id)->first();
        if($product->is_open_po && $user_stock_exists){
            $user_stock_qty = $user_stock_exists->qty;
        }

        $user_seller_stock_stock = 0;
        $seller_stock_exists = SellerStock::where('product_id', $product->id)->where('user_id', $curr_user_id)->first();
        if($product->is_seller_stocks && $seller_stock_exists){
            $user_seller_stock_stock = $seller_stock_exists->stock;
        }

        if($product->photo == null) $photo = '/images/300x300.png';
        else $photo = '/images/products/300/' . $product->photo;
        return view('inabay.member_area.products.show', compact('product', 'photo', 'user_stock_qty', 'user_seller_stock_stock'));
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        if ($request->keranjang) {
//        return "error";
            $cart_exists = ShoppingCart::where('product_id', $request->product_id)->where('user_id', $request->user()->id)->first();
            $product = Product::find($request->product_id);
            $seller_stock = SellerStock::where('product_id', $request->product_id)
                                        ->where('user_id', $request->user()->id)->first();
            $user_seller_stock_stock = 0;
            if($seller_stock){
                $user_seller_stock_stock = $seller_stock->stock;
            }
            if ($cart_exists) { // JIKA SUDAH ADA PRODUK YANG SAMA DI KERANJANG REGULER
                if ($product->is_gift) {
                    $cart_exists->qty = 1;
                } else {
                    if($product->is_seller_stocks){ // JIKA PRODUK SELER STOCK
                        // TODO: dasjdasdj
                        if(($product->stock + $user_seller_stock_stock) < $request->qty){
                            return "Stok produk tidak mencukupi, silahkan kembali dan refresh halaman produk.";
                        }else{
                            $cart_exists->qty += $request->qty;
                            // product->stock
                            // user_seller_stock_stock
                            // request->qty
                            /*
                             * Jika request <= seller stock => seller stock = seller stock - request
                             * Jika request > seller stock =>
                             *                      selisih = request - seller stock
                             *                      seller stock = 0
                             *                      product stoc - selisih
                             *                      save: product, seller_stock
                             */
                            if($request->qty <= $user_seller_stock_stock){
                                $seller_stock->stock = $seller_stock - $request->qty;
                                $seller_stock->save();
                                if($seller_stock->stock == 0) {
                                    $seller_stock->delete();
                                }
                            }else{
                                if($seller_stock){
                                    $selisih = $request->qty - $seller_stock->stock;
                                    $seller_stock->delete();
                                    $product->stock -= $selisih;
                                    $product->save();
                                }else{
                                    $product->stock -= $request->qty;
                                    $product->save();
                                }
                            }
                        }
                    }else{ // JIKA BUKAN PRODUK SELLER STOCK
                        if(!$product->is_open_po){ // JIKA BUKAN PRODUK OPEN PO
                            if ($product->stock < $request->qty) {
                                return "Stok produk tidak mencukupi, silahkan kembali dan refresh halaman produk.";
                            } else {
                                $cart_exists->qty = $cart_exists->qty + $request->qty;
                                $product->stock -= $request->qty; // kurangi stock produk ketika disimpan ke keranjang
                                $product->save();
                            }
                        }elseif($product->is_open_po){ // JIKA PRODUK OPEN PO
                            $user_stock = UserStock::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
                            if($request->qty <= $user_stock->qty){
                                $cart_exists->qty += $request->qty;
                                $user_stock->qty -= $request->qty;
                                $user_stock->save();
                            }elseif($request->qty > $user_stock->qty){
                                return "Stok produk tidak mencukupi, silahkan kembali dan refresh halaman produk.";
                            }
                        }
                    }
                }
//            if($cart_exists->qty > $product->stock)
//                $cart_exists->qty = $product->stock;
                $cart_exists->save();
            } else { // JIKA BELUM ADA PRODUK YANG SAMA DI KERANJANG REGULER
                $shopping_cart = new ShoppingCart();
                $shopping_cart->product_id = $request->product_id;
                $shopping_cart->user_id = $request->user()->id;
//                $shopping_cart->qty = $request->qty;
                $user_stock = UserStock::where('user_id', $user->id)->where('product_id', $request->product_id)->first();

                if($product->is_seller_stocks){ // JIKA PRODUK SELER STOCK
                    // TODO: dasjdasdj
                    if(($product->stock + $user_seller_stock_stock) < $request->qty){
                        return "Stok produk tidak mencukupi, silahkan kembali dan refresh halaman produk.";
                    }else{
                        $shopping_cart->qty = $request->qty;
                        $shopping_cart->save();
                        // product->stock
                        // user_seller_stock_stock
                        // request->qty
                        /*
                         * Jika request <= seller stock => seller stock = seller stock - request
                         * Jika request > seller stock =>
                         *                      selisih = request - seller stock
                         *                      seller stock = 0
                         *                      product stoc - selisih
                         *                      save: product, seller_stock
                         */
                        if($request->qty <= $user_seller_stock_stock){
                            $seller_stock->stock = $seller_stock->stock - $request->qty;
                            $seller_stock->save();
                            if($seller_stock->stock == 0) {
                                $seller_stock->delete();
                            }
                        }else{
                            if($seller_stock){
                                $selisih = $request->qty - $seller_stock->stock;
                                $seller_stock->delete();
                                $product->stock -= $selisih;
                                $product->save();
                            }else{
                                $product->stock -= $request->qty;
                                $product->save();
                            }
                        }
                    }
                }else { // JIKA BUKAN PRODUK SELLER STOCK
                    if(!$product->is_open_po){ // JIKA BUKAN OPEN PO
                        if($request->qty <= $product->stock){ // JIKA REQ QTY <= STOK PRODUK, CART QTY = REQ QTY
                            $shopping_cart->qty = $request->qty;
                        }elseif($request->qty > $product->stock){ // JIKA REQ QTY > STOK PRODUK, CART QTY = STOK PRODUK
                            $shopping_cart->qty = $product->stock;
                        }
                        // KURANGI STOK PRODUK SESUAI DENGAN CART QTY
                        $shopping_cart->save();
                        $product->stock -= $shopping_cart->qty;
                        $product->save();
                    }elseif($product->is_open_po){ // JIKA OPEN PO
                        if($request->qty <= $user_stock->qty){ // JIKA REQ QTY <= STOK USER, CART QTY = REQ QTY
                            $shopping_cart->qty = $request->qty;
                        }elseif($request->qty > $user_stock->qty){ // JIKA REQ QTY > STOK USER, CART QTY = STOK USER
                            $shopping_cart->qty = $user_stock->qty;
                        }
                        // KURANGI STOK USER SESUAI DENGAN CART QTY
                        $shopping_cart->save();
                        $user_stock->qty -= $shopping_cart->qty;
                        $user_stock->save();
                    }
                }
//                if ($request->qty > $product->stock && !$product->is_open_po) {
//                    $shopping_cart->qty = $product->stock;
//                    $product->stock -= $request->qty; // kurangi stock produk ketika disimpan ke keranjang
//                    $product->save();
//                }elseif($request->qty > $user_stock->qty && $product->is_open_po) {
//                    $shopping_cart->qty = $user_stock->qty;
//                    $user_stock->qty -= $request->qty; // kurangi stok user ketika disimpan ke keranjang reguler
//                    $user_stock->save();
//                }
//                $shopping_cart->save();
            }
            return redirect('/member/cart');
        }else if($request->keranjang_po){
            $cart_exists = ShoppingCart::where('is_po', true)
                ->where('product_id', $request->product_id)
                ->where('user_id', $request->user()->id)->first();
            if($cart_exists){
                $cart_exists->qty = $cart_exists->qty + $request->qty;
                $cart_exists->save();
            }else{
                $shopping_cart = new ShoppingCart();
                $shopping_cart->product_id = $request->product_id;
                $shopping_cart->user_id = $request->user()->id;
                $shopping_cart->qty = $request->qty;
                $shopping_cart->is_po = true;
                $shopping_cart->save();
            }
            return redirect('/member/cart-po');
        }
    }

}
