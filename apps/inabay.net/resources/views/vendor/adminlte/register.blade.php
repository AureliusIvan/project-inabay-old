@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">
{{--                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}--}}
                <img style="height:150px" src="{{ asset('images/logo_inabay.png') }} " />
            </a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Pendaftaran Anggota Baru</p>
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                {!! csrf_field() !!}


                <div class="panel panel-info">
                    <div class="panel-heading text-bold">Informasi Personal</div>
                    <div class="panel-body">
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <input required type="text" name="name" class="form-control" value="{{ old('name') }}"
                                   placeholder="Nama Sesuai KTP">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            @if ($errors->has('name'))
                                <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <input type="text" required name="no_ktp" class="form-control"--}}
{{--                                   placeholder="No. KTP" />--}}
{{--                        </div>--}}
                        <div class="form-group has-feedback">
                            <textarea required class="form-control" name="address" placeholder="Alamat Sesuai KTP"></textarea>
                        </div>
                        <div class="form-group has-feedback">
                            <input required type="text" name="city" class="form-control"
                                   placeholder="Kota" />
                        </div>
                        <div class="form-group">
                            <input required type="text" name="zipcode" maxlength="5" class="form-control"
                                   placeholder="Kode Pos" />
                        </div>
                        <div class="form-group">
                            <input required type="text" name="phone" class="form-control"
                                   placeholder="No. Telpon (WhatsApp)" />
                        </div>
                        <div class="form-group">
                            <input required type="text" name="shop_name" class="form-control"
                                   placeholder="Nama Toko Online" />
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading text-bold">Informasi Bank</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <input required type="text" name="bank_name" class="form-control"
                                   placeholder="Nama Bank" />
                            <span class=""></span>
                        </div>
                        <div class="form-group">
                            <input required type="text" name="bank_acc_name" class="form-control"
                                   placeholder="Nama Pemilik Rekening" />
                            <span class=""></span>
                        </div>
                        <div class="form-group">
                            <input required type="text" name="bank_acc_no" class="form-control"
                                   placeholder="No. Rekening" />
                            <span class=""></span>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading text-bold">Informasi Akun</div>
                    <div class="panel-body">
                        <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                            <input required type="email" name="email" class="form-control" value="{{ old('email') }}"
                                   placeholder="{{ trans('adminlte::adminlte.email') }}">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            @if ($errors->has('email'))
                                <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                            <input required type="password" name="password" class="form-control"
                                   placeholder="{{ trans('adminlte::adminlte.password') }}">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            @if ($errors->has('password'))
                                <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <input required type="password" name="password_confirmation" class="form-control"
                                   placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >Daftar</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class="text-center">Saya sudah menjadi anggota Inabay</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
