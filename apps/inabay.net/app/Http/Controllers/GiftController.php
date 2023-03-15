<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;

class GiftController extends Controller
{

    public function index()
    {
        $products = Product::where('is_gift', true)->orderBy('name', 'asc')->paginate(25);
        return view('inabay.gifts.index', compact('products'));
    }

    public function search(){
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
            ->where('is_gift', true)
            ->paginate(25);
        $search = Input::get('q');
        $products->appends(['q' => $search]);
        return view('inabay.products.index', compact('products', 'search'));
    }

    public function create()
    {
        $this->authorize('admin');
        return view('inabay.gifts.create');
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

        $photo = $request->file('photo');

        $product = new Product();

        $product->name      = $request->name;
        $product->model     = $request->model;
        $product->code      = $request->code;
        $product->description   = $request->description;
        $product->price     = $request->price;
        $product->discount  = 0;
        $product->stock     = $request->stock;
        $product->is_gift   = true;

        if($photo){
            $filename = $this->photoUpload($photo);
            $product->photo = $filename;
        }

        $product->save();
        $id = $product->id;
        return redirect("/gifts/$id");
    }

    public function show($id)
    {
        $product = Product::find($id);
        if($product->photo == null) $photo = '/images/300x300.png';
        else $photo = '/images/products/300/' . $product->photo;

        return view('inabay.gifts.show', compact('product', 'photo'));
    }

    public function edit($id)
    {
        $this->authorize('admin');
        $product = Product::find($id);
        if($product->photo == null) $photo = '/images/300x300.png';
        else $photo = '/images/products/300/' . $product->photo;
        return view('inabay.gifts.edit', compact('product', 'photo'));
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

        $product->name      = $request->name;
        $product->model     = $request->model;
        $product->code      = $request->code;
        $product->description   = $request->description;
        $product->price     = $request->price;
        $product->discount  = 0;
        $product->stock     = $request->stock;
        if($photo){
            // delete existing file
            $file100 = public_path('/images/products/100/').$product->photo;
            $file300 = public_path('/images/products/300/').$product->photo;
            $file800 = public_path('/images/products/800/').$product->photo;
            $fileori = public_path('/images/products/original/').$product->photo;
            File::delete($file100, $file300, $file800, $fileori);

            $filename = $this->photoUpload($photo);
            $product->photo = $filename;
        }

        $product->save();
        $id = $product->id;
        return redirect("/gifts/$id");
    }

    public function destroy($id)
    {
        $this->authorize('admin');
        $product = Product::find($id);
        $product->delete();

        return redirect('/gifts');
    }
}
