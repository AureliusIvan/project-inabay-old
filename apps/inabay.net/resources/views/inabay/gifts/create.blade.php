@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-gift"></i> Hadiah</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Buat Hadiah Baru
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">

            </div>
        </div>
        <div class="box-body">

            <form action ="{{url('/gifts/new')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="col-md-4">
                        <div class="photo">
                            <img src="/images/300x300.png" />
                        </div>
                        <div class="photo-action">
                            <input type="file" name="photo" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="name" class="form-control" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" name="model" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Produk</label>
                                    <input type="text" name="code" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Informasi Produk</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="price" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" name="stock" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <a href="/products" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Buat Hadiah Baru</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop