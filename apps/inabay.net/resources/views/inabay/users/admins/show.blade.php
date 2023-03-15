@extends('adminlte::page')

@section('title', 'Anggota | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-users"></i> Admin</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Informasi Admin
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
                <a href="/users/edit/{{$user->id}}" class="btn btn-warning"><i class="fas fa-edit"></i> Ubah</a>
            </div>
        </div>
        <div class="box-body">

            <form>

                <div class="box-body">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">
                                Informasi Personal
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>No. KTP</label>
                                    <input type="text" name="no_ktp" value="{{$user->no_ktp}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control" disabled>{{$user->address}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" name="city" value="{{$user->city}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" name="zipcode" value="{{$user->zipcode}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="phone" value="{{$user->phone}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Nama Toko Online</label>
                                    <input type="text" name="shop_name" value="{{$user->shop_name}}" class="form-control" disabled />
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
                                    <input type="text" name="bank_name" value="{{$user->bank_name}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Nama Pemilik Rekening</label>
                                    <input type="text" name="bank_acc_name" value="{{$user->bank_acc_name}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" name="bank_acc_no" value="{{$user->bank_acc_no}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Saldo</label>
                                    <input type="text" name="balance" value="{{$user->balance}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Poin</label>
                                    <input type="text" name="points" value="{{$user->points}}" class="form-control" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">
                                Informasi Akun
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{$user->email}}" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" disabled />
                                </div>
                                <div class="form-group">
                                    <label>Peran</label>
                                    <select name="role_id" class="form-control" disabled>
                                        <option>- Pilih Peran -</option>
                                        <option value="2" {{$user->role_id == 2?"selected":""}}>Admin</option>
                                        <option value="1" {{$user->role_id == 1?"selected":""}}>Super Admin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" value="{{$user->is_active==1?"Aktif":"Tidak Aktif"}}" class="form-control" disabled/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <a href="/members" class="btn btn-default"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop
