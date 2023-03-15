@extends('adminlte::page')

@section('title', 'Penjualan | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Penjualan</h4>
@stop

@section('content')
<style>
table.a {
  table-layout: fixed;
  width: 100%;
  border: 1px;
}

.boxmob {
  position: relative;
  border-top:3px solid #d2d6de;
  background: #FDF8BB;
  width: 100%;
  padding-top: 10px;


}

.boxmobcont {
  position: relative;
  border-top:1px solid #d2d6de;
  background: #FDF8BB;
  width: 100%;
  padding-left: 10px;



}
.content-wrapper {
  min-height: calc(100vh - 101px);
  background-color: white;
  z-index: 800;
}

/* .boxmob {
  position: relative;
  border-radius: 3px;
  background: #ffffff;

  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
} */
.inaspace {
  line-height: 0.5;

}
.bgcoba{
  background-color:#f9f9f9;
  color: #000000;
}

.mobile_device_380px {
     display: none;
 }
 .mobile_device_480px {
     display: none;
 }

 /* if mobile device max width 380px */
   @media only screen and (max-device-width: 380px) {
       .mobile_device_380px{display: block;}
       .desktop {display: none;}
       .content-wrapper {
         min-height: 100%;
         background-color: #ecf0f5;
         z-index: 800;
       }
   }

   /* if mobile device max width 480px */
   @media only screen and (max-device-width: 480px) {
      .mobile_device_480px{display: block;}
      .desktop {display: none;}
      .content-wrapper {
        min-height: 100%;
        background-color: #ecf0f5;
        z-index: 800;
      }
   }
</style>
<body class="bgcoba">
    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Daftar Transaksi Penjualan
            </h1>
        </div>
        <div class="col-md-6" style="text-align: right;">
            @if($user->role == 'Admin')
                <a href="/sales/new" class="btn btn-primary"><i class="fa fa-plus"></i> Buat Penjualan Baru</a>
            @endif
            <button class="btn btn-default" data-toggle="modal" data-target="#modal-print-invoice"><i class="fa fa-print"></i> Cetak Invoice</button>
            <form action="/prints/invoice" method="get" style="float:left;">
                <div class="modal fade" id="modal-print-invoice" style="text-align:left;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><i class="fa fa-print"></i> Cetak Invoice</h4>
                            </div>
                            <div class="modal-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">No. Transaksi</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="start" class="form-control" placeholder="Mulai..." required />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="end" class="form-control" placeholder="...sampai" required />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Invoice</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </form>


            <button class="btn btn-default" data-toggle="modal" data-target="#modal-print-label"><i class="fa fa-print"></i> Cetak Label</button>
            <form action="/prints/deliverylabel" method="get" style="float:left;">
                <div class="modal fade" id="modal-print-label" style="text-align:left;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><i class="fa fa-print"></i> Cetak Label Pengiriman</h4>
                            </div>
                            <div class="modal-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">No. Transaksi</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="start" class="form-control" placeholder="Mulai..." required />
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="end" class="form-control" placeholder="...sampai" required />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Label Pengiriman</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </form>



        </div>
    </div>
    <div class="boxcust">
        <div class="box-header with-border">
            <div class="col-md-6">
                <a href="/sales{{$search ? "/search?q=" . $search_words:""}}" class="btn btn-{{$mode=='active'?'primary':'default'}}"><i class="fas fa-check"></i> Aktif</a>
                <a href="/sales/cancel{{$search ? "/search?q=" . $search_words:""}}" class="btn btn-{{$mode=='cancel'?'primary':'default'}}"><i class="fas fa-times"></i> Batal</a>
                <a href="/sales/all{{$search ? "/search?q=" . $search_words:""}}" class="btn btn-{{$mode=='all'?'primary':'default'}}"><i class="fas fa-tasks"></i> Semua</a>
            </div>
            <div class="col-md-6">
                <form action="/sales/{{$mode}}/search" method="get">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="q" value="{{$search_words}}" placeholder="Cari berdasarkan Anggota, Toko Online atau Kurir..." />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="desktop">
          <div class="box-body table-responsive">

              <table class="table table-hover">
                  <tbody>
                  <tr>
                      <th>Tanggal/<br/>Waktu</th>

                      <th>No. Transaksi</th>
                      <th>Anggota</th>
                      <th>Penerima</th>
                      <th>Kurir</th>
                      <th>No.Resi / Kode Booking</th>
                      <th class="text-right">Total Transaksi</th>
                      <th class="text-right">Ongkos Kirim</th>
                      <th class="text-center" width="260">Status</th>
                  </tr>

                  @foreach($sales_s as $sales)
                      <tr>
                          <td>
                              {{$sales->date}}
                              <br />
                              {{$sales->time}}
                          </td>
                          <td>
                              <a href="/sales/{{$sales->id}}" class="text-bold">
                                  {{$sales->trx_no}}
                              </a><br />
                              @if($sales->use_points)
                                  <span class="label label-info"><i class="fas fa-coins"></i> Pakai Poin</span>
                              @endif
                              @if($sales->is_po)
                                  <span class="label label-info"><i class="fas fa-list"></i> Purchase Order</span>
                              @endif
                          </td>
                          <td>
                              {{$sales->user_name}}
                              <br />
                              ({{$sales->shop_name}})
                          </td>
                          <td>{{$sales->receiver_short}}</td>
                          <td>{{$sales->courier_name}}</td>
                          <td>
                              {{$sales->booking_code}}
                          </td>
                          <td class="text-right">@money($sales->total_sales)</td>
                          <td class="text-right">@money($sales->delivery_cost)</td>
                          <td class="text-center">
                              @if($user->role == 'Admin')
                                  <button id="status_process_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Proses'?'warning':'default'}} btn-status" data-id="{{$sales->id}}" data-status="1">
                                      <i class="fas fa-spinner"></i> Proses
                                  </button>
                                  @if(!$sales->is_po)
                                      <button id="status_ready_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Siap'?'info':'default'}} btn-status" data-id="{{$sales->id}}" data-status="4">
                                          <i class="fas fa-box"></i> Siap
                                      </button>
                                  @else
                                      <button class="disabled btn btn-xs btn-{{$sales->status=='Siap'?'info':'default'}} btn-status">
                                          <i class="fas fa-box"></i> Siap
                                      </button>
                                  @endif
                                  <button id="status_sent_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Terkirim'?'success':'default'}} btn-status" data-id="{{$sales->id}}" data-status="2">
                                      <i class="fas fa-check"></i> Terkirim
                                  </button>
                                  <button id="status_cancel_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Batal'?'danger':'default'}} btn-status" data-id="{{$sales->id}}" data-status="3">
                                      <i class="fas fa-ban"></i> Batal
                                  </button>
                              @else
                                  <button class="disabled btn btn-xs btn-{{$sales->status=='Proses'?'warning':'default'}} btn-status">
                                      <i class="fas fa-spinner"></i> Proses
                                  </button>
                                  <button class="disabled btn btn-xs btn-{{$sales->status=='Siap'?'info':'default'}} btn-status">
                                      <i class="fas fa-box"></i> Siap
                                  </button>
                                  <button class="disabled btn btn-xs btn-{{$sales->status=='Terkirim'?'success':'default'}} btn-status">
                                      <i class="fas fa-check"></i> Terkirim
                                  </button>
                                  <button class="disabled btn btn-xs btn-{{$sales->status=='Batal'?'danger':'default'}} btn-status">
                                      <i class="fas fa-ban"></i> Batal
                                  </button>
                              @endif
                          </td>
                      </tr>
                  @endforeach

                  </tbody>
              </table>

          </div>


           <div class="boxcust">
               <div class="col-md-6">

               </div>
               <div class="col-md-6">
                   <div class="pull-right">
                       {{$sales_s->links()}}
                   </div>
               </div>
           </div>
 </div>
         <div class="mobile_device_480px">
           <div class="inaspace">
              <div class="boxmobcont">
                       @foreach($sales_s as $sales)
                         <div class="boxmob">
                       <p><b>Tanggal / Waktu :</b>  {{$sales->date}}{{$sales->time}}</p>

                         <p><b>No Transaksi :</b>
                                 <a href="/sales/{{$sales->id}}" class="text-bold">
                                     {{$sales->trx_no}}
                                 </a><br />

                             </p>
                             <p>
                             @if($sales->use_points)
                                 <span class="label label-info"><i class="fas fa-coins"></i> Pakai Poin</span>
                             @endif
                             @if($sales->is_po)
                                 <span class="label label-info"><i class="fas fa-list"></i> Purchase Order</span>
                             @endif
                           </p>
                           <p><b>Anggota :</b>    {{$sales->user_name}} / ({{$sales->shop_name}}) </p>
                           <p><b>Penerima :</b>    {{$sales->receiver_short}} </p>
                           <p><b>Kurir :</b>    {{$sales->courier_name}}</p>
                           <p><b>No Resi :</b>    {{$sales->booking_code}}<p>
                           <p><b>Total Transaksi :</b>  @money($sales->total_sales)</p>
                           <p><b>Ongkos Kirim :</b>    @money($sales->delivery_cost)</p>
                           <p><b>Status :</b>
                             @if($user->role == 'Admin')
                                 <button onClick="history.go(0);" id="status_process_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Proses'?'warning':'default'}} btn-status" data-id="{{$sales->id}}" data-status="1">
                                     <i class="fas fa-spinner"></i> Proses

                                 @if(!$sales->is_po)
                                     <button onClick="history.go(0);" id="status_ready_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Siap'?'info':'default'}} btn-status" data-id="{{$sales->id}}" data-status="4">
                                         <i class="fas fa-box"></i> Siap
                                     </button>
                                 @else
                                     <button onClick="history.go(0);" class="disabled btn btn-xs btn-{{$sales->status=='Siap'?'info':'default'}} btn-status">
                                         <i class="fas fa-box"></i> Siap
                                     </button>
                                 @endif
                                 <button onClick="history.go(0);" id="status_sent_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Terkirim'?'success':'default'}} btn-status" data-id="{{$sales->id}}" data-status="2">
                                     <i class="fas fa-check"></i> Terkirim
                                 </button>
                                 <button onClick="history.go(0);" id="status_cancel_{{$sales->id}}" class="btn btn-xs btn-{{$sales->status=='Batal'?'danger':'default'}} btn-status" data-id="{{$sales->id}}" data-status="3">
                                     <i class="fas fa-ban"></i> Batal
                                 </button>
                             @else
                                 <button onClick="history.go(0);" class="disabled btn btn-xs btn-{{$sales->status=='Proses'?'warning':'default'}} btn-status">
                                     <i class="fas fa-spinner"></i> Proses
                                 </button>
                                 <button onClick="history.go(0);" class="disabled btn btn-xs btn-{{$sales->status=='Siap'?'info':'default'}} btn-status">
                                     <i class="fas fa-box"></i> Siap
                                 </button>
                                 <button onClick="history.go(0);" class="disabled btn btn-xs btn-{{$sales->status=='Terkirim'?'success':'default'}} btn-status">
                                     <i class="fas fa-check"></i> Terkirim
                                 </button>
                                 <button onClick="history.go(0);" class="disabled btn btn-xs btn-{{$sales->status=='Batal'?'danger':'default'}} btn-status">
                                     <i class="fas fa-ban"></i> Batal
                                 </button>
                             @endif
                     @endforeach
                   </div>
                   </div>
                 </div>

        <!-- /.box-body -->
        <div class="boxcust">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    {{$sales_s->links()}}
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>
</div>
</body>
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
                    if(status.old == "Proses") $('#status_process_' + id).attr('class', 'btn btn-xs btn-default');
                    if(status.old == "Siap") $('#status_ready_' + id).attr('class', 'btn btn-xs btn-default');
                    if(status.old == "Terkirim") $('#status_sent_' + id).attr('class', 'btn btn-xs btn-default');
                    if(status.old == "Batal") $('#status_cancel_' + id).attr('class', 'btn btn-xs btn-default');

                    if(status.new == "Proses") $('#status_process_' + id).attr('class', 'btn btn-xs btn-warning');
                    if(status.new == "Siap") $('#status_ready_' + id).attr('class', 'btn btn-xs btn-info');
                    if(status.new == "Terkirim") $('#status_sent_' + id).attr('class', 'btn btn-xs btn-success');
                    if(status.new == "Batal") $('#status_cancel_' + id).attr('class', 'btn btn-xs btn-danger');
                },
                error: function(result){
                    alert(result);
                }
            });
        });
    </script>
@stop
