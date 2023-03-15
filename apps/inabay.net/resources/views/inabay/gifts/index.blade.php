@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-gift"></i> Hadiah</h4>
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
  width: 120px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.mobile_device_380px {
     display: none;
 }
 .mobile_device_480px {
     display: none;
 }

 /* if mobile device max width 380px */
   @media only screen and (max-device-width: 380px) {
       .mobile_device_380px{display: block;}
       .desktop {display: none;}
       .content-wrapper {
         min-height: 100%;
         background-color: #ecf0f5;
         z-index: 800;
       }
   }

   /* if mobile device max width 480px */
   @media only screen and (max-device-width: 480px) {
      .mobile_device_480px{display: block;}
      .desktop {display: none;}
      .content-wrapper {
        min-height: 100%;
        background-color: #ecf0f5;
        z-index: 800;
      }
   }

</style>
    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Daftar Hadiah
            </h1>
        </div>
        <div class="col-md-6">
            <a href="/gifts/new" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Hadiah Baru</a>
        </div>
    </div>
    <div class="box-cust">
        <div class="box-header with-border">
            <div class="col-md-8">
                @if(isset($search))
                    Hasil Pencarian: {{$search}}
                @endif
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
                            <div class="text-over">  <a href="/gifts/{{$product->id}}">
                                  {{$product->original_name}}
                              </a></div>

                          <div class="text-over">{{$product->model}}</div>
                            <div class="product-details">
                                <span class="product-price text-gray"><s>{{$product->code}}</s></span>
                                <span class="product-price-member text-bold text-blue">{{$product->price - $product->discount}}

                                </span>

                                    <span class="product-stock">Stock: <b>{{$product->stock}}</b> / {{$product->total_stock}}

                                </span>

                                <span class="product-stock">
                                  <a href="/products/{{$product->id}}?no={{($products->currentPage()-1) * $products->perPage() + $loop->index + 1}}" class="btn btn-xs btn-primary">
                                    <i class="fas fa-eye"></i>
                                    Lihat
                                </a><a href="/products/edit/{{$product->id}}" class="btn btn-xs btn-warning">
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

        <!-- /.box-body -->
        <div class="box-cust">
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
