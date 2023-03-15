@extends('adminlte::page')

@section('title', 'Akun Saya | Inabay Dropship')

@section('content_header')
    <div class="col-md-6 col-md-offset-3">
        <h3><i class="fas fa-wallet"></i> Top-Up Saldo</h3>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    Transfer ke rekening:
                </div>
                <div class="box-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label class="control-label">Bank Pengirim</label>
                            <input type="text" name="bank_name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Pengirim</label>
                            <input type="text" name="bank_acc_name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">No. Rekening Pengirim</label>
                            <input type="text" name="bank_acc_no" class="form-control" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
@stop
