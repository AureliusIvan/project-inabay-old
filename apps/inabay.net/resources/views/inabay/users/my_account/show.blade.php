@extends('adminlte::page')

@section('title', 'Akun Saya | Inabay Dropship')

@section('content_header')
    <h1>
        <i class="fas fa-user"></i> Akun Saya
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fas fa-home"></i> Home</a></li>
        <li class="active">Akun Saya</li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="images/user.png" alt="User profile picture">

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center"><i class="fas fa-coins"></i> @money($user->points)</p>

                    <div class="text-center">
                        <p><a href="#" class="btn btn-primary btn-xs"><i class="fas fa-user-cog"></i> Ubah Profil</a></p>
                    </div>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Toko</b> <a class="pull-right">{{$user->shop_name}}</a>
                        </li>
{{--                        <li class="list-group-item">--}}
{{--                            <b>Saldo</b> <a class="pull-right">Coming soon</a>--}}
{{--                        </li>--}}
{{--                        <li class="list-group-item">--}}
{{--                            <b>Poin</b> <a class="pull-right">Coming soon</a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Profil</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Bank</strong>

                    <p class="text-muted">
                        {{$user->bank_name}}<br />
                        {{$user->bank_acc_no}}<br />
                        {{$user->bank_acc_name}}
                    </p>

                    <hr>

                    <strong><i class="fa fa-book margin-r-5"></i> Kontak</strong>

                    <p class="text-muted">
                        <b>Telepon (WhatsApp):</b><br />
                        {{$user->phone}}<br />
                        <b>Email:</b><br />
                        {{$user->email}}
                    </p>

                    <hr>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#transaction" data-toggle="tab">Daftar Transaksi</a></li>
                    <li>
                        <a href="#payment" data-toggle="tab">
                            <span style="font-size: 1.2em;
                                         font-weight: bold;
                                         color: #dd4b39;
                                         border: 1px solid;
                                         display: inline-block; padding: 2px 4px;">Belum Bayar</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="transaction">
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
                        <div class="post">

                            @foreach($sales_s as $sales)
                                <a href="/member/sales/{{$sales->id}}">
                                    <div class="box box-solid bg-gray">
                                        <div class="box-body">
                                            <div>
                                                <b>No. Transaksi: {{$sales->trx_no}}</b>
                                                <small class="label bg-{{$sales->status_color}}">{{$sales->status}}</small>
                                                @if($sales->status != "Batal" && $sales->is_paid)
                                                    <small class="label bg-green">Lunas</small>
                                                @elseif($sales->status != "Batal" && !$sales->is_paid)
                                                    <small class="label bg-yellow">Belum Bayar</small>
                                                @endif
                                                @if($sales->is_po)
                                                    <small class="label label-info"><i class="fas fa-list"></i> Purchase Order</small>
                                                @endif
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
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </a>
                            @endforeach
                            <div class="text-center">
                                {{$sales_s->links()}}
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="payment">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3>Rp. @money($user->total_unpaid)</h3>
                                        <p>Total Belum Dibayar</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <div class="small-box-footer">
                                        Status: Proses / Siap Dikirim / Terkirim
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3>Rp. <span id="checked-total" class="money">0</span></h3>
                                        <p>Total Dalam Checklist</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <div class="small-box-footer">
                                        Status: Proses / Siap Dikirim / Terkirim
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                @foreach($unpaid_sales_s as $sales)

                                    <div class="box box-solid bg-gray">
                                        <div class="box-body">
                                            <div>
                                                <b>No. Transaksi:
                                                    <a href="/member/sales/{{$sales->id}}">
                                                    {{$sales->trx_no}}
                                                    </a>
                                                </b>
                                                <small class="label bg-{{$sales->status_color}}">{{$sales->status}}</small>
                                                @if($sales->status != "Batal" && $sales->is_paid)
                                                    <small class="label bg-green">Lunas</small>
                                                @elseif($sales->status != "Batal" && !$sales->is_paid)
                                                    <small class="label bg-yellow">Belum Bayar</small>
                                                @endif
                                                @if($sales->is_po)
                                                    <small class="label label-info"><i class="fas fa-list"></i> Purchase Order</small>
                                                @endif
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
                                                <label><input type="checkbox" class="check-unpaid" data-grandtotal="{{$sales->grand_total}}"/>
                                                <b>Total Transaksi: Rp. {{$sales->masked_grand_total}}</b>
                                                </label>
                                                @if($sales->use_points)
                                                    <span class="label label-info"><i class="fas fa-coins"></i> Pakai Poin</span>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@stop

@section('custom_js')
    <script src="{{ asset('vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    <script>
        $('.money').mask('000.000.000.000.000', {reverse: true});

        let checked_total = 0;
        $('.check-unpaid').prop('checked', false);
        $('.check-unpaid').change(function(){
            if(this.checked){
                checked_total += $(this).data('grandtotal');
                $('#checked-total').text(checked_total.toLocaleString('de-DE'));
            }else{
                checked_total -= $(this).data('grandtotal');
                $('#checked-total').text(checked_total.toLocaleString('de-DE'));
            }
        });
    </script>
@stop
