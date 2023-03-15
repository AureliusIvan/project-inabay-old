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
            margin: 0;
        }

        .group.font-kecil, .font-kecil {
            font-size: 8px;
            line-height: 10px;
            font-weight: normal;
        }

        .group {
            border-top: 1px solid #000000;
            padding: 10px 0;
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
        Laporan Penjualan Anggota - {{$month_str}} {{$year}}
    </div>
    <div class="group">
        <table width="100%">
            <tr>
                <th>Nama Anggota</th>
                <th>Nama Toko</th>
                <th class="text-center">Jumlah Transaksi</th>
                <th class="text-right">Total Penjualan</th>
                <th class="text-right">Total Ongkos Kirim</th>
            </tr>
            @foreach($users as $user)
                @if($user->monthlyNumOfTransaction($month, $year))
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->shop_name}}</td>
                <td class="text-center">{{$user->monthlyNumOfTransaction($month, $year)}}</td>
                <td class="text-right">@money($user->monthlyTotalSales($month, $year))</td>
                <td class="text-right">@money($user->monthlyTotalDeliveryCost($month, $year))</td>
            </tr>
                @endif
            @endforeach
            <tr>
                <th colspan="2">Total</th>
                <th class="text-center">{{$total_transaction}}</th>
                <th class="text-right">@money($total_sales)</th>
                <th class="text-right">@money($total_delivery_cost)</th>
            </tr>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" integrity="sha256-u7MY6EG5ass8JhTuxBek18r5YG6pllB9zLqE4vZyTn4=" crossorigin="anonymous"></script>
<script>
    //Money & number mask
    $(".money").mask("000.000.000.000.000", {reverse: true});
</script>
</body>
</html>
