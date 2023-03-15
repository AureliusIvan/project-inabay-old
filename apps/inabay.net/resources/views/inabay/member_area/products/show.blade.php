@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Produk</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Informasi Produk
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>





                <div class="col-md-4">
                    <div class="photo">
                        <img class="img-responsive" src="{{$photo}}" />
                    </div>
                </div>
                <div class="col-md-8">
                    <dl class="dl-horizontal">
                        <dt></dt>
                        <dd>
                            @if($product->is_open_po)
                                <span class="label bg-green-gradient">OPEN PO</span>
                            @endif
                        </dd>
                        <dt>Nama Produk</dt>
                        <dd>{{$product->name}}
                            @if($product->is_gift)
                                <small class="label bg-green"><i class="fas fa-gift"></i> Gift</small>
                            @endif
                            @if($product->is_sale)
                                <small class="label bg-red"><i class="fas fa-tag"></i> Sale</small>
                            @endif
                        </dd>
                        <dt>Model</dt>
                        <dd>{{$product->model}}</dd>
                        <dt>Kode Produk</dt>
                        <dd>{{$product->code}}</dd>
                        <dt>Informasi Produk</dt>
                        <dd>{{$product->description}}</dd>
                        <dt>Harga</dt>
                        <dd>{{$product->price}}</dd>
                        <dt>Diskon</dt>
                        <dd>{{$product->discount}}</dd>
                        <dt>Harga Anggota</dt>
                        <dd>{{$product->price - $product->discount}}</dd>
                        <dt>Stok</dt>
                        <dd><b>{{$product->stock}}</b> / {{$product->total_stock}} (total stok produk dengan nama yang sama)</dd>
                        @if($product->is_open_po)
                            <dt>Stok Pribadi (PO)</dt>
                            <dd>{{$user_stock_qty}}</dd>
                        @endif
                        @if($product->is_seller_stocks)
                            <dt>Stok Pribadi (Gdg. Saya)</dt>
                            <dd><b>{{$user_seller_stock_stock}}</b></dd>
                        @endif
                        <dt>Link Foto</dt>
                        <dd><a href="{{$product->drive_link}}">Klik Disini</a></dd>
                    </dl>
                    @if($product->is_seller_stocks)
                    <div class="callout callout-warning">
                        <p>
                            Stok yang akan digunakan terlebih dahulu adalah <b>stok pribadi</b>.<br />
                            Jika Anda membatalkan transaksi/menghapus keranjang belanja atau mengurangi jumlah produk dari keranjang belanja,
                            maka stok barang akan dikembalikan kepada Inabay (Stok bersama).
                        </p>
                    </div>
                    @endif
                    @if($product->stock > 0 || $product->is_open_po || ($product->is_seller_stocks && $user_seller_stock_stock>0))
                    <div class="transaction">
                        <form action="{{url('/member/products/add_to_cart')}}" method="post" class="form-horizontal">
                            {{ csrf_field() }}
{{--                            <div class="row">--}}
                                <div class="form-group col-md-4">
                                    <label class="col-sm-4 control-label">Jumlah</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="product_id" value="{{$product->id}}" />
                                        @if($product->is_gift)
                                            <input type="hidden" name="qty" value="1" />
                                            <input type="number" value="1" class="form-control" disabled />
                                        @else
                                            @if($product->is_seller_stocks)
                                                <input type="number" name="qty" value="1" min="1" max="{{$product->stock + $user_seller_stock_stock}}" class="form-control" />
                                            @else
                                                @if(!$product->is_open_po)
                                                    <input type="number" name="qty" value="1" max="{{$product->stock}}" class="form-control" />
                                                @elseif($product->is_open_po && $user_stock_qty > 0)
                                                    <input type="number" name="qty" value="1" class="form-control" />
                                                @elseif($product->is_open_po && $user_stock_qty <= 0)
                                                    <input type="number" name="qty" value="1" class="form-control" />
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" {{($product->is_open_po && $user_stock_qty <= 0) ? 'disabled':''}} name="keranjang" value="Tambah ke Keranjang" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" {{$product->is_open_po ? '':'disabled'}} name="keranjang_po" value="Tambah ke Keranjang PO" />
                                </div>
{{--                            </div>--}}

                        </form>
                    </div>
                    @endif
                </div>



@stop
