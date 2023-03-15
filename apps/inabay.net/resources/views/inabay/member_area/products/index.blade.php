@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
{{--    <h4><i class="fas fa-box-open"></i> Cari Produk</h4>--}}
@stop

@section('content')

<style>
.boxcust {
  position: relative;
  border-radius: 3px;
  background: #ffffff;

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

.mySlides {display: none;}


/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  /* height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease; */
}
.centered {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 3.5s;
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}



</style>

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

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div class="slideshow-container">

<div class="mySlides fade">

  <div class="centered">
  <img src="/images/slider1.jpeg" style="width:300px">
</div>

</div>

<div class="mySlides fade">

  <div class="centered">
  <img src="/images/slider2.jpeg" style="width:300px">
</div>

</div>


</div>
<br>

<div style="text-align:center">
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

        <div class="box-header with-border">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-6">
                @if($info)

                    <h4>{{ $info }}</h4>

                @endif
                @if($mode == 'home' || $mode == 'search')
                <form action="{{url('/member/products/search')}}" method="get">
                    {{ csrf_field() }}
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="q" placeholder="Cari Barang..." />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                @endif

                <br />
                @if(!isset($search))
                    {{$search}}
                @endif
                    <div class="text-center">
                        <button class="btn btn-sm btn-primary hide-price">
                            <i class="fas fa-eye-slash"></i> Sembunyikan Harga
                        </button>
                        <button class="btn btn-sm btn-default show-price">
                            <i class="fas fa-eye"></i>
                            <span>Tampilkan Harga</span>
                        </button>
                    </div>
            </div>
            <div class="col-md-3">&nbsp;</div>
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
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <!-- /.box-body -->

            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    {{$products->links()}}
                </div>
            </div>

        <!-- /.box-footer-->


@stop

@section('custom_js')
<script>
    $('.show-price').hide();
    $('.hide-price').click(function(){
        $('.product-price').hide();
        $('.product-price-member').hide();
        $('.show-price').show();
        $(this).hide();
    });
    $('.show-price').click(function(){
        $('.product-price').show();
        $('.product-price-member').show();
        $('.hide-price').show();
        $(this).hide();
    });
</script>

<script>
let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 3000); // Change image every 2 seconds
}
</script>
@stop
