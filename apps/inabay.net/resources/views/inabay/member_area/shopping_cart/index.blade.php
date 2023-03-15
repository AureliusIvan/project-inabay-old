@extends('adminlte::page')

@section('title', 'Keranjang Belanja | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h4>
@stop

@section('content')
<style>
.boxed {
  position: relative;
  border-radius: 3px;


  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
}

.info-boxed {
  display: block;
  min-height: 90px;

  width: 100%;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  border-radius: 2px;
  margin-bottom: 15px;
}
</style>
    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Keranjang Belanja {{$is_po ? 'PO': 'Reguler'}}
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="boxed">
        <div class="box-header with-border">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">

            </div>
        </div>
        <div class="box-body">

            <div class="col-md-7">

                @if($shopping_carts_exists == false)
                    Keranjang Belanja Anda Kosong
                @endif

                @foreach($shopping_carts as $shopping_cart)
                <div class="info-boxed" id="cart_{{$shopping_cart->id}}">
                    <img src="/images/products/300/{{$shopping_cart->product->photo}}" class="info-box-icon img-thumbnail no-border no-padding" />

                    <div class="info-box-content">
                        <div class="col-md-8">
                            <div class="text-blue no-margin">
                                <a href="/member/products/{{$shopping_cart->product->id}}">
                                    {{$shopping_cart->product->name}}
                                </a>
                            </div>
                            @if($shopping_cart->product->is_gift)
                                <small class="label bg-green"><i class="fas fa-gift"></i> Gift</small>
                            @endif
                            @if($shopping_cart->product->is_sale)
                                <small class="label bg-red"><i class="fas fa-sale"></i> Sale</small>
                            @endif
                            <div class="product-details">
                                <span class="product-price text-gray"><s>Rp. {{$shopping_cart->product->price}}</s></span>
                                <span class="product-price-member text-bold text-blue">Rp. {{$shopping_cart->product->price - $shopping_cart->product->discount}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center" style="padding-bottom: 10px">
                        <div class="col-xs-12">
                            @if(!$shopping_cart->is_po)
                                <form action="/member/cart/delete/{{$shopping_cart->id}}" method="post" class="inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            @elseif($shopping_cart->is_po)
                                <form action="/member/cart-po/delete/{{$shopping_cart->id}}" method="post" class="inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            @endif
                            <button class="btn btn-primary btn-sm minus inline" id="min_{{$shopping_cart->id}}" style="display: inline-block;">
                                <i class="fas fa-minus"></i>
                                <input type="hidden" class="cart_id" name="cart_id" value="{{$shopping_cart->id}}" />
                            </button>

                            <span class="cart-qty text-bold text-blue inline" id="qty_{{$shopping_cart->id}}" style="display: inline-block; padding: 0 10px; min-width: 30px;">{{$shopping_cart->qty}}</span>

                            @if($shopping_cart->product->is_gift)
                                <button disabled class="btn btn-primary btn-sm" style="display: inline-block;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @else
                                <button class="btn btn-primary btn-sm plus" id="btn-plus-{{$shopping_cart->id}}" style="display: inline-block;">
                                    <i class="fas fa-plus"></i>
                                    <input type="hidden" class="cart_id inline" name="cart_id" value="{{$shopping_cart->id}}" />
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

                    @if(!$is_po)
                        <a href="/home" class="btn btn-primary btn-block"><i class="fas fa-plus-circle"></i> Tambah Produk Lainnya</a>
                    @else
                        <a href="/member/products/open-po" class="btn btn-primary btn-block"><i class="fas fa-plus-circle"></i> Tambah Produk PO</a>
                    @endif
            </div>
            <div class="col-md-5">

                @if($shopping_carts_exists == true)
                <div class="boxed">
                    <div class="box-header">
                        <h4>Ringkasan Belanja</h4>
                    </div>
                    <div class="box-body">
                        <b>Total Harga Rp. <span class="total_price">@money($total_price)</span></b>
                        @if(!$is_po)
                            <form action="{{url('/member/sales/new')}}" method="post">
                                {{ csrf_field() }}
    {{--                            <div class="form-group">--}}
    {{--                                <label>Nama Penerima</label>--}}
    {{--                                <input required type="text" name="receiver_name" class="form-control" />--}}
    {{--                            </div>--}}
    {{--                            <div class="form-group">--}}
    {{--                                <label>No. Telp. Penerima</label>--}}
    {{--                                <input required type="text" name="receiver_phone" class="form-control" />--}}
    {{--                            </div>--}}
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" id="is_dropship" name="is_dropship" value="1" />
                                        Kirim Sebagai Dropship (Bila Pengirim bukan atas nama sendiri)
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Nama Toko</label>
                                    <input type="text" class="form-control" id="shop_name" name="shop_name" value="" />
                                </div>
                                <div class="form-group">
                                    <label>No. Telp.</label>
                                    <input type="text" class="form-control" id="shop_phone" name="shop_phone" value="" />
                                </div>
                                <div class="form-group">
                                    <label>Penerima</label>
                                    <textarea required name="receiver_address" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pengiriman Melalui</label>
                                    <div>
                                        <select class="col-xs-8" name="courier_id" required>
                                            <option  value=""> -- Pilih Pengiriman -- </option>
                                        @foreach($couriers as $courier)

                                                <option  value="{{$courier->id}}" > {{$courier->name}} </option>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="note" value="" />
                                <div class="form-group" style="clear:both;">
                                    <label>Catatan</label>
                                    <textarea name="description" class="form-control" placeholder="Catatan tambahan"></textarea>
                                </div>
                                <div class="form-group" style="clear:both;">
                                    <label>Kode Booking/No. Resi Otomatis</label>
                                    <input type="text" name="booking_code" class="form-control" />
                                    <p class="help-block">Isi angka 0 jika tidak ada kode booking.</p>
                                </div>
                                <div class="form-group">
                                    <label>Biaya Pengiriman</label>
                                    <input required type="text" name="delivery_cost_masked" id="delivery_cost_masked" class="form-control money" />
                                    <input type="hidden" name="delivery_cost" id="delivery_cost" />
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" id="is_cod" name="is_cod" value="1" />
                                        Bayar ditempat (COD)</label>
                                    <input type="text" id="cod_amount_masked" class="form-control money" placeholder="Harga barang & biaya pengiriman dari Marketplace (Rp.)" />
                                    <input type="hidden" name="cod_amount" id="cod_amount" value="" />
                                </div>
                                <div>
                                    <div class="alert bg-gray">
                                        <table class="table no-border no-margin">
                                            <tr>
                                                <td>Total Harga</td>
                                                <td class="text-right total_price">@money($total_price)</td>
                                                <input type="hidden" id="total_price" value="{{$total_price}}" />
                                            </tr>
                                            <tr>
                                                <td>Ongkos Kirim</td>
                                                <td class="text-right delivery_cost">0</td>
                                            </tr>
                                            <tr style="border-top:1px solid">
                                                <td class="text-bold">Total</td>
                                                <td class="text-right grand_total text-bold">@money($total_price)</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <b>Poin Anda: Rp. @money(auth()->user()->points)</b>
                                    <br />
                                    <label>
                                        Beli menggunkan poin?
                                        <input type="checkbox" value="1" id="use_points" name="use_points" {{ ($total_price > auth()->user()->points)? "disabled":"" }} />
                                    </label>
                                    @if($total_price > auth()->user()->points)
                                        <p class="help-block">Poin Anda belum mencukupi untuk transaksi ini.</p>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Kirim</button>
                            </form>
                        @elseif($is_po)
                            <form action="{{url('/member/sales/new-po')}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group" style="clear:both;">
                                    <label>Catatan</label>
                                    <textarea name="description" class="form-control" placeholder="Catatan tambahan"></textarea>
                                </div>

                                <div>
                                    <div class="alert bg-gray">
                                        <table class="table no-border no-margin">
                                            <tr>
                                                <td>Total Harga</td>
                                                <td class="text-right total_price">@money($total_price)</td>
                                                <input type="hidden" id="total_price" value="{{$total_price}}" />
                                            </tr>
                                            <tr style="border-top:1px solid">
                                                <td class="text-bold">Total</td>
                                                <td class="text-right grand_total text-bold">@money($total_price)</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <b>Poin Anda: Rp. @money(auth()->user()->points)</b>
                                    <br />
                                    <label>
                                        Beli menggunkan poin?
                                        <input type="checkbox" value="1" id="use_points" name="use_points" {{ ($total_price > auth()->user()->points)? "disabled":"" }} />
                                    </label>
                                    @if($total_price > auth()->user()->points)
                                        <p class="help-block">Poin Anda belum mencukupi untuk transaksi ini.</p>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Kirim</button>
                            </form>
                        @endif
                    </div>
                </div>
                @endif

            </div>

        </div>
        <!-- /.box-body -->
        <div class="boxed">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop

@section('custom_js')
    <script src="{{ asset('vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    <script>
        $('.money').mask('000.000.000.000.000', {reverse: true});


        $("#shop_name").attr("readonly", true);
        $("#shop_phone").attr("readonly", true);
        $("#cod_amount_masked").attr("disabled", true);
        $("#shop_name").val("{{Auth::user()->shop_name}}");
        $("#shop_phone").val("{{Auth::user()->phone}}");
        $("#is_dropship").change(function(){
            if(this.checked){
                $("#shop_name").attr("readonly", false);
                $("#shop_phone").attr("readonly", false);
                $("#shop_name").val("");
                $("#shop_phone").val("");
            }else{
                $("#shop_name").attr("readonly", true);
                $("#shop_phone").attr("readonly", true);
                $("#shop_name").val("{{Auth::user()->shop_name}}");
                $("#shop_phone").val("{{Auth::user()->phone}}");
            }
        });

        $("#is_cod").change(function(){
            if(this.checked){
                $("#cod_amount_masked").attr("disabled", false);
                $("#cod_amount_masked").attr("required", true);
                $("#cod_amount_masked").val("");
            }else{
                $("#cod_amount_masked").attr("disabled", true);
                $("#cod_amount_masked").attr("required", false);
                $("#cod_amount_masked").val("");
            }
        });

        $("#cod_amount_masked").change(function(){
            $("#cod_amount").val($(this).cleanVal());
        });

        $("#delivery_cost_masked").change(function(){
            $("#delivery_cost").val($(this).cleanVal());
            // alert($(this).val());
            $(".delivery_cost").text($(this).val());

            delivery_cost = parseInt($("#delivery_cost").val());
            total_price = parseInt($("#total_price").val());
            grand_total = delivery_cost + total_price;
            $(".grand_total").text(grand_total.toLocaleString('de-DE'));
            // alert(grand_total);
            if(grand_total > {{ auth()->user()->points }}) {
                $("#use_points").prop("disabled", true);
            }else{
                $("#use_points").prop("disabled", false);
            }
        });

        $(".plus").click(function(){
            var cart_id = $(this).find(".cart_id").val();
            updateProductSum(cart_id, "plus");

        });
        $(".minus").click(function(){
            var cart_id = $(this).find(".cart_id").val();
            updateProductSum(cart_id, "minus");
        });

        function updateProductSum(cart_id, mode) {
            $.ajax({
                url: '{{url("/member/cart/update")}}/' + cart_id,
                data: {mode: mode},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(result){
                    $("#qty_" + cart_id).text(result.qty);
                    console.log(result);
                    if(result.qty == 0){
                        console.log('teest');
                        $("#cart_" + cart_id).remove();
                    }
                    $(".total_price").text(result.total_price_masked);
                    $("#total_price").val(result.total_price);
                    if($("#delivery_cost").val() > 0){
                        delivery_cost = parseInt($("#delivery_cost").val());
                    }else{
                        delivery_cost = 0;
                    }
                    grand_total = delivery_cost + result.total_price;
                    $(".grand_total").text(grand_total.toLocaleString('de-DE'));
                    // alert(grand_total);
                    if(grand_total > {{ auth()->user()->points }}) {
                        $("#use_points").prop("disabled", true);
                    }else{
                        $("#use_points").prop("disabled", false);
                    }
                    if(result.product_stock == 0 && !result.product_is_open_po) {
                        $("#btn-plus-" + cart_id).prop("disabled", true);
                    }else{
                        $("#btn-plus-" + cart_id).prop("disabled", false);
                    }
                },
                error: function(result){
                    console.log(result);
                }
            });
        }
    </script>
@stop
