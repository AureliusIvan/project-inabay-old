@extends('adminlte::page')

@section('title', 'Pembayaran | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Pembayaran</h4>
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

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Daftar Pembayaran
            </h1>
        </div>
        <div class="col-md-6" style="text-align: right;">
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-6">
                <a href="/payments{{$search ? "/search?q=" . $search_words:""}}" class="btn btn-{{$mode=='all'?'primary':'default'}}"><i class="fas fa-tasks"></i> Semua</a>
                <a href="/payments/unpaid{{$search ? "/search?q=" . $search_words:""}}" class="btn btn-{{$mode=='is_paid_false'?'danger':'default'}}"><i class="fas fa-receipt"></i> Belum Bayar</a>
                <a href="/payments/paid{{$search ? "/search?q=" . $search_words:""}}" class="btn btn-{{$mode=='is_paid_true'?'success':'default'}}"><i class="fas fa-check"></i> Lunas</a>
            </div>
            <div class="col-md-6">
                <form action="/payments/search" method="get">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="q" value="{{$search_words}}" placeholder="Cari berdasarkan Anggota, Toko Online..." />
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
                    <th class="text-right">Total Transaksi</th>
                    <th class="text-right">Ongkos Kirim</th>
                    <th class="text-right">Total</th>
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
                        </td>
                        <td>
                            {{$sales->user_name}}
                            <br />
                            ({{$sales->shop_name}})
                        </td>
                        <td class="text-right">@money($sales->total_sales)</td>
                        <td class="text-right">@money($sales->delivery_cost)</td>
                        <td class="text-right">@money($sales->total_sales+$sales->delivery_cost)</td>
                        <td class="text-center">
                            @if($user->role == 'Finance' || $user->role == 'Admin')
                            <button id="is_paid_false_{{$sales->id}}" class="btn btn-xs btn-{{$sales->is_paid==0?'danger':'default'}} btn-is_paid" data-id="{{$sales->id}}" data-is_paid="0">
                                <i class="fas fa-receipt"></i> Belum Bayar
                            </button>
                            <button id="is_paid_true_{{$sales->id}}" class="btn btn-xs btn-{{$sales->is_paid==1?'success':'default'}} btn-is_paid" data-id="{{$sales->id}}" data-is_paid="1">
                                <i class="fas fa-check"></i> Lunas
                            </button>
                            @else
                                <button class="disabled btn btn-xs btn-{{$sales->is_paid==0?'danger':'default'}} btn-is_paid" data-id="{{$sales->id}}">
                                    <i class="fas fa-receipt"></i> Belum Bayar
                                </button>
                                <button class="disabled btn btn-xs btn-{{$sales->is_paid==1?'success':'default'}} btn-is_paid" data-id="{{$sales->id}}">
                                    <i class="fas fa-check"></i> Lunas
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
        <!-- /.box-body -->
        <div class="box-cust">
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
                    <p><b>Tanggal / Waktu:    {{$sales->date}}
                      /
                      {{$sales->time}} </b></p>

                      <p><b>No Transaksi:</b>
                            {{$sales->trx_no}}

                          </p>

                          @if($sales->use_points)
                                  <p><span class="label label-info"><i class="fas fa-coins"></i> Pakai Poin</span></p>
                              @endif
                        <p><b>Anggota:</b>{{$sales->user_name}}} / ({{$sales->shop_name}})</p>
                        <p><b>Total Transaksi :</b>@money($sales->total_sales) </p>
                        <p><b>Ongkos Kirim :</b>@money($sales->delivery_cost)<p>
                        <p><b>Total: </b>@money($sales->total_sales+$sales->delivery_cost)</p>
                        <p><b>Status :</b>  @if($user->role == 'Finance' || $user->role == 'Admin')
                          <button onClick="history.go(0);" id="is_paid_false_{{$sales->id}}" class="btn btn-xs btn-{{$sales->is_paid==0?'danger':'default'}} btn-is_paid" data-id="{{$sales->id}}" data-is_paid="0">
                              <i class="fas fa-receipt"></i> Belum Bayar
                          </button>
                          <button onClick="history.go(0);" id="is_paid_true_{{$sales->id}}" class="btn btn-xs btn-{{$sales->is_paid==1?'success':'default'}} btn-is_paid" data-id="{{$sales->id}}" data-is_paid="1">
                              <i class="fas fa-check"></i> Lunas
                          </button>
                          @else
                              <button onClick="history.go(0);" class="disabled btn btn-xs btn-{{$sales->is_paid==0?'danger':'default'}} btn-is_paid" data-id="{{$sales->id}}">
                                  <i class="fas fa-receipt"></i> Belum Bayar
                              </button>
                              <button onClick="history.go(0);" class="disabled btn btn-xs btn-{{$sales->is_paid==1?'success':'default'}} btn-is_paid" data-id="{{$sales->id}}">
                                  <i class="fas fa-check"></i> Lunas
                              </button>
                          @endif</small>
                          </p>
                  @endforeach
                </div>
                </div>
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
        <!-- /.box-footer-->
    </div>

@stop

@section('custom_js')
    <script>
        $(".btn-is_paid").click(function(){
            var id = $(this).attr('data-id');
            var is_paid = $(this).attr('data-is_paid');
            var btn_id = $(this).attr('id');
            $.ajax({
                url: '{{url("/payments/status/update")}}',
                data: {sales_id: id, is_paid: is_paid},
                headers: {'X-CSRF-Token': '{{csrf_token()}}'},
                type: 'POST',
                success: function(is_paid){
                    console.log(is_paid);
                    if(is_paid.old == 0) $('#is_paid_false_' + id).attr('class', 'btn btn-xs btn-default');
                    if(is_paid.old == 1) $('#is_paid_true_' + id).attr('class', 'btn btn-xs btn-default');

                    if(is_paid.new == 0) $('#is_paid_false_' + id).attr('class', 'btn btn-xs btn-danger');
                    if(is_paid.new == 1) $('#is_paid_true_' + id).attr('class', 'btn btn-xs btn-success');
                },
                error: function(result){
                    alert(result);
                    console.log(result);
                }
            });
        });
    </script>
@stop
