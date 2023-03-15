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
                Laporan
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">

        </div>
        <div class="box-body">

            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Laporan Penjualan</h3>
                    </div>
                    <div class="box-body">
                        <p>Laporan penjualan member setiap bulan.</p>
                        <a href="/reports/sales" class="btn btn-default">Lihat Laporan</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">

            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop
