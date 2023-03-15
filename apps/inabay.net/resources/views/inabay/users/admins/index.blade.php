@extends('adminlte::page')

@section('title')
        Admin | Inabay Dropship
@stop

@section('content_header')
    <h4><i class="fas fa-users"></i>Admin</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">Daftar Admin</h1>
        </div>
        <div class="col-md-6">
            @if($page == "admin")
                <a href="/users/new" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Buat Admin Baru</a>
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
        <div class="box-body table-responsive">

            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>Nama Admin</th>
                    <th>Email</th>
                    <th>Hp. (WhatsApp)</th>
                    <th>Super/Admin</th>
                    <th class="text-center">Status</th>
                </tr>

                @foreach($users as $user)
                    <tr>
                        <td>
                            <a href="/users/{{$user->id}}">
                                {{$user->name}}
                            </a>
                        </td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->role}}</td>
                        <td class="text-center"><small class="label {{$user->is_active==1?'bg-green':'bg-red'}}">{{$user->is_active==1?'Aktif':'Tidak Aktif'}}</small></td>
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
                    {{$users->links()}}
                </div>
            </div>
        </div>
        <!-- /.box-footer-->
    </div>

@stop
