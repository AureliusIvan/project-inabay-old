@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Produk</h4>
@stop

@section('content')

<style>
.boxcust {
  position: relative;
  border-radius: 3px;


  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
}

.smalle-boxed {
  margin-left: -20px;
  margin-right: -20px;
  position: relative;
  display: block;
}

.text-over{
  white-space: nowrap;
  width: 150px;
  overflow: hidden;
  text-overflow: ellipsis;
}

</style>

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Daftar Produk
            </h1>
        </div>
        <div class="col-md-6">
            <a href="/products/new" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Produk Baru</a>
        </div>
    </div>
    <div class="boxcust">
        <div class="box-header with-border">
            <div class="col-md-8">
                <a href="/products" class="btn btn-{{$mode=='all'?'primary':'default'}}"><i class="fas fa-boxes"></i> Semua</a>
                <a href="/products/open-po" class="btn btn-default"><i class="fas fa-tasks"></i> Open PO</a>
                <a href="/products/sale" class="btn btn-{{$mode=='sale'?'primary':'default'}}"><i class="fas fa-tags"></i> Sale</a>
                <a href="/products/stock-opname" class="btn btn-{{$mode=='stock'?'primary':'default'}}"><i class="fas fa-cubes"></i> Stock Opname</a>
                <a href="/products/stock-seller" class="btn btn-{{$mode=='stock-seller'?'primary':'default'}}"><i class="fas fa-user-tag"></i> Stock Seller</a>
            </div>
            <div class="col-md-4">
                <form action="{{url('/products/search')}}" method="get">
                    {{ csrf_field() }}
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="q" placeholder="Pencarian..." />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
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
            <div class="col-lg-3 col-xs-6">
                <div class="smalle-boxed">
                    <div class="">
                        @if($product->photo == null)
                            <img class="img-thumbnail no-border" src="/images/300x300.png" />
                        @else
                            <img class="img-thumbnail no-border" src="/images/products/300/{{$product->photo}}" />
                        @endif
                    </div>
                    <div class="inner">
                        <a href="/member/products/{{$product->id}}">

                            <div class="text-over">{{$product->name}}</div>
                            @if($product->is_open_po)
                            <a href="">
                                <span class="label bg-green-gradient">Informasi dan Promosi</span>
                            @endif
                          <div class="text-over">{{$product->model}}</div>
                            <div class="product-details">
                                <span class="product-price text-gray"><s>Rp. {{$product->price}}</s></span>
                                <span class="product-price-member text-bold text-blue">Rp. @money($product->price - $product->discount)
                                    @if($product->is_sale)
                                        <small class="label bg-red"><i class="fas fa-tag"></i> Sale</small>
                                    @endif
                                    @if($product->is_gift)
                                        <small class="label bg-green"><i class="fas fa-gift"></i> Gift</small>
                                    @endif
                                </span>
                                <span class="product-stock">Stock: <b>{{$product->stock}}</b> /  {{$product->total_stock}}
                                    @if($product->restock_at != null && $mode == 'updates')
                                        <small class="label bg-green"><i class="fas fa-boxes"></i> Re-stok</small><br />
                                        Tanggal Restok: {{$product->restock_date}}
                                    @endif
                                    @if($product->restock_at == null && $mode == 'updates')
                                        <small class="label bg-red"><i class="fas fa-box-open"></i> PRODUK BARU
                                            <i class="fas fa-exclamation"></i>
                                            <i class="fas fa-exclamation"></i>
                                            <i class="fas fa-exclamation"></i>
                                        </small>
                                        <br />Tanggal: {{$product->create_date}}
                                    @endif
                                </span>

                                <span class="product-stock">
                                  <a href="/products/{{$product->id}}?no={{($products->currentPage()-1) * $products->perPage() + $loop->index + 1}}" class="btn btn-xs btn-primary">
                                    <i class="fas fa-eye"></i>
                                    Lihat
                                </a>
                                <a href="/products/edit/{{$product->id}}" class="btn btn-xs btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Ubah
                                </a>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>


</div>
        <!-- /.box-body -->
        <div class="boxcust">
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
