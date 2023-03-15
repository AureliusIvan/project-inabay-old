@extends('adminlte::page')

@section('title', 'Pembelian | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Pembelian</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Daftar Transaksi Pembelian
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Rp. @money($user->last_month_total_sales)</h3>
                    <p>Total Transaksi Selesai</p>
                    <h3>Rp. @money($user->last_month_total_sales_in_process)</h3>
                    <p>Total Transaksi Dalam Proses</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <div class="small-box-footer">
                    {{$last_month_str}} {{$last_month_year}}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Rp. @money($user->current_month_total_sales)</h3>
                    <p>Total Transaksi Selesai</p>
                    <h3>Rp. @money($user->current_month_total_sales_in_process)</h3>
                    <p>Total Transaksi Dalam Proses</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <div class="small-box-footer">
                    {{$current_month_str}} {{$current_year}}
                </div>
            </div>
        </div>
    </div>

    @foreach($sales_s as $sales)
        <a href="/member/sales/{{$sales->id}}">
    <div class="box box-solid">
        <div class="box-body">
            <div>
                <b>No. Transaksi: {{$sales->trx_no}}</b>
                <small class="label bg-{{$sales->status_color}}">{{$sales->status}}</small>
            </div>
            <div>
                Tanggal/Waktu: {{$sales->date}} | {{$sales->time}}
            </div>
            <div>
                Dikirim ke: {!! $sales->receiver_address !!}
            </div>
            <div>
                Metode Pengiriman: {{$sales->courier->name}}
            </div>
            <div>
                Total Harga Barang: Rp. {{$sales->masked_total_sales}}
            </div>
            <div>
                Ongkos Kirim: Rp. @money($sales->delivery_cost)
            </div>
            <div>
                <b>Total Transaksi: Rp. {{$sales->masked_grand_total}}</b>
                @if($sales->use_points)
                    <span class="label label-info"><i class="fas fa-coins"></i> Pakai Poin</span>
                @endif
            </div>
            <div>
                <a class="btn btn-primary">Lihat</a>
                <a class="btn btn-success">Bayar</a>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
        </a>
    @endforeach

    {{$sales_s->links()}}


@stop
