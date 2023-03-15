@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Produk</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Stock Opname
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-4">
                <a href="/products" class="btn btn-{{$mode=='all'?'primary':'default'}}"><i class="fas fa-boxes"></i> Semua</a>
                <a href="/products/sale" class="btn btn-{{$mode=='sale'?'primary':'default'}}"><i class="fas fa-tags"></i> Sale</a>
                <a href="/products/stock-opname" class="btn btn-{{$mode=='stock'?'primary':'default'}}"><i class="fas fa-cubes"></i> Stock Opname</a>
            </div>
            <div class="col-md-4">
                <form action="{{url('/products/stock-opname/search')}}" method="get">
                    {{ csrf_field() }}
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="q" placeholder="Pencarian..." />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form action="{{url('/products/stock-opname-page')}}" method="get">
                    {{ csrf_field() }}
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="page" placeholder="Ke halaman ..." />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-arrow-circle-right"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if(isset($search))
                        Hasil Pencarian: {{$search}}
                    @endif
                </div>
            </div>
        </div>
        <div class="box-body">
            @foreach($products as $product)
                <div class="row" style="margin-bottom: 25px">
                    <div class="col-md-4">
                        <div class="photo">
                            <img class="img-responsive" src="/images/products/300/{{$product->photo}}" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4><span class="label bg-black">@money(($products->currentPage()-1) * $products->perPage() + $loop->index + 1)</span> {{$product->name}}</h4>
                        <h4>Model: {{$product->model}}</h4>
                        <div class="row">
                            <div class="col-xs-8">
                                <table class="table no-padding">
                                    <tr>
                                        <td>Proses</td>
                                        <td id="colprocess{{$product->id}}">{{$product->total_product_in_process}}</td>
                                    </tr>
                                    <tr>
                                        <td>Keranjang</td>
                                        <td id="colcart{{$product->id}}">{{$product->total_product_in_carts}}</td>
                                    </tr>
                                    <tr>
                                        <td>Stock Member</td>
                                        <td id="coluserstock{{$product->id}}">Coming Soon</td>
                                    </tr>
                                    <tr>
                                        <td>Stok</td>
                                        <td id="colstock{{$product->id}}">{{$product->stock}}</td>
                                    </tr>
                                    <tr class="text-bold bg-info">
                                        <td>Total</td>
                                        <td id="coltotal{{$product->id}}">
                                            {{$product->total_product_in_process + $product->total_product_in_carts + $product->stock}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xs-4">
                                <button type="button" data-id="{{$product->id}}" class="btn btn-lg btn-block btn-primary btn-plus"><i class="fas fa-plus"></i></button>
                                <br />
                                <input type="text" id="stock{{$product->id}}" value="{{$product->stock}}" class="form-control text-center stock-info-{{$product->id}}" />
                                <br />
                                <button type="button" data-id="{{$product->id}}" class="btn btn-lg btn-block btn-primary btn-min"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


{{--                        <form class="form-horizontal">--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="col-xs-2">--}}
{{--                                    <button type="button" data-id="{{$product->id}}" class="btn btn-primary btn-min"><i class="fas fa-minus"></i></button>--}}
{{--                                </div>--}}
{{--                                <div class="col-xs-4">--}}
{{--                                    <input type="text" id="stock{{$product->id}}" value="{{$product->stock}}" class="form-control text-center stock-info-{{$product->id}}" />--}}
{{--                                </div>--}}
{{--                                <div class="col-xs-2">--}}
{{--                                    <button type="button" data-id="{{$product->id}}" class="btn btn-primary btn-plus"><i class="fas fa-plus"></i></button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
                        <button type="button" class="btn btn-success btn-block btn-update-stock" data-id="{{$product->id}}">Simpan</button>
                        <div class="text-center text-bold">
                            Jumlah Barang di Keranjang (Pesan Barang ke Supplier)
                        </div>
                        <form class="form-horizontal">
                            <label class="col-xs-4">Jumlah</label>
                            <div class="col-xs-8">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button">-</button>
                                    </div>
                                    <input type="number" id="qty{{$product->id}}" class="form-control">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <button class="btn btn-primary btn-block btn-po" data-id="{{$product->id}}">Pesan Barang</button>
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
                    {{$products->links()}}
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop

@section('custom_js')
    <script>
        $(".btn-min").click(function(){
            var id = $(this).attr('data-id');
            var current_stock = $('#stock' + id).val();
            if(current_stock > 0) $('#stock' + id).val(current_stock - 1);
            update_stock(id, current_stock-1);
        });

        $(".btn-plus").click(function(){
            var id = $(this).attr('data-id');
            var current_stock = $('#stock' + id).val();
            current_stock = parseInt(current_stock, 10);
            $('#stock' + id).val(current_stock + 1);
            update_stock(id, current_stock+1);
        });

        function update_stock(product_id, stock) {
            $('#colstock' + product_id).text(stock);
            let total = parseInt($('#colcart' + product_id).text()) + parseInt($('#colprocess' + product_id).text()) + parseInt(stock);
            $('#coltotal' + product_id).text(total);
        }

        $(".btn-update-stock").click(function(){
            var id = $(this).attr('data-id');
            var stock = $('#stock' + id).val();
            $.ajax({
                url: '{{url("/products/stock-opname/update")}}',
                data: {product_id: id, stock: stock},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(result){
                    console.log(result);
                    alert("Stok berhasil diupdate");
                }
            });
        });

        $(".btn-po").click(function(){
            var product_id = $(this).attr('data-id');
            var qty = $("#qty" + product_id).val();
            $.ajax({
                url: '{{url("/admin/cart/add")}}',
                data: {product_id: product_id, qty: qty},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(result){
                    console.log(result);
                    alert("Pesanan berhasil dimasukkan ke keranjang pesanan");
                }
            });
        });
    </script>
@stop
