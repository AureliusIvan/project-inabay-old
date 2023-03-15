<?php

namespace App\Http\Controllers;

use App\Courier;
use App\Product;
use App\Sales;
use App\SalesDetail;
use App\ShoppingCart;
use App\User;
use App\UserStock;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Milon\Barcode\DNS1D;

class SalesController extends Controller
{
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

    public function index_member(){
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
        return view('inabay.member_area.sales.index', compact('user', 'sales_s', 'current_month_str', 'current_year', 'last_month_str', 'last_month_year'));
    }

    public function index(){
        $this->authorize('office');
        $user = Auth::user();
        $search_words = null;
        $search = false;
        $per_page = 25;
        $sales_s = Sales::where('status', '<>', 3)->orderBy('created_at', 'desc')->paginate($per_page);
        $mode = 'active';
        return view('inabay.sales.index', compact('sales_s', 'mode', 'per_page', 'search', 'search_words', 'user'));
    }

    public function index_cancel(){
        $this->authorize('office');
        $user = Auth::user();
        $search_words = null;
        $search = false;
        $sales_s = Sales::where('status', 3)->orderBy('created_at', 'desc')->paginate(25);
        $mode = 'cancel';
        return view('inabay.sales.index', compact('sales_s', 'mode', 'search', 'search_words', 'user'));
    }

    public function index_all(){
        $this->authorize('office');
        $user = Auth::user();
        $search_words = null;
        $search = false;
        $sales_s = Sales::orderBy('created_at', 'desc')->paginate(25);
        $mode = 'all';
        return view('inabay.sales.index', compact('sales_s', 'mode', 'search', 'search_words', 'user'));
    }

    public function search($mode = 'active') {
//        return $mode;
        $this->authorize('office');
        $user = Auth::user();
        $search = true;
        $search_words = Input::get('q', '');
        $search_term = "%" . $search_words . "%";

        if($mode == 'active'){
            $status_logic = '<>';
            $status_id = 3;
        }elseif($mode == 'cancel'){
            $status_logic = '=';
            $status_id = 3;
        }elseif($mode == 'all'){
            $status_logic = '<>';
            $status_id = 0;
        }

        $sales_s = Sales::where('id', 'like', $search_term)
            ->orWhereHas('courier', function(Builder $query){
            $query->where('name', 'like', '%' . Input::get('q', '') . '%');
        })->orWhereHas('user', function(Builder $query){
            $query->where('name', 'like', '%' . Input::get('q', '') . '%')
                ->orWhere('shop_name', 'like', '%' . Input::get('q', '') . '%');
        })->where('status', $status_logic, $status_id)
            ->orderBy('created_at', 'desc')->paginate(25);

        $sales_s->appends(['q' => $search_words]);

        return view('inabay.sales.index', compact('sales_s', 'mode', 'search', 'search_words', 'user'));
    }

//    public function search_cancel() {
//        $this->authorize('admin');
//        $search = true;
//        $mode = 'cancel';
//        $search_words = Input::get('q', '');
//        $search_term = "%" . $search_words . "%";
//
//        $sales_s = Sales::where('status', 3)
//            ->whereHas('courier', function(Builder $query){
//            $query->where('name', 'like', '%' . Input::get('q', '') . '%');
//        })->orWhereHas('user', function(Builder $query){
//            $query->where('name', 'like', '%' . Input::get('q', '') . '%')
//                ->orWhere('shop_name', 'like', '%' . Input::get('q', '') . '%');
//        })->orderBy('created_at', 'desc')->paginate(25);
//
//        $sales_s->appends(['q' => $search_words]);
//
//        return view('inabay.sales.index', compact('sales_s', 'mode', 'search', 'search_words'));
//    }
//
//    public function search_all() {
//        $this->authorize('admin');
//        $search = true;
//        $mode = 'all';
//        $search_words = Input::get('q', '');
//        $search_term = "%" . $search_words . "%";
//
//        $sales_s = Sales::whereHas('courier', function(Builder $query){
//            $query->where('name', 'like', '%' . Input::get('q', '') . '%');
//        })->orWhereHas('user', function(Builder $query){
//            $query->where('name', 'like', '%' . Input::get('q', '') . '%')
//                ->orWhere('shop_name', 'like', '%' . Input::get('q', '') . '%');
//        })->orderBy('created_at', 'desc')->paginate(25);
//
//        $sales_s->appends(['q' => $search_words]);
//
//        return view('inabay.sales.index', compact('sales_s', 'mode', 'search', 'search_words'));
//    }

    public function create()
    {
        $this->authorize('admin');
        $members = User::where('role_id', 3)->get();
        $products = Product::where('stock', '>', 0)->get();
        $couriers = Courier::where('status', '<>', 0)->get();
        return view('inabay.sales.create', compact('products', 'members', 'couriers'));
    }

    public function store(Request $request)
    {
        // DARI SHOOPPING CART SISI MEMBER
        $sales = new Sales();

        if(isset($request->user_id)){
            // New transaction from admin area
            $sales->user_id         = $request->user_id;
        }else{
            // New transaction from member area
            $sales->user_id         = $request->user()->id;
        }

        $sales->receiver_address    = $request->receiver_address;
        $sales->courier_id          = $request->courier_id;
        $sales->description         = $request->description;
        $sales->booking_code        = $request->booking_code;
        $sales->delivery_cost       = $request->delivery_cost;

        $sales->is_cod  = $request->is_cod;
        $sales->cod_amount = $request->cod_amount;

        $sales->is_dropship     = $request->is_dropship;
        $sales->dropshiper_name = $request->shop_name;
        $sales->dropshiper_phone= $request->shop_phone;

        if($request->use_points == null){
            $sales->use_points = 0;
        }else{
            $sales->use_points = $request->use_points;
            $sales->is_paid = true;
        }

        $sales->save();

        $sales_id = $sales->id;

        $total_sales = 0;
        if(isset($request->user_id)){
            // Create new transaction from admin area
            // user_id is the reseller's user_id
            $product_count = sizeof($request->products);
            for($i=0; $i<$product_count; $i++){

                $total_sales += $request->qty[$i] * $request->price[$i];

                $sales_detail = new SalesDetail();
                $sales_detail->product_id   = $request->products[$i];

                // TODO: make sure if product is gift set qty to 1
                $sales_detail->qty          = $request->qty[$i];

                $sales_detail->price        = $request->price[$i];
                $sales_detail->sales_id     = $sales_id;
                $sales_detail->save();

                $product = Product::find($sales_detail->product_id);
                $product->stock = $product->stock - $sales_detail->qty;
                $product->save();
            }
        }else{
            // Reseller create new transaction from their own account
            $shopping_carts = ShoppingCart::where('is_po', false)->where('user_id', Auth::id())->get();

            foreach($shopping_carts as $s_cart){
                $subtotal = $s_cart->qty * $s_cart->product->price;
                $total_sales += $subtotal;

                // Product stock update is moved to ShoppingCart..
                // MemberProductController@addToCart
                // MemberShoppingCartController@update
                // MemberShoppingCartController@destroy
//                $product = Product::find($s_cart->product_id);
//                $product->stock = $product->stock - $s_cart->qty;
//                $product->save();

                $sales_detail = new SalesDetail();
                $sales_detail->product_id = $s_cart->product_id;
                $sales_detail->qty = $s_cart->qty;
                $sales_detail->price = $s_cart->product->price - $s_cart->product->discount;
                $sales_detail->sales_id = $sales_id;
                $sales_detail->save();
            }
        }

        // Jika user menggunakan poin, maka poin akan dikurangi pada saat checkout awal (status = PROSES)
        // dibagian update_status(), jika status menjadi BATAL, maka poin dikembalikan.
        // Jika user tidak menggunakan poin, maka balance akan dikurangi pada saat checkout awal (status = PROSES)
        // dibagian update_status(), jika status menjadi BATAL, maka balance akan dikembalikan.
        // Jika tidak menggunakan poin ==> Menggunalan balance. Poin akan ditambahkan ketika status menjadi TERKIRIM
        // Penambahan poin terjadi di update_status()

        // POINTS & BALANCE PROCESS FOR NEW TRANSACTION START
        // User yang melakukan transaksi
        $user = User::find($sales->user_id);
        if($sales->use_points && $user->points > ($sales->total_sales_and_delivery_cost)){
            // Transaksi baru (status proses), jika menggunakan poin
            // dan jumlah poin lebih besar daripada total harga dan ongkir
            // Poin user dikurangi sejumlah total harga dan ongkir
            $user->points -= $sales->total_sales_and_delivery_cost;
            $user->save();
        }else{
            // Transaksi baru (status proses), jika menggunakan balance/saldo (tidak menggunakan poin)
            // Balance/saldo user dikurangi sejumlah total harga dan ongkir
            $user->balance -= ($sales->total_sales_and_delivery_cost);
            $user->save();
        }
        // POINTS & BALANCE PROCESS FOR NEW TRANSACTION END

        ShoppingCart::where('user_id', Auth::id())->delete();

        $user = Auth::user();
        if($user->role_id == 3){
            return redirect('/sales/member/' . $sales->id);
        }else{
            return redirect('/sales/' . $sales->id);
        }
    } // store END

    public function store_po(Request $request){
        $sales = new Sales();
        $sales->is_po = true;
        if(isset($request->user_id)){
            // New transaction from admin area
            $sales->user_id         = $request->user_id;
        }else{
            // New transaction from member area
            $sales->user_id         = $request->user()->id;
        }

        $sales->receiver_address    = "-";
        $sales->courier_id          = 19;
        $sales->description         = $request->description;
        $sales->booking_code        = "-";
        $sales->delivery_cost       = 0;

        $sales->is_cod  = false;
        $sales->cod_amount = 0;

        $sales->is_dropship     = false;
        $sales->dropshiper_name = "-";
        $sales->dropshiper_phone= "-";

        if($request->use_points == null){
            $sales->use_points = 0;
        }else{
            $sales->use_points = $request->use_points;
            $sales->is_paid = true;
        }

        $sales->save();

        $sales_id = $sales->id;

        $total_sales = 0;
        if(isset($request->user_id)){
            return "";
//            // Create new transaction from admin area
//            // user_id is the reseller's user_id
//            $product_count = sizeof($request->products);
//            for($i=0; $i<$product_count; $i++){
//
//                $total_sales += $request->qty[$i] * $request->price[$i];
//
//                $sales_detail = new SalesDetail();
//                $sales_detail->product_id   = $request->products[$i];
//
//                // TODO: make sure if product is gift set qty to 1
//                $sales_detail->qty          = $request->qty[$i];
//
//                $sales_detail->price        = $request->price[$i];
//                $sales_detail->sales_id     = $sales_id;
//                $sales_detail->save();
//
////                $product = Product::find($sales_detail->product_id);
////                $product->stock = $product->stock - $sales_detail->qty;
////                $product->save();
//            }
        }else{
            // Reseller create new transaction from their own account
            $shopping_carts = ShoppingCart::where('is_po', true)->where('user_id', Auth::id())->get();

            foreach($shopping_carts as $s_cart){
                $subtotal = $s_cart->qty * $s_cart->product->price;
                $total_sales += $subtotal;

                // Product stock update is moved to ShoppingCart..
                // MemberProductController@addToCart
                // MemberShoppingCartController@update
                // MemberShoppingCartController@destroy
//                $product = Product::find($s_cart->product_id);
//                $product->stock = $product->stock - $s_cart->qty;
//                $product->save();

                $sales_detail = new SalesDetail();
                $sales_detail->product_id = $s_cart->product_id;
                $sales_detail->qty = $s_cart->qty;
                $sales_detail->price = $s_cart->product->price - $s_cart->product->discount;
                $sales_detail->sales_id = $sales_id;
                $sales_detail->save();

//                $user_stock_exists = UserStock::where('user_id', $request->user()->id)
//                    ->where('product_id', $s_cart->product_id)->first();
//                if($user_stock_exists){
//                    $user_stock_exists->qty += $s_cart->qty;
//                    $user_stock_exists->save();
//                }else{
//                    $user_stock = new UserStock();
//                    $user_stock->user_id = $request->user()->id;
//                    $user_stock->product_id = $s_cart->product_id;
//                    $user_stock->qty = $s_cart->qty;
//                    $user_stock->save();
//                }
            }
        }

        // Jika user menggunakan poin, maka poin akan dikurangi pada saat checkout awal (status = PROSES)
        // dibagian update_status(), jika status menjadi BATAL, maka poin dikembalikan.
        // Jika user tidak menggunakan poin, maka balance akan dikurangi pada saat checkout awal (status = PROSES)
        // dibagian update_status(), jika status menjadi BATAL, maka balance akan dikembalikan.
        // Jika tidak menggunakan poin ==> Menggunalan balance. Poin akan ditambahkan ketika status menjadi TERKIRIM
        // Penambahan poin terjadi di update_status()

        // POINTS & BALANCE PROCESS FOR NEW TRANSACTION START
        // User yang melakukan transaksi
        $user = User::find($sales->user_id);
        if($sales->use_points && $user->points > ($sales->total_sales_and_delivery_cost)){
            // Transaksi baru (status proses), jika menggunakan poin
            // dan jumlah poin lebih besar daripada total harga dan ongkir
            // Poin user dikurangi sejumlah total harga dan ongkir
            $user->points -= $sales->total_sales_and_delivery_cost;
            $user->save();
        }else{
            // Transaksi baru (status proses), jika menggunakan balance/saldo (tidak menggunakan poin)
            // Balance/saldo user dikurangi sejumlah total harga dan ongkir
            $user->balance -= ($sales->total_sales_and_delivery_cost);
            $user->save();
        }
        // POINTS & BALANCE PROCESS FOR NEW TRANSACTION END

        ShoppingCart::where('user_id', Auth::id())->delete();

        return redirect('/member/sales/' . $sales->id);

    }

    public function show($id)
    {
        $this->authorize('office');
        $sales = Sales::find($id);
        $sales_details = SalesDetail::where('sales_id', $id)->get();
        return view('inabay.sales.show', compact('sales', 'sales_details'));
    }

    public function show_member($id){
        $user_id = auth()->user()->id;
        $sales = Sales::find($id);
        // check apakah transaksi ini milik user
        if($sales->user_id != $user_id){
            abort(404);
        }
        $sales_details = SalesDetail::where('sales_id', $id)->get();
        return view('inabay.member_area.sales.show', compact('sales', 'sales_details'));
    }

//    public function updateStatus(Request $request, $id){
//        $this->authorize('admin');
//        $sales = Sales::find($id);
//        // $current_status = $sales->status;
//        // $sales->status = $request->status;
//        $sales->courier_receipt = $request->courier_receipt;
//        $sales->save();
//
//        if($request->status == 2 && $sales->use_points == false){ // if status == finished/terkirim && tidak menggunakan poin
//            $sales_details = SalesDetail::where('sales_id', $id)->get();
//            $total_sales = 0;
//            foreach($sales_details as $sales_detail){
//                $total_sales += $sales_detail->qty * $sales_detail->price;
//            }
//
//            // Member point accumulation
//            $points = (int) $total_sales / 50;
//            $user = User::find($sales->user->id);
//            $user->points += $points;
//            $user->save();
//
//        }elseif($request->status == 3 && $current_status == 2){ // jika status semula sudah terkirim, kemudian dibatalkan (retur)
//            $sales_details = SalesDetail::where('sales_id', $id)->get();
//            $total_sales = 0;
//            foreach($sales_details as $sales_detail){
//                $total_sales += $sales_detail->qty * $sales_detail->price;
//            }
//
//            // Member point berkurang
//            $points = (int) $total_sales / 50;
//            $user = User::find($sales->user->id);
//            $user->points -= $points;
//            $user->save();
//        }
//
//        if($request->status == 3){
//            // jika batal, kembalikan stock produk
//            $sales_details = SalesDetail::where('sales_id', $id)->get();
//            foreach($sales_details as $sales_detail){
//                $product = Product::find($sales_detail->product_id);
//                $product->stock = $product->stock + $sales_detail->qty;
//                $product->save();
//            }
//        }
//
//        return redirect("/sales/$id");
//    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
//        $this->authorize('admin');
        $sales = Sales::find($id);
        if(isset($request->delivery_cost)){
            $sales->delivery_cost = $request->delivery_cost;
            $sales->save();
            return redirect("/sales/$id");
        }elseif(isset($request->booking_code)){
            $sales->booking_code = $request->booking_code;
            $sales->save();
            return redirect("/member/sales/$id");
        }
    }

    public function destroy($id)
    {
        //
    }

    public function printLabel($id){
        $sales = Sales::find($id);
//        return $sales->courier->logo;

        // convert str logo to base64 encode
        // https://stackoverflow.com/questions/48655579/image-not-found-or-type-unknown-dompdf-0-8-1-and-codeigniter
        $img_path = $sales->courier->logo;
        if($img_path != ""){
            $img_data = fopen(public_path($img_path), 'rb');
            $img_size = filesize($img_path);
            $binary_image = fread($img_data, $img_size);
            fclose ($img_data);

            $img_src = "data:image/jpeg;base64,".str_replace ("\n", "", base64_encode($binary_image));
        }else{
            $img_src = false;
        }

        if($sales->booking_code){
            $barcode = "data:image/png;base64," . DNS1D::getBarcodePNG($sales->booking_code, 'C128', 1.5, 55);
        }else{
            $barcode = null;
        }
//        return $barcode;

        $sales_details = SalesDetail::where('sales_id', $id)->get();
        $date = new DateTime();
        $current_date = $date->format('d/m/Y');
        $pdf = PDF::loadView('inabay.sales.delivery_label_pdf', compact('sales', 'sales_details', 'current_date', 'img_src', 'barcode'))
            ->setPaper('a6', 'potrait')
            ->setOptions(['isRemoteEnabled' => true]);
        return $pdf->stream();
    }

    public function printInvoice($id){
        $sales = Sales::find($id);
        $sales_details = SalesDetail::where('sales_id', $id)->get();
        $date = new DateTime();
        $current_date = $date->format('d/m/Y');
        $pdf = PDF::loadView('inabay.sales.print_invoice_pdf', compact('sales', 'sales_details', 'current_date'))->setPaper('a6', 'potrait');
        return $pdf->stream();
    }

    public function status_update(Request $request){
        $this->authorize('admin');
        $sales = Sales::find($request->sales_id);
        $status['old'] = $sales->status;
        $sales->status = $request->sales_status;
        $status['new'] = $sales->status;

        if(!$sales->is_po){
            // Jika status menjadi BATAL, maka kembalikan stok produk
            if($status['old'] != 'Batal' && $status['new'] == 'Batal') {
                $sales_details = SalesDetail::where('sales_id', $request->sales_id)->get();
                // Kembalikan stok produk
                foreach($sales_details as $sales_detail){
                    $product = Product::find($sales_detail->product_id);
                    $product->stock += $sales_detail->qty;
                    $product->save();
                }
                // Jika status menjadi TIDAK BATAL, maka kurangi stok produk
            }elseif($status['old'] == 'Batal' && $status['new'] != 'Batal'){
                $sales_details = SalesDetail::where('sales_id', $request->sales_id)->get();
                foreach($sales_details as $sales_detail){
                    $product = Product::find($sales_detail->product_id);
                    $product->stock -= $sales_detail->qty;
                    $product->save();
                }
            }
        }elseif($sales->is_po){ // TRANSAKSI BARANG PO
            // Jika status Terkirim --> X, kurangi stok user
            if($status['old'] == 'Terkirim' && $status['new'] != 'Terkirim') {
                $sales_details = SalesDetail::where('sales_id', $request->sales_id)->get();
                // Kembalikan stok produk
                foreach($sales_details as $sales_detail){
                    $user_stock = UserStock::where('product_id', $sales_detail->product_id)->where('user_id', $request->user()->id)->first();
                    $user_stock->qty -= $sales_detail->qty;
                    $user_stock->save();
                }
                // Jika status X --> Terkirim
            }elseif($status['old'] != 'Terkirim' && $status['new'] == 'Terkirim'){
                $sales_details = SalesDetail::where('sales_id', $request->sales_id)->get();
                foreach($sales_details as $sales_detail){
                    $user_stock_exists = UserStock:: where('product_id', $sales_detail->product_id)->where('user_id', $request->user()->id)->first();
                    if($user_stock_exists){
                        $user_stock_exists->qty += $sales_detail->qty;
                        $user_stock_exists->save();
                    }else{
                        $user_stock = new UserStock();
                        $user_stock->product_id = $sales_detail->product_id;
                        $user_stock->user_id = $request->user()->id;
                        $user_stock->qty = $sales_detail->qty;
                        $user_stock->save();
                    }
                }
            }
        }

        // User yang melakukan transaksi
        $user = User::find($sales->user_id);
        if($sales->use_points){ // Jika transaksi menggunakan poin
            // Jika status berubah dari Proses/Siap/Terkirim menjadi Batal
            if($status['old'] != 'Batal' && $status['new'] == 'Batal'){
                $user->points += $sales->total_sales_and_delivery_cost;
                $user->save();
            }elseif($status['old'] == 'Batal' && $status['new'] != 'Batal'){
                $user->points -= $sales->total_sales_and_delivery_cost;
                $user->save();
            }
        }else{ // Jika transaksi menggunakan balance/saldo (tidak menggunakan poin)
            // UPDATE BALANCE
            // Jika status berubah dari Proses/Siap/Terkirim menjadi Batal
            if($status['old'] != 'Batal' && $status['new'] == 'Batal'){
                $user->balance += $sales->total_sales_and_delivery_cost;
                $user->save();
            // Jika status berubah dari Batal menjadi Proses/Siap/Terkirim
            }elseif($status['old'] == 'Batal' && $status['new'] != 'Batal'){
                $user->balance -= $sales->total_sales_and_delivery_cost;
                $user->save();
            }

            // UPDATE POINTS
            $points = floor($sales->total_sales/5000) * 100;
            // Jika status berubah dari Proses/Siap/Batal menjadi Terkirim
            if($status['old'] != 'Terkirim' && $status['new'] == 'Terkirim'){
                $user->points += $points;
                $user->save();
            }elseif($status['old'] == 'Terkirim' && $status['new'] != 'Terkirim'){
                $user->points -= $points;
                $user->save();
            }
        }

        $sales->save();

        // Jika status menjadi TERKIRIM
        // Periksa apakah user menggunakan p

        return $status;
    }
}
