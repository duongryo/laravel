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
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Themes -->
    <link rel="stylesheet" href="/themes/{{$theme}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/css/themes.css">
    <!-- Lib -->
    <link rel="stylesheet" href="/themes/{{ $theme }}/lib/fontawesome/css/all.min.css">
    <!-- CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap4-tagsinput@4.1.3/tagsinput.min.css">
    @include('rcms::custom.css')
</head>

<body class="bg-light">
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main wrapper">
        <div class="container-fluid p-0">
            <!-- SideBar -->
            @include('rcms::layout.sidebar')
            <!-- End SideBar -->
            <div class="main-content">
                <!-- TopBar -->
                @include('rcms::layout.topbar')
                <!-- End TopBar -->

                <!-- Content -->
                <div class="page-result">
                    @yield('content')
                </div>
                <!-- End content -->
            </div>
        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <script src="/themes/{{$theme}}/js/jquery-3.4.1.min.js"></script>
    <script src="/themes/{{$theme}}/js/popper.min.js"></script>
    <script src="/themes/{{$theme}}/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="/themes/{{$theme}}/js/flatpickr.js"></script>
    <!-- CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/8ge397vch4740f15cfn8pnzp8j3lukt68asgl99jtg2uo4xd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Toast -->
    @component('rcms::components.notification') @endcomponent
    @include('rcms::custom.js')
    @yield('js')
</body>

</html>