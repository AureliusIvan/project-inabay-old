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
    <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">

            <div class="box-body">
                <div class="col-md-4">
                    <div class="photo">
                        <img class="img-responsive" src="{{$photo}}" />
                    </div>
                </div>
                <div class="col-md-8">
                    <dl class="dl-horizontal">
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
                        <dt>Link Foto</dt>
                        <dd><a href="{{$product->drive_link}}">{{$product->drive_link}}</a></dd>
                    </dl>
                    @if($product->stock > 0)
                        <div class="transaction">
                            <form action="{{url('/test')}}" method="post" class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="form-group col-md-6">
                                    <label class="col-sm-4 control-label">Jumlah</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="product_id" value="{{$product->id}}" />
                                        @if($product->is_gift)
                                            <input type="hidden" name="qty" value="1" />
                                            <input type="number" value="1" class="form-control" disabled />
                                        @else
                                            <input type="number" name="qty" value="1" max="{{$product->stock}}" class="form-control" />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" name="keranjang" value="Tambah ke Keranjang" />
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-12 text-right">

                </div>
            </div>

        </div>
    </div>

@stop
