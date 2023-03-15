@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Produk</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Buat Produk Baru
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

            <form action ="{{url('/products/new')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="col-md-4">
                        <div class="photo img-responsive">
                            <img class="img-responsive" src="/images/300x300.png" />
                        </div>
                        <div class="photo-action">
                            <input type="file" name="photo" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <i class="icon fa fa-ban"></i> Produk Sudah Ada!
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Supplier</label>
                            <select id="supplier_id" class="form-control select2" name="supplier_id" style="width:100% !important">
                                <option></option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="name" value="{{$product->name}}" class="form-control" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" name="model" value="{{$product->model}}" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Produk</label>
                                    <input type="text" name="code" value="{{$product->code}}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Open PO?</label>
                                    <select name="is_open_po" class="form-control">
                                        <option value="1">Open PO</option>
                                        <option selected value="0">Tidak Open PO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Batas Order</label>
                                    <input type="text" name="open_po_order_deadline" class="form-control" placeholder="YYYY-MM-DD" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Informasi Produk</label>
                            <textarea name="description" class="form-control">{{$product->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="price" value="{{$product->price}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>HPP</label>
                            <input type="text" name="hpp" value="{{$product->hpp}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Diskon</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" name="discount" value="{{$product->discount}}" class="form-control" />
                                </div>
                                <div class="col-md-2">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="disc_type" checked value="percent" /> %
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="disc_type" value="rp" /> Rp.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Harga Anggota</label>
                            <input type="text" class="form-control" value="{{$product->price - $product->discount}}" readonly />
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" name="stock" value="{{$product->stock}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Link Foto Produk</label>
                            <input type="text" name="drive_link" value="{{$product->drive_link}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="is_seller_stocks" value="1" /> Set sebagai STOCK SELLER
                            </label>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <a href="/products" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Buat Produk Baru</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop

@section('custom_css')
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">--}}
@stop

@section('custom_js')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>--}}
    <script>
        //Initialize Select2 Elements
        $('#supplier_id').select2({ placeholder: "Pilih Supplier" });
    </script>
@stop
