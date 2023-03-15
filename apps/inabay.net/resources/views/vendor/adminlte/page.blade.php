@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>

{{--                        <form class="navbar-form navbar-left" role="search">--}}
{{--                            <div class="input-group border-info">--}}
{{--                                <input id="navbar-search-input" class="form-control" type="text" placeholder="Cari Produk..." />--}}
{{--                                <span class="input-group-btn">--}}
{{--                                    <button class="btn btn-flat btn-info" type="submit"><i class="fas fa-search"></i></button>--}}
{{--                                </span>--}}
{{--                            </div>--}}
{{--                        </form>--}}

                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">

                        @if(auth()->user()->role_id == 0 || auth()->user()->role_id == 3)
{{--                            <li>--}}
{{--                                <a href="/member/top-up">--}}
{{--                                    <i class="fas fa-wallet"></i>--}}
{{--                                    <span class="label label-danger">+</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li>
                                <a href="/member/sale"><b>Sale</b></a>
                            </li>
                            <li>
                                <a href="/member/gifts"><i class="fas fa-gift"></i></a>
                            </li>
                            <li>
                                <a href="/member/cart"><i class="fas fa-shopping-cart"></i></a>
                            </li>
{{--                            <li class="dropdown">--}}
{{--                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i> <span class="caret"></span></a>--}}
{{--                                <ul class="dropdown-menu" role="menu">--}}
{{--                                    <li><a href="/member/cart"><i class="fas fa-shopping-cart"></i> Reguler</a></li>--}}
{{--                                    <li><a href="/member/cart-po"><i class="fas fa-shopping-cart"></i> P.O.</a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}

                        @elseif(auth()->user()->role_id == 0 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            <li>
                                <a href="/admin/cart"><i class="fas fa-shopping-cart"></i> Pesan Barang</a>
                            </li>
                        @endif
{{--                        <li>--}}
{{--                            <a href="#"><i class="fas fa-coins"></i> Rp. {{auth()->user()->points}}</a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))--}}
{{--                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">--}}
{{--                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}--}}
{{--                                </a>--}}
{{--                            @else--}}
{{--                                <a href="#"--}}
{{--                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"--}}
{{--                                >--}}
{{--                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}--}}
{{--                                </a>--}}
{{--                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">--}}
{{--                                    @if(config('adminlte.logout_method'))--}}
{{--                                        {{ method_field(config('adminlte.logout_method')) }}--}}
{{--                                    @endif--}}
{{--                                    {{ csrf_field() }}--}}
{{--                                </form>--}}
{{--                            @endif--}}
{{--                        </li>--}}

                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="/images/user.png" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{auth()->user()->name}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="/images/user.png" class="img-circle" alt="User Image">

                                    <p>
                                        {{auth()->user()->name}}
{{--                                        <small>{{auth()->user()->role}}</small>--}}
                                        <small style="font-size: 1em;">
                                            <i class="fas fa-coins"></i>
                                            Rp. @money(auth()->user()->points)
                                        </small>
                                    </p>
                                </li>
                                @if(auth()->user()->role_id == 0 || auth()->user()->role_id == 3)
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row user-account">
                                        <div class="col-xs-12">
{{--                                            <ul class="no-margin no-padding">--}}
{{--                                                <li>--}}
{{--                                                    <a href="#">--}}
{{--                                                        <div class="">Saldo</div>--}}
{{--                                                        <div class="text-bold">Rp. 0</div>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#">--}}
{{--                                                        <div>Poin</div>--}}
{{--                                                        <div class="text-bold">Rp {{auth()->user()->points_masked}}</div>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                    <div>
{{--                                        <a href="/member/sales" class="btn btn-primary btn-sm btn-block text-bold"><i class="fas fa-hand-holding-usd"></i> Transaksi Saya</a>--}}
{{--                                        <a href="/user/stock" class="btn btn-default btn-block text-bold disabled"><i class="fas fa-boxes"></i> Stock Produk Saya (PO)</a>--}}
                                        <a href="/user/seller-stocks" class="btn btn-default btn-block text-bold"><i class="fas fa-boxes"></i> Stock Produk (Gudang Saya)</a>
                                        <a href="/user" class="btn btn-default btn-block text-bold"><i class="fas fa-hand-holding-usd"></i> Akun & Transaksi Saya</a>
                                    </div>
                                </li>
                                @endif
                                <!-- Menu Footer-->
                                <li class="user-footer">
{{--                                    <div class="pull-left">--}}
{{--                                        <a href="/user" class="btn btn-default btn-flat"><i class="fas fa-user-cog"></i> Akun Saya</a>--}}
{{--                                    </div>--}}
                                    <div class="text-center">
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
                                            {{ trans('adminlte::adminlte.log_out') }} <i class="fa fa-fw fa-sign-out-alt"></i></a>
                                        <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                            @if(config('adminlte.logout_method'))
                                                {{ method_field(config('adminlte.logout_method')) }}
                                            @endif
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
