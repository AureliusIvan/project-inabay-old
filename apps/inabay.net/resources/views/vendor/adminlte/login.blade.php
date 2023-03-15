@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    @yield('css')
@stop

@section('body_class', 'login-page')
<style>
.containered {
  height: 50px;
  position: relative;
}

.centered {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}



</style>
@section('body')
<style>
body{
    background: #0c1114	!important;
}
</style>
    <div class="login-box">
        <div class="login-logo text-center">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">
{{--                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}--}}
                <img style="height:150px" src="{{ asset('images/logo_inabay.png') }} " />
            </a>
        </div>
        <!-- /.login-logo -->


{{--            <p class="login-box-msg">--}}
{{--                {{ trans('adminlte::adminlte.login_message') }}--}}
{{--            </p>--}}
            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
{{--                            <label>--}}
{{--                                <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}--}}
{{--                            </label>--}}
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="containered">
                        <div class="centered">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                    </div>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="auth-links">
{{--                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"--}}
{{--                   class="text-center"--}}
{{--                >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>--}}
                <br>
                @if (config('adminlte.register_url', 'register'))
                    <a href="{{ url(config('adminlte.register_url', 'register')) }}"
                       class="text-center">
                      <p style="color: rgb(255,140,0);">  Klik disini untuk daftar menjadi anggota</p>
{{--                        {{ trans('adminlte::adminlte.register_a_new_membership') }}--}}
                    </a>
                @endif

            </div>


<br>
<style>


</style>
            <div class="alert-infoac">
                <h4 style="text-align:center;">Jam Operasional:</h4>
              <p style="text-align:center;">  Senin - Jumat: 09:00 - 16:00 WIB<br />
                Sabtu: Khusus kurir instan dengan perjanjian.<br />
                Minggu & hari libur Tutup.<br />
                CUSTOMER SERVICE : <br />
                08 111 777 615</p>
            </div>

        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@stop
