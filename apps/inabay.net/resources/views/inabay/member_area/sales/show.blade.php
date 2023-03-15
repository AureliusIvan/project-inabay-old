@extends('adminlte::page')

@section('title', 'Pembelian | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Pembelian</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-12">
            <h1 class="text-blue">
                Transaksi Penjualan
            </h1>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-12">
                <h3 class="box-title text-bold">No. Transaksi: {{$sales->trx_no}}</h3>
                @if($sales->use_points)
                    <span class="label label-info"><i class="fas fa-coins"></i> Pakai Poin</span>
                @endif
            </div>
            <div class="col-md-8">
                <h3 class="box-title">Tanggal Transaksi: {{$sales->date}}</h3>
            </div>
            <div class="col-md-4">
                {{--<a href="/sales/edit/{{$sales->id}}" class="btn btn-warning pull-right"><i class="fas fa-edit"></i> Ubah</a>--}}
            </div>
        </div>
        <div class="box-body table-responsive">

            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pengirim</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <td>Nama Pengirim</td>
                                <td>{{$sales->user->shop_name}}</td>
                            </tr>
                            <tr>
                                <td>Telp.</td>
                                <td>{{$sales->user->phone}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penerima</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
{{--                            <tr>--}}
{{--                                <td>Nama Penerima</td>--}}
{{--                                <td>{{$sales->receiver_name}}</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>Telp. Penerima</td>--}}
{{--                                <td>{{$sales->receiver_phone}}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td>Penerima</td>
                                <td>{!! $sales->receiver_address !!}</td>
                            </tr>
                            <tr>
                                <td>Pengiriman Melalui</td>
                                <td>{{$sales->courier->name}}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td>Keterangan</td>--}}
{{--                                <td>{{$sales->description}}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td>
                                    Kode Booking/No. Resi Otomatis
                                    @if($sales->status == "Proses")
                                        <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-booking-code">
                                            <i class="fas fa-edit"></i> Ubah</button>

                                        <form action="{{url('/sales/edit/' . $sales->id)}}" method="post">
                                            {{ csrf_field() }}
                                            <div class="modal modal-warning fade" id="modal-booking-code">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title text-left">Ubah Kode Booking</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input class="form-control text-center" name="booking_code" type="text" value="{{$sales->booking_code}}" placeholder="Ongkos Kirim" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-outline">
                                                                <i class="fas fa-save"></i> Simpan Perubahan</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                        </form>
                                    @endif
                                </td>
                                <td>{{$sales->booking_code}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Pengiriman Kurir</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <td>Status</td>
                                <td><span class="label bg-gray">{{$sales->status}}</span></td>
                            </tr>
                            <tr>
                                <td>No. Resi</td>
                                <td>{{$sales->courier_receipt}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Catatan</h3>
                    </div>
                    <div class="box-body">
                        {{$sales->description}}
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>No.</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Harga Satuan</th>
                            <th class="text-right">Total Harga</th>
                        </tr>
                        @php $i=1 @endphp
                        @foreach($sales_details as $sales_detail)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$sales_detail->product->name}} ({{$sales_detail->product->model}})</td>
                                <td class="text-center">{{$sales_detail->qty}}</td>
                                <td class="text-right">@money($sales_detail->price)</td>
                                <td class="text-right">@money($sales_detail->qty * $sales_detail->price)</td>
                            </tr>
                            @php $i++ @endphp
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right">Ongkos Kirim</td>
                            <td class="text-right">@money($sales->delivery_cost)</td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">
                                @if($sales->use_points)
                                    <span class="label label-info"><i class="fas fa-coins"></i> Pakai Poin</span>
                                @endif
                                Total
                            </th>
                            <td class="text-right">@money($sales->total_sales + $sales->delivery_cost)</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <a href="/sales/print/invoice/{{$sales->id}}" class="btn btn-info"><i class="fas fa-print"></i> Cetak Invoice</a>
                    <a href="/sales/label/{{$sales->id}}" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Label Pengiriman</a>
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop
