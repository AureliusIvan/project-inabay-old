@extends('adminlte::page')

@section('title')
    @if($page == "member")
        Anggota | Inabay Dropship
    @else
        Admin | Inabay Dropship
    @endif
@stop

@section('content_header')
    <h4><i class="fas fa-users"></i>
        @if($page == "member")
            Anggota
        @else
            Admin
        @endif
    </h4>
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
                Daftar
                @if($page == "member")
                    Anggota
                @else
                    Admin
                @endif
            </h1>
        </div>
        <div class="col-md-6">
            @if($page == "member")
                <a href="/members/new" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Anggota Baru</a>
            @else

            @endif
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
                    <th>No. Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Toko Online</th>
                    <th>Kota</th>
                    <th>Telepon</th>
                
                    <th class="text-right">Poin</th>
                    <th class="text-center">Status</th>

                </tr>

                @foreach($users as $user)
                    <tr>
                        <td>{{$user->member_id}}</td>
                        <td>
                            <a href="/members/{{$user->id}}">
                                {{$user->name}}
                            </a>
                        </td>
                        <td>{{$user->shop_name}}</td>
                        <td>{{$user->city}}</td>
                        <td>{{$user->phone}}</td>

                        <td class="text-right">@money($user->points)</td>
                        <td class="text-center"><small class="label {{$user->is_active==1?'bg-green':'bg-red'}}">{{$user->is_active==1?'Aktif':'Tidak Aktif'}}</td>
                          <td><a href="/members/edit/{{$user->member_id}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a></td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
        <div class="box-cust">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    {{$users->links()}}
                </div>
            </div>
        </div>
      </div>
      <div class="mobile_device_480px">
        <div class="inaspace">
           <div class="boxmobcont">
                      @foreach($users as $user)
                      <div class="boxmob">
                    <p><b>No. Anggota :</b>  {{$user->member_id}}</p>

                      <p><b>Nama Anggota :</b>
                            {{$user->name}}
                          </p>
                        <p><b>Toko Online</b>{{$user->shop_name}}</p>
                        <p><b>Kota :</b>{{$user->city}} </p>
                        <p><b>Telepon :</b>{{$user->phone}}<p>

                        <p><b>Poin :</b>    @money($user->points)</p>
                        <p><b>Status :</b><small class="label {{$user->is_active==1?'bg-green':'bg-red'}}">{{$user->is_active==1?'Aktif':'Tidak Aktif'}}</small>
                          </p>
                          <p><b></b><a href="/members/edit/{{$user->member_id}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Ubah</a>
                            </p>
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
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>

@stop
