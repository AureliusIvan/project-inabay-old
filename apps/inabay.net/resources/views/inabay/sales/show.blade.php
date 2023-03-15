@extends('adminlte::page')

@section('title', 'Penjualan | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Penjualan</h4>
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
                    <small class="label label-info">
                        <i class="fas fa-coins"></i>
                        Pakai Poin
                    </small> &nbsp;
                @endif
            </div>
            <div class="col-md-6">
                <h3 class="box-title">Tanggal Transaksi: {{$sales->date}}</h3>
            </div>
            <div class="col-md-6">
                <h3 class="box-title">Waktu Transaksi: {{$sales->time}}</h3>
{{--                <a href="/sales/edit/{{$sales->id}}" class="btn btn-warning pull-right"><i class="fas fa-edit"></i> Ubah</a>--}}
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
                                <td>Nama Anggota</td>
                                <td>{{$sales->user->name}}</td>
                            </tr>
                            <tr>
                                <td>Kirim Sebagai Dropship</td>
                                <td>{{$sales->is_dropship?"Ya":"Tidak"}}</td>
                            </tr>
                            <tr>
                                <td>Nama Pengirim</td>
                                <td>{{$sales->dropshiper_name}}</td>
                            </tr>
                            <tr>
                                <td>Telepon Pengirim</td>
                                <td>{{$sales->dropshiper_phone}}</td>
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
{{--                            <tr>--}}
{{--                                <td>Kota</td>--}}
{{--                                <td>{{$sales->receiver_city}}</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>Kode Pos</td>--}}
{{--                                <td>{{$sales->receiver_zipcode}}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td>Pengiriman Melalui</td>
                                <td>{{$sales->courier->name}}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td>Keterangan</td>--}}
{{--                                <td>{{$sales->description}}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td>Kode Booking/No. Resi Otomatis</td>
                                <td>{{$sales->booking_code}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @can('admin')
                <div class="box box-solid">
{{--                    <form action="/sales/status/{{$sales->id}}" method="post" class="form-horizontal">--}}
{{--                        {{ csrf_field() }}--}}
                        <div class="box-header with-border">
                            <h3 class="box-title">Informasi Pengiriman Kurir</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-sm-9"><span class="label bg-gray">{{$sales->status}}</span></div>
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label class="col-md-3 control-label">Ubah Status</label>--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <select name="status" class="form-control">--}}
{{--                                        <option value="1">Proses</option>--}}
{{--                                        <option value="2">Terkirim</option>--}}
{{--                                        <option value="3">Batal</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group">
                                <label class="col-md-3 control-label">No. Resi</label>
                                <div class="col-md-9">
                                    <input type="text" name="courier_receipt" value="{{$sales->courier_receipt}}" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="col-md-offset-3 btn btn-success">Simpan No. Resi</button>
                        </div>
{{--                    </form>--}}
                </div>
                @endcan
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Catatan</h3>
                        </div>
                        <div class="box-body">
                            {{$sales->description}}
                        </div>
                    </div>
            </div>


            <div class="col-md-12 hidden-xs">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Harga Satuan</th>
                            <th class="text-right">Total Harga</th>
                        </tr>
                        @php $i=1 @endphp
                        @foreach($sales_details as $sales_detail)
                        <tr>
                            <td>{{$i}}</td>
                            <td><img src="/images/products/100/{{$sales_detail->product->photo}}" /></td>
                            <td>{{$sales_detail->product->name}} ({{$sales_detail->product->model}})</td>
                            <td class="text-center">{{$sales_detail->qty}}</td>
                            <td class="text-right">@money($sales_detail->price)</td>
                            <td class="text-right">@money($sales_detail->qty * $sales_detail->price)</td>
                        </tr>
                            @php $i++ @endphp
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-right">Ongkos Kirim
                                <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-delivery-cost">
                                    <i class="fas fa-edit"></i> Ubah</button>
                            </td>
                            <td class="text-right">@money($sales->delivery_cost)</td>
                        </tr>
                        <tr>
                            <th colspan="5" class="text-right">
                                @if($sales->use_points)
                                    <small class="label label-info">
                                        <i class="fas fa-coins"></i>
                                        Pakai Poin
                                    </small> &nbsp;
                                @endif
                                Total
                            </th>
                            <th class="text-right">@money($sales->total_sales + $sales->delivery_cost)</th>
                        </tr>
                    </table>
                </div>
            </div>

            <form action="{{url('/sales/edit/' . $sales->id)}}" method="post">
                {{ csrf_field() }}
                <div class="modal modal-warning fade" id="modal-delivery-cost">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-left">Ubah Ongkos Kirim</h4>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp.</span>
                                    <input class="form-control text-right" name="delivery_cost" type="text" value="{{$sales->delivery_cost}}" placeholder="Ongkos Kirim" />
                                </div>

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

            <div class="col-md-12 visible-xs">
                <h4>Produk</h4>
                @foreach($sales_details as $sales_detail)
                <div class="box box-solid">
                    <div class="box-body">
                        <img class="img-responsive" src="/images/products/300/{{$sales_detail->product->photo}}" />
                        <div>{{$sales_detail->product->name}} ({{$sales_detail->product->model}})</div>
                        <div>Harga Satuan: Rp. @money($sales_detail->price)</div>
                        <div class="text-bold">Qty: {{$sales_detail->qty}}</div>
                        <div>Sub-Total: Rp. @money($sales_detail->qty * $sales_detail->price)</div>
                    </div>
                </div>
                @endforeach
                <div class="box box-solid">
                    <div class="box-body">
                        <table class="table table-responsive">
                            <tr>
                                <th class="text-right">Ongkir
                                    <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#modal-delivery-cost">
                                        <i class="fas fa-edit"></i> Ubah</button>
                                </th>
                                <th class="text-right">@money($sales->delivery_cost)</th>
                            </tr>
                            <tr>
                                <th class="text-right">
                                    @if($sales->use_points)
                                        <small class="label label-info">
                                            <i class="fas fa-coins"></i>
                                            Pakai Poin
                                        </small> &nbsp;
                                    @endif
                                    Total
                                </th>
                                <th class="text-right">@money($sales->total_sales + $sales->delivery_cost)</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-6">
                @can('admin')
                    <button id="status_process_{{$sales->id}}" class="btn btn-{{$sales->status=='Proses'?'warning':'default'}} btn-status" data-id="{{$sales->id}}" data-status="1">
                        <i class="fas fa-spinner"></i> Proses
                    </button>
                    <button id="status_ready_{{$sales->id}}" class="btn btn-{{$sales->status=='Siap'?'info':'default'}} btn-status" data-id="{{$sales->id}}" data-status="4">
                        <i class="fas fa-box"></i> Siap
                    </button>
                    <button id="status_sent_{{$sales->id}}" class="btn btn-{{$sales->status=='Terkirim'?'success':'default'}} btn-status" data-id="{{$sales->id}}" data-status="2">
                        <i class="fas fa-check"></i> Terkirim
                    </button>
                    <button id="status_cancel_{{$sales->id}}" class="btn btn-{{$sales->status=='Batal'?'danger':'default'}} btn-status" data-id="{{$sales->id}}" data-status="3">
                        <i class="fas fa-ban"></i> Batal
                    </button>
                @endcan
                <p></p>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <a href="/sales/print/invoice/{{$sales->id}}" class="btn btn-info"><i class="fas fa-print"></i> Cetak Invoice</a>
                    @can('admin')
                    <a href="/sales/label/{{$sales->id}}" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Label Pengiriman</a>
                    @endcan
                </div>
                <p></p>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop

@section('custom_js')
    <script>
        $(".btn-status").click(function(){
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            var btn_id = $(this).attr('id');
            $.ajax({
                url: '{{url("/sales/status/update")}}',
                data: {sales_id: id, sales_status: status},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(status){
                    console.log(status);
                    if(status.old == "Proses") $('#status_process_' + id).attr('class', 'btn btn-default');
                    if(status.old == "Siap") $('#status_ready_' + id).attr('class', 'btn btn-default');
                    if(status.old == "Terkirim") $('#status_sent_' + id).attr('class', 'btn btn-default');
                    if(status.old == "Batal") $('#status_cancel_' + id).attr('class', 'btn btn-default');

                    if(status.new == "Proses") $('#status_process_' + id).attr('class', 'btn btn-warning');
                    if(status.new == "Siap") $('#status_ready_' + id).attr('class', 'btn btn-info');
                    if(status.new == "Terkirim") $('#status_sent_' + id).attr('class', 'btn btn-success');
                    if(status.new == "Batal") $('#status_cancel_' + id).attr('class', 'btn btn-danger');
                },
                error: function(result){
                    alert(result);
                }
            });
        });
    </script>
@stop
