@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-truck"></i> Kurir Pengiriman</h4>
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
                Daftar Kurir
            </h1>
        </div>
        <div class="col-md-6">
            <a href="/couriers/new" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Kurir Baru</a>
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
        <div class="desktop">
        <div class="box-body table-responsive">

            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>Nama Kurir</th>
                    <th>Status</th>
                    <td></td>
                </tr>

                @foreach($couriers as $courier)
                    <tr>
                        <td>{{$courier->name}}</td>
                        <td>
                            @if($courier->status == 1)
                                <small class="label bg-green">Aktif</small>
                            @else
                                <small class="label bg-gray">Tidak Aktif</small>
                            @endif
                        </td>
                        <td>
                            @if($courier->status == 1)
                                <a href="/couriers/deactivate/{{$courier->id}}" class="btn btn-sm btn-default"><i class="fas fa-toggle-off"></i> Nonaktifkan</a>
                            @else
                                <a href="/couriers/activate/{{$courier->id}}" class="btn btn-sm btn-default"><i class="fas fa-toggle-on"></i> Aktifkan</a>
                            @endif
                            <a href="/couriers/edit/{{$courier->id}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a>
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
                    {{$couriers->links()}}
                </div>
            </div>
        </div>
      </div>

      <div class="mobile_device_480px">
        <div class="inaspace">
           <div class="boxmobcont">
                      @foreach($couriers as $courier)
                      <div class="boxmob">
                    <p><b>Nama Kurir:</b>  {{$courier->name}}</p>

                      <p><b>Status :</b>  @if($courier->status == 1)
                            <small class="label bg-green">Aktif</small>
                        @else
                            <small class="label bg-gray">Tidak Aktif</small>
                        @endif</p>
                        <p><b></b>  @if($courier->status == 1)
                              <a href="/couriers/deactivate/{{$courier->id}}" class="btn btn-sm btn-default"><i class="fas fa-toggle-off"></i> Nonaktifkan</a>
                          @else
                              <a href="/couriers/activate/{{$courier->id}}" class="btn btn-sm btn-default"><i class="fas fa-toggle-on"></i> Aktifkan</a>
                          @endif
                          <a href="/couriers/edit/{{$courier->id}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                          <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</a></p>

                  @endforeach
                </div>
                </div>
              </div>
        <!-- /.box-body -->

        <!-- /.box-cust-->
        <div class="box-cust">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    {{$couriers->links()}}
                </div>
            </div>
        </div>
        <!-- /.box-cust-->
    </div>

@stop
