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
            <div class="col-md-6 col-xs-12">
                @if($prev_id == 0)
                    <a class="btn disabled btn-default">Sebelumnya</a>
                @else
                    <a href="/products/{{$prev_id}}?no={{$no-1}}" class="btn btn-default">Sebelumnya</a>
                @endif

                @if($next_id == 0)
                    <a class="btn disabled btn-default">Berikutnya</a>
                @else
                    <a href="/products/{{$next_id}}?no={{$no+1}}" class="btn btn-default">Berikutnya</a>
                @endif
            </div>
            <div class="col-md-6 text-right">
                <a href="/products/copy/{{$product->id}}" class="btn btn-primary"><i class="fa fa-copy"></i> Salin Produk</a>
            </div>
        </div>
        <div class="box-body">

            <section id="product-info">
                <div class="col-md-4">
                    <div class="photo">
                        <img class="img-responsive" src="{{$photo}}" />
                    </div>
                </div>
                <div class="col-md-8">
                    <dl class="dl-horizontal">
                        <dt>Reguler/Open PO?</dt>
                        <dd>
                            @if($product->is_open_po)
                                <span class="label bg-green-gradient">Open PO</span>
                            @else
                                <span class="label label-default">Reguler</span>
                            @endif
                            @if($product->is_seller_stocks)
                                <span class="label bg-orange-active"><i class="fas fa-user-tag"></i> Stock Seller</span>
                            @endif
                        </dd>
                        <dt>Supplier</dt>
                        <dd>{{$product->supplier->name}}</dd>
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
                        <dt>HPP</dt>
                        <dd>{{$product->hpp}}</dd>
                        <dt>Diskon</dt>
                        <dd>{{$product->discount}}</dd>
                        <dt>Harga Anggota</dt>
                        <dd>{{$product->price - $product->discount}}</dd>
                        <dt>Stok</dt>
                        <dd>{{$product->stock}}</dd>
                        <dt>Link Foto Produk</dt>
                        <dd><a href="{{$product->drive_link}}">{{$product->drive_link}}</a></dd>
                    </dl>
                </div>
            </section>

            @if($product->is_seller_stocks)
                <section id="seller-stocks">
                    <table class="table table-striped">
                        <tr>
                            <th>No. Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Toko Online</th>
                            <th>Kota</th>
                            <th>Telepon</th>
                            <th>Stok</th>
                            <th></th>
                        </tr>
                        @foreach($seller_stocks as $seller_stock)
                        <tr>
                            <td>{{$seller_stock->user_id}}</td>
                            <td>{{$seller_stock->name}}</td>
                            <td>{{$seller_stock->shop_name}}</td>
                            <td>{{$seller_stock->city}}</td>
                            <td>{{$seller_stock->phone}}</td>
                            <td>{{$seller_stock->stock}}</td>
                            <td>
                                <button class="btn btn-warning"
                                        data-toggle="modal" data-target="#modal-seller_stock_{{$seller_stock->id}}">
                                    <i class="fas fa-edit"></i> Ubah
                                </button>

                                <form action="{{url('/seller-stocks/update/' . $seller_stock->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal modal-warning fade" id="modal-seller_stock_{{$seller_stock->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title text-left">Ubah Stock Seller</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Nama Anggota: {{$seller_stock->name}}<br />
                                                        Nama Toko: {{$seller_stock->shop_name}}<br />
                                                        Stok Sekarang: {{$seller_stock->stock}}
                                                    </p>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Qty.</span>
                                                        <input class="form-control text-right" name="stock" value="{{$seller_stock->stock}}" required min="0" max="{{$product->stock + $seller_stock->stock}}" type="number"  placeholder="Stock Seller" />
                                                        <input type="hidden" name="user_id" value="{{$seller_stock->id}}" />
                                                        <input type="hidden" name="product_id" value="{{$product->id}}" />
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-outline">
                                                        <i class="fas fa-save"></i> Simpan Perubahan</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="5" class="text-right">Total Stock Seller</th>
                            <th>{{$total_seller_stock}}</th>
                            <th>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-seller">
                                    <i class="fas fa-user-plus"></i> Tambah Member
                                </button>

                                <form action="{{url('/seller-stocks/new')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal modal-default fade" id="modal-add-seller">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title text-left">Tambah Member</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Anggota</label>
                                                        <select class="form-control" name="user_id" required>
                                                            <option value="">-- Pilih Member --</option>
                                                            @foreach($users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}} - {{$user->shop_name}} ({{$user->city}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jumlah Stok</label>
                                                        <input type="number" name="stock" class="form-control" min="1" required max="{{$product->stock}}" />
                                                        <input type="hidden" name="product_id" value="{{$product->id}}" />
                                                    </div>
                                                    <div class="callout callout-info">
                                                        <p>
                                                            Penambahan stock member akan mengurangi stock produk.
                                                            <br />
                                                            Stock Total = Stock Produk + Total Stock Member
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Tambah Member</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </form>
                            </th>
                        </tr>
                    </table>

                </section>
            @endif

        </div>
        <div class="box-footer">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">
                    Hapus
                </button>

                <div class="modal modal-danger fade" id="modal-danger">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-left">Hapus Produk</h4>
                            </div>
                            <div class="modal-body text-left">
                                <p>Yakin mau hapus produk ini?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
                                <form action="/products/delete/{{$product->id}}" method="post" class="inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <a href="/products/edit/{{$product->id}}" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah</a>
            </div>
        </div>
    </div>
@stop
