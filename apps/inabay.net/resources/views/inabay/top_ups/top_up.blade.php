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
                    <form action="/top-ups/new" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label">Bank Pengirim</label>
                            <input type="text" name="bank_name" value="{{$user->bank_name}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nama Pengirim</label>
                            <input type="text" name="account_name" value="{{$user->bank_acc_name}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">No. Rekening Pengirim</label>
                            <input type="text" name="account_no" value="{{$user->bank_acc_no}}" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Jumlah</label>
                            <input type="text" id="masked_amount" class="form-control money" />
                            <input type="hidden" id="unmasked_amount" name="amount" />
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Top Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
@stop

@section('custom_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js" integrity="sha256-u7MY6EG5ass8JhTuxBek18r5YG6pllB9zLqE4vZyTn4=" crossorigin="anonymous"></script>
    <script>
        //Money & number mask
        $(".money").mask("000.000.000.000.000", {reverse: true});

        $("#masked_amount").change(function(){
            var amount = $(this).cleanVal();
            $("#unmasked_amount").val(amount);
        });
    </script>
@stop
