@extends('adminlte::page')

@section('title', 'Anggota | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-users"></i> Anggota</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Buat Anggota Baru
            </h1>
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-8">

            </div>
            <div class="col-md-4">

            </div>
        </div>
        <div class="box-body">

            <form action ="{{url('/members/new')}}" method="post">
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">Informasi Personal</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Nama Sesuai KTP</label>
                                    <input type="text" name="name" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>No. KTP</label>
                                    <input type="text" name="no_ktp" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" name="city" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" name="zipcode" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>No. Telpon (WhatsApp)</label>
                                    <input type="text" name="phone" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Nama Toko Online</label>
                                    <input type="text" name="shop_name" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">Informasi Bank</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <input type="text" name="bank_name" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Nama Pemilik Rekening</label>
                                    <input type="text" name="bank_acc_name" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" name="bank_acc_no" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Saldo</label>
                                    <input type="text" name="balance" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Poin</label>
                                    <input type="text" name="points" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading text-bold">Informasi Akun</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="is_active" class="form-control" required>
                                        <option>- Status Anggota -</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <a href="/couriers" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Buat Anggota Baru</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop