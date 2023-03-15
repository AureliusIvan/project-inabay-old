@extends('adminlte::page')

@section('title', 'Supplier | Inabay Dropship')

@section('content_header')
    <h4><i class="fas fa-box-open"></i> Supplier</h4>
@stop

@section('content')

    <div class="row header">
        <div class="col-md-6">
            <h1 class="text-blue">
                Ubah Supplier
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

            <form action ="{{url('/suppliers/edit/' . $supplier->id)}}" method="post">
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nama Supplier</label>
                            <input type="text" name="name" value="{{$supplier->name}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Hp./Telp.</label>
                            <input type="text" name="phone" value="{{$supplier->phone}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{$supplier->email}}" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12 text-right">
                        <a href="/suppliers" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Data Supplier</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@stop
