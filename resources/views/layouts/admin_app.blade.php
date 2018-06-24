<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Junior-PHP</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    @auth
        <script type="text/javascript">
            window.remember_token = '{{ Auth::user()->remember_token }}';
            window.user_id = '{{ Auth::user()->id }}';
            window.csrf = '{{ csrf_token() }}';
        </script>
    @endauth

</head>

<body id="root">
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link"><i class="mdi mdi-email-outline"></i>Авторизация</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link"><i class="mdi mdi-calendar"></i>Регистрация</a>
                    </li>
                @else
                    <li class="nav-item">
                        {!! Form::open(['url' => route('logout'), 'method' => 'POST']) !!}
                        <button class="btn btn-link nav-link"><i class="mdi mdi-image-filter"></i>Выход</button>
                        {!! Form::close() !!}
                    </li>
                @endguest
            </ul>
            <ul class="navbar-nav navbar-nav-right">
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item active"><a class="nav-link" href="{{ route('employees_data') }}"><span class="menu-title">Главная</span></a></li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#employees" aria-expanded="false" aria-controls="employees"><span class="menu-title">Сотрудники</span></a>
                    <div class="collapse" id="employees">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link active" href="{{ route('employees.index') }}">Все</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- partial -->
        @yield('content')
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<script src="{{ mix('/js/scripts.js') }}"></script>
@yield('scripts')
</body>

</html>