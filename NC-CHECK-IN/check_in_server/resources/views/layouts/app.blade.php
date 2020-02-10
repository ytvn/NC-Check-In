<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Check-in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="hold-transition sidebar-mini layout-top-nav layout-navbar-fixed">
    <div class="wrapper">
        
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light ">
            <div class="conteainer">
                <a href="/" class="navbar-brand">
                    <span class="brand-text font-weight-light">QR CHECK-IN</span>
                </a>
            </div>
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/statistic" class="nav-link {{ request()->is("statistic") ? 'active bg-primary' : '' }}">Statistic</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/room" class="nav-link {{ request()->is("room") ? 'active bg-primary' : '' }}">Room</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/seat-layout" class="nav-link {{ request()->is("seat-layout") ? 'active bg-primary' : '' }}">Seat layout</a>
                </li>
            </ul>
            
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @guest
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ Auth::user()->name }} <i class="fas fa-user"></i>               
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">{{ Auth::user()->name }}</span>
                        <div class="dropdown-divider"></div>
                        <a href="/auth/change-password" class="dropdown-item">
                            <i class="fas fa-unlock-alt"></i> Đổi mật khẩu
                        </a>
                        <a href="/logout" class="dropdown-item"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </nav>
    <!-- /.navbar -->
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @hasSection('title')
                        <h1 class="m-0 text-dark">@yield('title')</h1>
                        @endif
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>
        
        <div class="content">
            <div class="container-fluid">           
                @if(session("error"))
                    <div class="row justify-content-center pt-5">
                        <div class="col-6">
                            <div class="alert alert-danger" role="alert">
                                <h3 class="text-center">{{ session("error") }}</h3>
                            </div>
                        </div>
                    </div>
                    @endif
        
                    @if(session("message"))
                    <div class="row justify-content-center pt-5">
                        <div class="col-6">
                            <div class="alert alert-info" role="alert">
                                <h3 class="text-center">{{ session("message") }}</h3>
                            </div>
                        </div>
                    </div>
                    @endif
                @yield('content')
            </div>
        </div>
    </div>
    
    
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            ĐẠI HỘI VI - ĐOÀN TRƯỜNG ĐH CÔNG NGHỆ THÔNG TIN
        </div>
        <strong>Copyright &copy; 2019 <a href="https://suctremmt.com">Đoàn khoa Mạng máy tính & Truyền thông</a>.</strong> 
    </footer>
</div>

@hasSection ('script')
    @yield('script')
@endif
</body>
</html>