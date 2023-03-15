<?php

namespace App\Http\Controllers;

use App\Product;
use App\SellerStock;
use App\ShoppingCart;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{

    public function index()
    {
        $this->authorize('admin');
        //
        $mode = 'all';
        $products = Product::where('is_gift', false)->orderBy('name', 'asc')->paginate(25);
        return view('inabay.products.index', compact('products', 'mode'));
    }

    public function index_stock_seller(){
        $this->authorize('admin');
        $mode = 'stock-seller';
        $products = Product::where('is_seller_stocks', true)->orderBy('name', 'asc')->paginate(25);
        return view('inabay.products.index', compact('products', 'mode'));
    }

    public function index_sale(){
        $this->authorize('admin');
        $mode = 'sale';
        $products = Product::where('is_gift', false)->where('is_sale', true)->orderBy('name', 'asc')->paginate(25);
        return view('inabay.products.index', compact('products', 'mode'));
    }

    public function index_open_po() {
        $this->authorize('admin');
        $mode = 'open-po';
        $products = Product::where('is_open_po', true)->orderBy('name', 'asc')->paginate(25);
        return view('inabay.products.index', compact('products', 'mode'));
    }

    public function index_stock() {
        $this->authorize('admin');
        $mode = 'stock';
        $products = Product::orderBy('name', 'asc')->paginate(10);

        $carts = ShoppingCart::all();
        // TODO: product qty dalam shopping cart masuk ke dalam jumlah stock opname, termasuk product yang masih dalam tahap proses

        return view('inabay.products.stock-opname', compact('products', 'mode'));
    }

    public function index_stock_page() {
        $this->authorize('admin');
        $page = Input::get('page');
        return redirect('products/stock-opname?page=' . $page);
    }

    public function index_stock_search(){
        $this->authorize('admin');
        $search_words = Input::get('q', '');
        $search_words = explode(" ", $search_words);
        $search_term = "";
        foreach($search_words as $search_word){
            $search_term .= "%" . $search_word;
        }
        $search_term .= "%";

        $products = Product::where('name', 'like', $search_term)
            ->orWhere('model', 'like', $search_term)
            ->orWhere('code', 'like', $search_term)
            ->where('is_gift', false)
            ->paginate(25);
        $search = Input::get('q');
        $products->appends(['q' => $search]);
        $mode = '';
        return view('inabay.products.stock-opname', compact('products', 'search', 'mode'));
    }

    public function stock_update(Request $request) {
        $this->authorize('admin');
        $product = Product::find($request->product_id);
        $product->stock = $request->stock;
        $product->save();
        return $product->stock;
    }

    public function search(){
        $this->authorize('admin');
        $search_words = Input::get('q', '');
        $search_words = explode(" ", $search_words);
        $search_term = "";
        foreach($search_words as $search_word){
            $search_term .= "%" . $search_word;
        }
        $search_term .= "%";

        $products = Product::where('name', 'like', $search_term)
            ->orWhere('model', 'like', $search_term)
            ->orWhere('code', 'like', $search_term)
            ->where('is_gift', false)
            ->paginate(25);
        $search = Input::get('q');
        $products->appends(['q' => $search]);
        $mode = '';
        return view('inabay.products.index', compact('products', 'search', 'mode'));
    }

    public function create()
    {
        $this->authorize('admin');
        $suppliers = Supplier::all();
        $product = new Product();
        $photo = null;
        return view('inabay.products.create', compact('product', 'photo', 'suppliers'));
    }

    public function create_copy($id)
    {
        $this->authorize('admin');
        $suppliers = Supplier::all();
        $product = Product::find($id);
        if($product->photo == null) $photo = '/images/300x300.png';
        else $photo = '/images/products/300/' . $product->photo;
        return view('inabay.products.create', compact('product', 'photo', 'suppliers'));
    }

    private function photoUpload($photo){
        $this->authorize('admin');
        // TODO: Pisahkan folder untuk setiap vendor
        $filename = time() . '.' . $photo->getClientOriginalExtension();

        $img = Image::make($photo->getRealPath());

//        $destinationPath = public_path('/images/products/800');
//        $img->fit(800)->save($destinationPath.'/'.$filename);
        $destinationPath = public_path('/images/products/300');
        $img->fit(300)->save($destinationPath.'/'.$filename);
        $destinationPath = public_path('/images/products/100');
        $img->fit(100)->save($destinationPath.'/'.$filename);

//        $destinationPath = public_path('/images/products/original');
//        $photo->move($destinationPath, $filename);

        return $filename;
    }

    public function store(Request $request)
    {
        $this->authorize('admin');
        $request->validate([
            'photo'     => 'image|mimes:jpeg,jpg,png,svg',
            'name'      => 'required',
            'model'     => 'required',
            'price'     => 'required'
        ]);

        $datetime = date('Y-m-d H:i:s');

        $photo = $request->file('photo');

        // IF PRODUCT EXISTS
        $p = Product::where('model', $request->model)->where('name', $request->name)->first();
        if(!empty($p->id)){
            return Redirect::back()->withErrors(['msg', 'Produk Sudah Ada']);
        }
        // END IF PRODUCT EXISTS

        $product = new Product();

        $disc_type = $request->disc_type;
        if($disc_type == "percent"){
            $discount = ($request->discount/100) * $request->price;
        }else{
            $discount = $request->discount;
        }

        $product->name      = $request->name;
        $product->model     = $request->model;
        $product->code      = $request->code;
        $product->description   = $request->description;
        $product->price     = $request->price;
        $product->hpp     = $request->hpp;
        $product->discount  = $discount;
        $product->stock     = $request->stock;
        $product->is_gift   = false;
        $product->drive_link= $request->drive_link;
        $product->restock_at = $datetime;
        $product->supplier_id = $request->supplier_id;
        $product->is_open_po     = $request->is_open_po;
        $product->open_po_order_deadline = $request->open_po_order_deadline;
        $product->is_seller_stocks = $request->is_seller_stocks;

        if($photo){
            $filename = $this->photoUpload($photo);
            $product->photo = $filename;
        }

        $product->save();
        $id = $product->id;
        return redirect("/products/$id");
    }

    public function show($id)
    {
        $this->authorize('admin');

        $seller_stocks = SellerStock::where('product_id', $id)->get();
        $user_ids = array();
        $total_seller_stock = 0;
        foreach($seller_stocks as $seller_stock){
            $total_seller_stock += $seller_stock->stock;
            array_push($user_ids, $seller_stock->user_id);
        }

        $users = User::where('role_id', 3)->where('is_active', true)->whereNotIn('id', $user_ids)->orderBy('name', 'asc')->get();
        $seller_stocks = DB::table('users')
                            ->leftJoin('seller_stocks', 'users.id', '=', 'seller_stocks.user_id')
                            ->where('seller_stocks.product_id', '=', $id)
                            ->get();
        $product = Product::find($id);
        if($product->photo == null) $photo = '/images/300x300.png';
        else $photo = '/images/products/300/' . $product->photo;

//        $products = Product::where('is_gift', false)->orderBy('name', 'asc')->paginate(25);
        $no = (int) Input::get('no');
        $all = Product::where('is_gift', false)->orderBy('name', 'asc')->get()->toArray();

        if(isset($no) && $no != null){
            if($no == 1){
                $prev_id = 0;
            }else{
                $prev_id = $all[$no-2]['id'];
            }

            if(sizeof($all) == $no){
                $next_id = 0;
            }else{
                $next_id = $all[$no]['id'];
            }
        }else{
            $prev_id = 0;
            $next_id = 0;
        }

        // TODO: first and last record array index problem
        return view('inabay.products.show', compact('product', 'photo', 'next_id', 'no', 'prev_id', 'users', 'seller_stocks', 'total_seller_stock'));
    }

    public function edit($id)
    {
        $this->authorize('admin');
        $suppliers = Supplier::all();
        $product = Product::find($id);
        if($product->photo == null) $photo = '/images/300x300.png';
        else $photo = '/images/products/300/' . $product->photo;
        return view('inabay.products.edit', compact('product', 'photo', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('admin');
        $request->validate([
            'photo'     => 'image|mimes:jpeg,jpn,png,svg',
            'name'      => 'required',
            'model'     => 'required',
            'price'     => 'required'
        ]);

        $photo = $request->file('photo');

        $product = Product::find($id);

        $disc_type = $request->disc_type;
        if($disc_type == "percent"){
            $discount = ($request->discount/100) * $request->price;
        }else{
            $discount = $request->discount;
        }

        // set restock timestamp if prev stock is 0/less and the new stock is larger than 0
        if($product->stock <= 0 && $request->stock > 0){
            $product->restock_at = date('Y-m-d H:i:s');
        }

        $product->name      = $request->name;
        $product->model     = $request->model;
        $product->code      = $request->code;
        $product->description   = $request->description;
        $product->price     = $request->price;
        $product->hpp     = $request->hpp;
        $product->discount  = $discount;
        $product->stock     = $request->stock;
        $product->is_sale   = $request->is_sale;
        $product->drive_link= $request->drive_link;
        $product->is_open_po     = $request->is_open_po;
        $product->open_po_order_deadline = $request->open_po_order_deadline;
        $product->is_seller_stocks = $request->is_seller_stocks;
        if($photo){
            // delete existing file
            $file100 = public_path('/images/products/100/').$product->photo;
            $file300 = public_path('/images/products/300/').$product->photo;
//            $file800 = public_path('/images/products/800/').$product->photo;
//            $fileori = public_path('/images/products/original/').$product->photo;
            File::delete($file100, $file300);

            $filename = $this->photoUpload($photo);
            $product->photo = $filename;
        }

        $product->supplier_id = $request->supplier_id;

        $product->save();
        $id = $product->id;
        return redirect("/products/$id");

    }

    public function destroy($id)
    {
        $this->authorize('admin');
        $product = Product::find($id);

        if($product->photo){
            // delete existing file
            $file100 = public_path('/images/products/100/').$product->photo;
            $file300 = public_path('/images/products/300/').$product->photo;
            File::delete($file100, $file300);
        }
        $product->photo = null;
        $product->save();

        $product->delete();

        return redirect('/products');
    }

    public function get_product_price(Request $request){
        $product = Product::find($request->product_id);
        $product_price = $product->price - $product->discount;
        $product_thumb = $product->photo;
        $product_stock = $product->stock;
        $product_info['price'] = $product_price;
        $product_info['thumb'] = $product_thumb;
        $product_info['stock'] = $product_stock;
        return $product_info;
        //return $product->price - $product->discount;
    }


}
