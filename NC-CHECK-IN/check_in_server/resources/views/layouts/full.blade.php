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
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class=" layout-top-nav">
    <div class="wrapper">  
        <div class="content-wrapper">
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
    </div>

@hasSection ('script')
    @yield('script')
@endif
</body>
</html>