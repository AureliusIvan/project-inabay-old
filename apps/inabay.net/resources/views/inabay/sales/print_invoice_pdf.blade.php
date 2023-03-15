<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        body{
            font-family: Helvetica;
            font-size: 13px;
            line-height: 16px;
            margin: -15px;
        }

        .group.font-kecil, .font-kecil {
            font-size: 8px;
            line-height: 10px;
            font-weight: normal;
        }

        .group {
            border-top: 1px solid #000000;
            /*padding: 10px 0;*/
            line-height: 18px;
        }

        .wrap {

        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        table {
            border-collapse: collapse;
        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            padding-bottom: 4px;
        }

        th, td {
            border-left: none;
            border-right: none;
            border-bottom: 1px solid #cccccc;
            border-top: 1px solid #cccccc;
        }
        table{
            border: none;
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="title">
        Invoice {{$sales->trx_no}}
        <br />
        <span class="font-kecil">Tanggal Transaksi: {{$sales->date}}, Waktu Transaksi: {{$sales->time}}</span>
    </div>
    <div class="group">
        <div>Kepada: <b>{{$sales->user->shop_name}}</b></div>
        <div>Telp.: {{$sales->user->phone}}</div>
    </div>
    <div class="group font-kecil">
        <div>Tujuan Pengiriman:</div>
        <div><b>{{$sales->receiver_name}}</b></div>
        <div>{{$sales->receiver_phone}}</div>
        <div>{!! $sales->receiver_address !!}</div>
        <div>{{$sales->receiver_city}}</div>
        <div>{{$sales->receiver_zipcode}}</div>
    </div>
    <div class="group font-kecil">
        <div>Pengiriman Via: <b>{{$sales->courier->name}}</b></div>
        <div>Keterangan: {{$sales->description}}</div>
        <div>Kode Booking/Resi: <b>{{$sales->booking_code}}</b></div>
        <div>Ongkos Kirim: {{$sales->delivery_cost}}</div>
        <div>Catatan: {{$sales->description}}</div>
    </div>
    <div class="group font-kecil">
        Isi Barang:
        <table border="1">
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Sub-Total</th>
            </tr>

        @php
            $i = 0;
        @endphp
        @foreach($sales_details as $sales_detail)
            @php
                $i++;
            @endphp
            <tr>
                <td>{{$i}}</td>
                <td>{{$sales_detail->product->name}} ({{$sales_detail->product->model}})</td>
                <td class="text-center">{{$sales_detail->qty}}</td>
                <td class="text-right">{{$sales_detail->masked_price}}</td>
                <td class="text-right">{{$sales_detail->masked_subtotal}}</td>
            </tr>
        @endforeach
            <tr>
                <td colspan="4" style="text-align:right">Total</td>
                <td class="text-right">{{$sales->masked_total_sales}}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right">Ongkos Kirim</td>
                <td class="text-right">{{$sales->masked_delivery_cost}}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right" style="padding-top: 8px; font-size: 14px; font-weight: bold">
                    {{$sales->use_points ? '(Pakai POIN)':''}}
                    Grand Total
                </td>
                <td class="text-right" style="padding-top: 8px; font-size: 14px; font-weight: bold">{{$sales->masked_grand_total}}</td>
            </tr>
        </table>
    </div>
{{--    <div class="group font-kecil">--}}
{{--        @foreach($sales_details as $sales_detail)--}}
{{--            <div>{{$sales_detail->product->photo}}--}}
{{--                <img src="{{public_path('images/user.png')}}" />--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--    TODO: Install PHP GD Local--}}
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" integrity="sha256-u7MY6EG5ass8JhTuxBek18r5YG6pllB9zLqE4vZyTn4=" crossorigin="anonymous"></script>
<script>
    //Money & number mask
    $(".money").mask("000.000.000.000.000", {reverse: true});
</script>
</body>
</html>
