@extends('adminlte::page')

@section('title', 'Anggota | Inabay Dropship')

@section('content_header')
    @if(isset($self))
        <h4><i class="fas fa-user-cog"></i> Edit Profil</h4>
    @else
        <h4><i class="fas fa-users"></i> Anggota</h4>
    @endif
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                {{ isset($self) ? "Profil Saya" : "Informasi Anggota" }}
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-8">

            </div>
            <div class="col-md-4 text-right">

            </div>
        </div>
        <div class="box-body">

            <form action="/members/edit/{{$user->id}}" method="post">
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">
                                Informasi Personal
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>No. KTP</label>
                                    <input type="text" name="no_ktp" value="{{$user->no_ktp}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control" required>{{$user->address}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" name="city" value="{{$user->city}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" name="zipcode" value="{{$user->zipcode}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="phone" value="{{$user->phone}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Nama Toko Online</label>
                                    <input type="text" name="shop_name" value="{{$user->shop_name}}" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">
                                Informasi Bank
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <input type="text" name="bank_name" value="{{$user->bank_name}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Nama Pemilik Rekening</label>
                                    <input type="text" name="bank_acc_name" value="{{$user->bank_acc_name}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" name="bank_acc_no" value="{{$user->bank_acc_no}}" class="form-control" required />
                                </div>
                                @can('admin')
                                <div class="form-group">
                                    <label>Saldo</label>
                                    <input type="text" name="balance" value="{{$user->balance}}" class="form-control" required @cannot('superadmin') disabled @endcannot />
                                </div>
                                <div class="form-group">
                                    <label>Poin</label>
                                    <input type="text" name="points" value="{{$user->points}}" class="form-control" required @cannot('superadmin') disabled @endcannot />
                                </div>
                                @endcan
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">
                                Informasi Akun
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{$user->email}}" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" />
                                    <p class="help-block">Isi dengan password yang baru jika ingin mengubah password.</p>
                                </div>
                                @can('admin')
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control" required>
                                        <option>- Status Anggota -</option>
                                        <option value="1" {{$user->is_active==1 ? "selected":""}}>Aktif</option>
                                        <option value="0" {{$user->is_active==1 ? "":"selected"}}>Tidak Aktif</option>
                                    </select>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        @if(isset($self))
                            <input type="hidden" name="self" value="1" />
                        @else
                            <a href="/members" class="btn btn-default"><i class="fas fa-chevron-left"></i> Kembali</a>
                        @endif
                        <button type="submit" class="btn btn-success"><i class="far fa-save"></i> {{ isset($self) ? "Simpan" : "Ubah Anggota" }}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop
