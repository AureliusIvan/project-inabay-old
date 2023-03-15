@extends('adminlte::page')

@section('title', 'Stock Produk Saya | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Stok Produk Saya</h4>
@stop

@section('content')

    {{--    <div class="row header">--}}
    {{--        <div class="col-md-6">--}}
    {{--            <h1 class="text-blue">--}}
    {{--                Daftar Produk--}}
    {{--            </h1>--}}
    {{--        </div>--}}
    {{--        <div class="col-md-6">--}}
    {{--            --}}{{--<a href="/users/new" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Anggota Baru</a>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6"></div>
            <div class="col-md-3">&nbsp;</div>
        </div>
        <div class="box-body">

            @foreach($seller_stocks as $user_stock)
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box">
                        <div class="">
                            @if($user_stock->product->photo == null)
                                <img class="img-thumbnail no-border" src="/images/300x300.png" />
                            @else
                                <img class="img-thumbnail no-border" src="/images/products/300/{{$user_stock->product->photo}}" />
                            @endif
                        </div>
                        <div class="inner">
                            <a href="/member/products/{{$user_stock->product->id}}">
                                <h4>{{$user_stock->product->name}}</h4>
                                @if($user_stock->product->is_open_po)
                                    <span class="label bg-green-gradient">OPEN PO</span>
                                @endif
                                <h5>Model: {{$user_stock->product->model}}</h5>
                                <div class="product-details">
                                    <span class="product-stock">Stock Inabay: <b>{{$user_stock->product->stock}}</b></span>
                                    <span class="product-stock">Stock Saya: <b>{{$user_stock->stock}}</b></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    {{$seller_stocks->links()}}
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop

@section('custom_js')
@stop
