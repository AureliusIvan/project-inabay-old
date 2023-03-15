@extends('adminlte::page')

@section('title', 'Pesan Barang | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-shopping-cart"></i> Pesan Barang</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Daftar Pesanan
            </h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="#" class="btn btn-danger"><i class="fa fa-trash-alt"></i> Hapus Terpilih</a>
            <a href="#" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Produk</a>
            <a href="#" class="btn btn-success"><i class="fa fa-print"></i> Cetak Pesanan</a>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">

        </div>
        <div class="box-body table-responsive">

            <table class="table table-hover">
                <tbody>
                <tr>
                    <th><input type="checkbox" /></th>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Model</th>
                    <th>Kode Produk</th>
                    <th class="text-right">Harga Modal</th>
                    <th class="text-center">Jumlah Stok</th>
                    <th>Supplier</th>
                    <th class="text-center" width="110">Jumlah Pesanan</th>
                </tr>

                @foreach($carts as $cart)
                    <tr>
                        <td><input type="checkbox" /></td>
                        <td><img class="img-responsive" src="/images/products/100/{{$cart->product->photo}}" /></td>
                        <td>{{$cart->product->name}}</td>
                        <td>{{$cart->product->model}}</td>
                        <td>{{$cart->product->code}}</td>
                        <td class="text-right">N/A</td>
                        <td class="text-center">{{$cart->product->stock}}</td>
                        <td>{{$cart->product->supplier->name}}</td>
                        <td class="text-center"><input class="form-control" type="number" value="{{$cart->qty}}" /></td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
{{--                    {{$products->links()}}--}}
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop
