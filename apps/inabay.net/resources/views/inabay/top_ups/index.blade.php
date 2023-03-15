@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-wallet"></i> Top-Up Saldo</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Daftar Top-Up Saldo
            </h1>
        </div>
        <div class="col-md-6">
            <a href="/top-ups/new" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Top-Up Baru</a>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="text" name="search" placeholder="Pencarian..." />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">

            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Kode</th>
                    <th>Anggota</th>
                    <th>Bank</th>
                    <th>Nama Pemilik Rekening</th>
                    <th>No. Rekening</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
                @foreach($top_ups as $top_up)
                <tr>
                    <td>{{$top_up->date}}</td>
                    <td>{{$top_up->time}}</td>
                    <td>{{$top_up->code}}</td>
                    <td>{{$top_up->user->name}}</td>
                    <td>{{$top_up->bank_name}}</td>
                    <td>{{$top_up->account_name}}</td>
                    <td>{{$top_up->account_no}}</td>
                    <td>@money($top_up->amount)</td>
                    <td>
                        <button id="status_process_{{$top_up->id}}" class="btn btn-xs btn-{{$top_up->status=='Proses'?'warning':'default'}} btn-status" data-id="{{$top_up->id}}" data-status="Proses">
                            <i class="fas fa-spinner"></i> Proses
                        </button>
                        <button id="status_confirm_{{$top_up->id}}" class="btn btn-xs btn-{{$top_up->status=='Masuk'?'success':'default'}} btn-status" data-id="{{$top_up->id}}" data-status="Masuk">
                            <i class="fas fa-check"></i> Masuk
                        </button>
                        <button id="status_cancel_{{$top_up->id}}" class="btn btn-xs btn-{{$top_up->status=='Batal'?'danger':'default'}} btn-status" data-id="{{$top_up->id}}" data-status="Batal">
                            <i class="fas fa-ban"></i> Batal
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
{{--                    {{$couriers->links()}}--}}
                </div>
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
                url: '{{url("/top-ups/status/update")}}',
                data: {top_up_id: id, top_up_status: status},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(status){
                    console.log(status);
                    if(status.old == "Proses") $('#status_process_' + id).attr('class', 'btn btn-xs btn-default');
                    if(status.old == "Masuk") $('#status_confirm_' + id).attr('class', 'btn btn-xs btn-default');
                    if(status.old == "Batal") $('#status_cancel_' + id).attr('class', 'btn btn-xs btn-default');

                    if(status.new == "Proses") $('#status_process_' + id).attr('class', 'btn btn-xs btn-warning');
                    if(status.new == "Masuk") $('#status_confirm_' + id).attr('class', 'btn btn-xs btn-success');
                    if(status.new == "Batal") $('#status_cancel_' + id).attr('class', 'btn btn-xs btn-danger');
                },
                error: function(result){
                    console.log(result);
                }
            });
        });
    </script>
@stop
