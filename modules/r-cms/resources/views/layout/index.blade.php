@php
$theme = config('rcms-core.theme')
@endphp

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>RSolution | Dashboard &amp; Optimization</title>
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="/themes/{{$theme}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/themes/{{$theme}}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/plugins/summernote/summernote-bs4.min.css">
    @include('rcms::custom.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('rcms::layout.reloader')
        @include('rcms::layout.navbar')
        @include('rcms::layout.sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('rcms::layout.footer')
    </div>
    <script src="/themes/{{$theme}}/plugins/jquery/jquery.min.js"></script>
    <script src="/themes/{{$theme}}/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script src="/themes/{{$theme}}/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="/themes/{{$theme}}/js/popper.min.js"></script>
    <script src="/themes/{{$theme}}/js/flatpickr.js"></script>
    <script src="/themes/{{$theme}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/themes/{{$theme}}/plugins/moment/moment.min.js"></script>
    <script src="/themes/{{$theme}}/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/themes/{{$theme}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/themes/{{$theme}}/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/themes/{{$theme}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/themes/{{$theme}}/dist/js/adminlte.js"></script>
    <script src="/themes/{{$theme}}/dist/js/demo.js"></script>
    <script src="/themes/{{$theme}}/dist/js/pages/dashboard.js"></script>
    @component('rcms::components.notification') @endcomponent
    @include('rcms::custom.js')
    @yield('js')
</body>

</html>