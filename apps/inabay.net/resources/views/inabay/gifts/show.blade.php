@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-gift"></i> Hadiah</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Informasi Hadiah
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-8">

            </div>
            <div class="col-md-4 text-right">
                @if($product->deletable())
                    <form action="/gifts/delete/{{$product->id}}" method="post" class="inline">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                @else
                    <button class="btn btn-danger disabled">Hapus</button>
                @endif
                <a href="/gifts/edit/{{$product->id}}" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah</a>
            </div>
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
                            <dd>{{$product->name}}</dd>
                            <dt>Model</dt>
                            <dd>{{$product->model}}</dd>
                            <dt>Kode Produk</dt>
                            <dd>{{$product->code}}</dd>
                            <dt>Informasi Produk</dt>
                            <dd>{{$product->description}}</dd>
                            <dt>Harga</dt>
                            <dd>{{$product->price}}</dd>
                            <dt>Stok</dt>
                            <dd>{{$product->stock}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">

                    </div>
                </div>

        </div>
    </div>

@stop
