@extends('adminlte::page')

@section('title', 'Transaksi | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Transaksi</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Buat Transaksi Baru
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-8">
                TANGGAL HARI INI
            </div>
            <div class="col-md-4">

            </div>
        </div>
        <div class="box-body">

            <form action ="{{url('/sales/new')}}" method="post" >
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    Penerima
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12 form-horizontal">
{{--                                            <div class="form-group">--}}
{{--                                                <label class="col-sm-4">Nama Penerima</label>--}}
{{--                                                <div class="col-sm-8">--}}
{{--                                                    <input type="text" name="receiver_name" class="form-control" />--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label class="col-sm-4">No. Telp. Penerima</label>--}}
{{--                                                <div class="col-sm-8">--}}
{{--                                                    <input type="text" name="receiver_phone" class="form-control" />--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="form-group">
                                                <label class="col-sm-4">Penerima</label>
                                                <div class="col-sm-8">
                                                    <textarea name="receiver_address" class="form-control"></textarea>
                                                </div>
                                            </div>
{{--                                            <div class="form-group">--}}
{{--                                                <label class="col-sm-4">Kota</label>--}}
{{--                                                <div class="col-sm-8">--}}
{{--                                                    <input type="text" name="receiver_city" class="form-control" required />--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label class="col-sm-4">Kode Pos</label>--}}
{{--                                                <div class="col-sm-8">--}}
{{--                                                    <input type="text" name="receiver_zipcode" class="form-control" required />--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="form-group">
                                                <label class="col-sm-4">Pengiriman Melalui</label>
                                                <div class="col-sm-8">
                                                    <select name="courier_id" class="form-control" required>
                                                        <option>-- Pilih Courier --</option>
                                                        @foreach($couriers as $courier)
                                                            <option value="{{$courier->id}}">{{$courier->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Kode Booking/No. Resi Otomatis</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="booking_code" class="form-control" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Biaya Pengiriman</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="delivery_cost" id="delivery_cost" class="form-control" required />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">
                                                    <input type="checkbox" name="is_cod" value="1" />
                                                    Bayar Ditempat (COD)</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="cod_amount" class="form-control" />
                                                </div>
                                            </div>
                                        </div><!-- /.col-md-12 -->
                                    </div><!-- /.row -->
                                </div><!-- /.box-body -->
                            </div><!-- /.box box-primary -->

                        </div><!-- /.col-md-6 -->
                        <div class="col-md-6">

                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    Pengirim
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12 form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4">Anggota</label>
                                                <div class="col-sm-8">
                                                    <select name="user_id" id="member" class="form-control select2" required>
                                                        <option></option>
                                                        @foreach($members as $member)
                                                            <option value="{{$member->id}}">{{$member->name}} ({{$member->shop_name}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Kirim Sebagai Dropship</label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" id="is_dropship" name="is_dropship" value="1" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Nama Toko</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="shop_name" name="shop_name" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">No. Telp.</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="shop_phone" name="shop_phone" value="" />
                                                </div>
                                            </div>
                                        </div><!-- /.col-md-12 -->
                                    </div>
                                </div>
                            </div>

                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    Status Transaksi
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12 form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-4">Status</label>
                                                <div class="col-sm-8">
                                                    <span class="label bg-gray">Pending</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">Ubah Status</label>
                                                <div class="col-sm-8">
                                                    <select name="status" class="form-control" disabled>
                                                        <option>Pending</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4">No. Resi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="receipt_no" class="form-control" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.col-md-6 -->
                    </div><!-- /.row -->
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="50%" colspan="2">Produk</th>
                                    <th width="10%" class="text-center">Jumlah</th>
                                    <th width="15%" class="text-right">Harga Satuan</th>
                                    <th width="20%" class="text-right">Sub-Total</th>
                                    <th width="5%">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody id="product_list">

                                </tbody>
                            </table>
                            <table class="table">
                                <tr>
                                    <td width="50%">
                                        <select id="product_id" class="form-control select2" style="width:100% !important">
                                            <option></option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}} ({{$product->model}})</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="thumb" />
                                    </td>
                                    <td width="10%">
                                        <input type="text" id="qty" class="form-control text-center" />
                                    </td>
                                    <td width="15%">
                                        <input type="text" id="price" class="form-control text-right money" />
                                    </td>
                                    <td width="20%">
                                        <input type="text" id="subtotal" class="form-control text-right" readonly />
                                    </td>
                                    <td width="5%"><button type="button" class="btn btn-primary btn-sm" id="btn_add_product"><i class="fas fa-plus"></i></button></td>
                                </tr>
                            </table>
                        </div><!-- ./col-md-12 -->
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-md-8">

                        </div><!-- /.col-md-8 -->
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    Ringkasan Transaksi
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Total Pembelian</label>
                                        <input type="text" id="total_price" value="" class="form-control" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Biaya Pengiriman</label>
                                        <input type="text" id="delivery_cost_info" value="" class="form-control" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Total Transaksi</label>
                                        <input type="text" id="grand_total" value="" class="form-control" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan</label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>
                                    <div class="callout callout-info">
                                        <p>Member: <span id="info_member_name"></span> - <span id="info_member_shop"></span><br />
                                        Saldo: Rp. <span id="info_member_balance"></span><br />
                                        Poin: Rp. <span id="info_member_points"></span></p>
                                    </div>
                                    <label>Beli menggunakan poin?
                                        <input type="checkbox" name="use_points" value="1" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->


                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <a href="/sales" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Buat Transaksi Baru</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <a class="btn btn-sm btn-danger remove_product1"><i class="fas fa-times"></i></a>
    <a class="btn btn-sm btn-danger remove_product1"><i class="fas fa-times"></i></a>

@stop

@section('custom_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" integrity="sha256-u7MY6EG5ass8JhTuxBek18r5YG6pllB9zLqE4vZyTn4=" crossorigin="anonymous"></script>
    <script>

        $("#shop_name").attr("readonly", true);
        $("#shop_phone").attr("readonly", true);
        $("#is_dropship").change(function(){
            if(this.checked){
                $("#shop_name").attr("readonly", false);
                $("#shop_phone").attr("readonly", false);
                $("#shop_name").val("");
                $("#shop_phone").val("");
            }else{
                $("#shop_name").attr("readonly", true);
                $("#shop_phone").attr("readonly", true);
                //TODO: GET SHOP NAME AND PHONE
            }
        });

        //Initialize Select2 Elements
        $('#member').select2({ placeholder: "Pilih Anggota" });
        $('#product_id').select2({ placeholder: "Pilih Produk" });

        //Money & number mask
        $(".money").mask("000.000.000.000.000", {reverse: true});

        $("select#member").on("change", function(){
            var user_id = $(this).val();
            $.ajax({
                url: '{{url("/users/get_user_info")}}',
                data: {user_id: user_id},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(result){
                    console.log(result);
                    user_name = result.name;
                    user_shop = result.shop_name;
                    user_balance = result.balance;
                    user_points = result.points;
                    user_phone = result.phone;
                    $("#info_member_name").text(user_name);
                    $("#shop_name").val(user_shop);
                    $("#shop_phone").val(user_phone);
                    $("#info_member_balance").text(user_balance);
                    $("#info_member_points").text(user_points);
                },
                error: function(result){
                    alert('hehe');
                }
            });
        });
        var stock = 0;
        $("select#product_id").on("change", function(){
            var product_id = $(this).val();
            console.log(product_id);

            $.ajax({
                url: '{{url("/products/get_product_price")}}',
                data: {product_id: product_id},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(result){
                    price = $(".money").masked(result['price']);
                    thumb = "/images/products/100/" + result['thumb'];
                    stock = parseInt(result['stock']);
                    $("#price").val(price);
                    $("#thumb").val(thumb);
                    console.log(price);
                    console.log("success");
                    $("#qty").val(1);
                    $("#subtotal").val(price);
                    console.log("stock: " + stock);
                },
                error: function(result){}
            });
        });

        $("#delivery_cost").change(function(){
            var delivery_cost = $(this).val();
            var masked_delivery_cost = $(".money").masked(delivery_cost);
            $("#delivery_cost_info").val(masked_delivery_cost);
            get_set_grand_total();
        });

        function get_set_grand_total(){
            var delivery_cost = parseInt($("#delivery_cost").val());
            var total_price = parseInt(get_total_price());
            var grand_total = delivery_cost + total_price;
            var masked_grand_total = $(".money").masked(grand_total);
            $("#grand_total").val(masked_grand_total);
        }

        $("#qty").change(function(){
            var qty = parseInt($(this).val());
            if(qty > stock){
                alert("Stok produk tinggal " + stock);
                $(this).val(stock);
                qty = stock;
            }
            var price = $("#price").cleanVal();
            var masked_subtotal = $(".money").masked(qty * price);
            $("#subtotal").val(masked_subtotal);
        });

        $("#price").change(function(){
            var price = $(this).cleanVal();
            var qty = $("#qty").val();
            var masked_subtotal = $(".money").masked(qty * price);
            $("#subtotal").val(masked_subtotal);
        });

        $(document).on("click", ".remove_product", function(){
            $(this).closest("tr").remove();
            get_set_total_price();
        });

        var i = 0;
        // var total_price = 0;
        $("#btn_add_product").click(function(){
            var product_id = $("#product_id").val();
            var product_name = $("select#product_id").find("option:selected").text();
            var qty = $("#qty").val();
            var masked_price = $("#price").val();
            var masked_subtotal = $("#subtotal").val();
            var price = $("#price").cleanVal();
            var thumb = $("#thumb").val();

            if(product_id > 0 && qty > 0){
                i++;
                trid = "tr" + i;
                aid = "a" + i;
                str = '<tr id="' + trid + '">' +
                      '<td><img src="' + thumb + '" /></td>' +
                      '<td>' + product_name + '<input type="hidden" name="products[]" value="' + product_id + '" /></td>' +
                      '<td class="text-center">' + qty + '<input type="hidden" name="qty[]" value="' + qty + '" /></td>' +
                      '<td class="text-right">' + masked_price + '<input type="hidden" name="price[]" value="' + price + '" /></td>' +
                      '<td class="text-right">' + masked_subtotal + '</td>' +
                      '<td><a id="' + aid + '" class="btn btn-sm btn-danger remove_product"><i class="fas fa-times"></i></a></td>' +
                      '</tr>';
                $("#product_list").append(str);

                // total_price += qty * price;
                // masked_total_price = $(".money").masked(total_price);
                // $("#total_price").val(masked_total_price);

                get_set_total_price();

                // RESET FORM
                $("#product_id").val('').trigger('change');
                $('#qty').val('');
                $('#price').val('');
                $('#subtotal').val('');
            }
        });

        function get_total_price(){
            var qtys = document.getElementsByName("qty[]");
            var prices = document.getElementsByName("price[]");
            var total_price = 0;
            for(var i=0; i<prices.length; i++){
                var price =prices[i];
                var qty = qtys[i];
                total_price += parseInt(price.value * qty.value);
            }
            return total_price;
        }

        function get_set_total_price(){
            var qtys = document.getElementsByName("qty[]");
            var prices = document.getElementsByName("price[]");
            var total_price = 0;
            for(var i=0; i<prices.length; i++){
                var price =prices[i];
                var qty = qtys[i];
                total_price += parseInt(price.value * qty.value);
            }

            masked_total_price = $(".money").masked(total_price);
            $("#total_price").val(masked_total_price);
            get_set_grand_total();
        }
    </script>
@stop
