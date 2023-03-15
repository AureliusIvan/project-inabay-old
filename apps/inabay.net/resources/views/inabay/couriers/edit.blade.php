@extends('adminlte::page')

@section('title', 'Produk | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Kurir Pengiriman</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Ubah Kurir
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

            <form action ="{{url('/couriers/edit/' . $courier->id)}}" method="post">
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nama Kurir</label>
                            <input type="text" name="name" value="{{$courier->name}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <a href="/couriers" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Ubah Kurir</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop