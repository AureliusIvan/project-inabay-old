@extends('adminlte::page')

@section('title', 'Laporan | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-chart-pie"></i> Laporan</h4>
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
                Laporan Penjualan Anggota ( {{$month}} / {{$year}} )
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-10">
                <form class="form-horizontal" action="/reports/sales" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-1">Periode</label>
                        <div class="col-sm-2">
                            <select name="month" class="form-control">
                                <option {{($month==1)?"selected":""}} value="1">Januari</option>
                                <option {{($month==2)?"selected":""}} value="2">Februari</option>
                                <option {{($month==3)?"selected":""}} value="3">Maret</option>
                                <option {{($month==4)?"selected":""}} value="4">April</option>
                                <option {{($month==5)?"selected":""}} value="5">Mei</option>
                                <option {{($month==6)?"selected":""}} value="6">Juni</option>
                                <option {{($month==7)?"selected":""}} value="7">Juli</option>
                                <option {{($month==8)?"selected":""}} value="8">Agustus</option>
                                <option {{($month==9)?"selected":""}} value="9">September</option>
                                <option {{($month==10)?"selected":""}} value="10">Oktober</option>
                                <option {{($month==11)?"selected":""}} value="11">November</option>
                                <option {{($month==12)?"selected":""}} value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select name="year" class="form-control">
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022" selected>2022</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-default">Lihat Laporan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                <a href="/reports/sales/pdf/{{$year}}/{{$month}}" class="btn btn-primary pull-right">Cetak Laporan</a>
            </div>
          </br>
          </br>
          </br>
            <div class="mobile_device_480px">
              <h4><b>Total: Jumlah Transaksi</b>    {{$total_transaction}}</h4>
              <h4><b>Total Penjualan :</b> @money($total_sales)</h4>
              <h4><b>Total Ongkos Kirim :</b> @money($total_delivery_cost)</h4>

            </div>
        </div>
        <div class="box-body">
          <div class="desktop">

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Nama Toko</th>
                        <th class="text-center">Jumlah Transaksi</th>
                        <th class="text-right">Total Penjualan</th>
                        <th class="text-right">Total Ongkos Kirim</th>
                    </tr>
                    @foreach($users as $user)
                        @if($user->monthlyNumOfTransaction($month, $year) > 0)
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
                        <th colspan="2" class="text-right">Total</th>
                        <th class="text-center">{{$total_transaction}}</th>
                        <th class="text-right">@money($total_sales)</th>
                        <th class="text-right">@money($total_delivery_cost)</th>
                    </tr>
                </table>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-cust">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>

        </div>

        <div class="mobile_device_480px">
          <div class="inaspace">
             <div class="boxmobcont">
                              @foreach($users as $user)
                                @if($user->monthlyNumOfTransaction($month, $year) > 0)
                        <div class="boxmob">
                      <p><b>Nama Anggota :</b>  {{$user->name}}</p>

                        <p><b>Nama Toko :</b> {{$user->shop_name}}</p>
                          <p><b>Jumlah Transaksi: </b>{{$user->monthlyNumOfTransaction($month, $year)}}</p>
                          <p><b>Penjualan :</b> @money($user->monthlyTotalSales($month, $year)) </p>
                          <p><b>Ongkos Kirim :</b>@money($user->monthlyTotalDeliveryCost($month, $year))<p>


                              @endif
                  @endforeach
                  </div>
                  </div>
                </div>

        <div class="box-cust">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>
      </div>
        <!-- /.box-footer-->
    </div>

@stop
