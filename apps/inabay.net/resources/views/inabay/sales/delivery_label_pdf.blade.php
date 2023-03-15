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
            margin: -10px;
        }

        .group.font-kecil, .font-kecil {
            font-size: 8px;
            line-height: 10px;
            font-weight: normal;
        }

        .group {
            border-top: 1px solid #000000;
            /*padding: 10px 0;*/
            line-height: 16px;
        }

        .wrap {

        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 13px;
            font-weight: bold;
            text-align: left;
            padding-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top">
            @if($img_src)
                <div>
                    <div>
                        <div style="position: absolute; top:0; left:0;">
                            <img height="25" style="max-width: 100px;" src="{{ $img_src }}" />
                        </div>
                        <div class="title" style="margin-top: 5px; margin-left: 115px; {{$barcode ? "":"padding-bottom:20px;"}}">
                            Tiket: {{$current_date}} {{$sales->trx_no}}
                            <hr />
                        </div>
                    </div>
                    @if($barcode)
                        <div style="clear:both; text-align: center; margin-top: 5px; margin-bottom: 8px;">
                            <img src="{{$barcode}}" alt="barcode" />
                            <div><b>{{$sales->booking_code}}</b></div>
                        </div>
                    @endif
                </div>
            @else
                <div class="title" style="text-align:center;">
                    Tiket: {{$current_date}} {{$sales->trx_no}}
                    @if($barcode)
                        <div style="padding-top: 10px;">
                            <img style="margin:0; padding:0;" src="{{$barcode}}" alt="barcode" />
                            <div><b>{{$sales->booking_code}}</b></div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <div class="group" style="clear:both;{{$img_src ? "margin-top: -8px":""}}">
            <div>Kepada:</div>
            <div><b>{{$sales->receiver_name}}</b></div>
            <div>{{$sales->receiver_phone}}</div>
            <div>{!! $sales->receiver_address !!}</div>
            <div>{{$sales->receiver_city}}</div>
            <div>{{$sales->receiver_zipcode}}</div>
        </div>
        <div class="group">
            <div>Pengirim: <b>{{$sales->dropshiper_name}}</b></div>
            @if($sales->is_cod)
            <div>Taman Alfa Indah F2 no.3, Joglo, Kembangan, Jakarta Barat 11640</div>
            @endif
            <div>Telp.: {{$sales->dropshiper_phone}}</div>
        </div>
        <div class="group">
            <div>Pengiriman Via: <b>{{$sales->courier->name}}</b></div>
            <div>Ongkos Kirim: {{$sales->delivery_cost}}</div>
            <div>Catatan: {{$sales->description}}</div>
            @if($sales->is_cod)
                <div>
                    <b>Bayar Ditempat (COD): Rp. @money($sales->cod_amount)</b>
                </div>
            @endif
        </div>
        <div class="group font-kecil">
            Isi Barang:
            @foreach($sales_details as $sales_detail)
                <div>{{$sales_detail->qty}} - {{$sales_detail->product->name}} ({{$sales_detail->product->model}})</div>
            @endforeach
{{--            <br />--}}
{{--            <br />--}}
{{--            Catatan:<br />--}}
{{--            {{$sales->description}}--}}
        </div>
    </div>
</body>
</html>
