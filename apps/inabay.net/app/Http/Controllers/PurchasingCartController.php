<?php

namespace App\Http\Controllers;

use App\PurchasingCart;
use Illuminate\Http\Request;

class PurchasingCartController extends Controller
{
    public function index()
    {
        $carts = PurchasingCart::all();
        return view('inabay.purchasing_carts.index', compact('carts'));
    }

    public function ajax_add_product(Request $request){
        $cart = new PurchasingCart();
        $cart->product_id = $request->product_id;
        $cart->qty = $request->qty;
        $cart->save();

        return "success";
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
        //
    }

    public function destroy($id)
    {
        //
    }
}
