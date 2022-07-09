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
    <title>RCMS | Dashboard &amp; Optimization</title>
    <meta name="theme-color" content="#ffffff">
    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> <!-- CDN -->
    <!-- Themes -->
    <link rel="stylesheet" href="/themes/{{$theme}}/css/import-font.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/css/guideline.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/css/themes.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/css/code.css">
    <link rel="stylesheet" href="/themes/{{$theme}}/css/custom.css">
</head>

<body class="rsolution-scrollbar-xl">
    <main class="main wrapper">
        <main class="main wrapper min-vh-100 d-flex align-items-center justify-content-center bg-light">
            <form class="card rsolution-card-shadow p-3" method="POST" action="{{ route('rcms.login.index') }}" style="width: 400px;">
                <img src="/themes/{{$theme}}/img/logo-responsive.png" width="50" style="margin: 0 auto;background: #262f3d;border-radius: 5px;padding: 2px;">
                @csrf
                <div class="form-group ">
                    <label for="exampleInputEmail1">
                        <h6 class="font-weight-medium">Email</h6>
                    </label>
                    <input id="email" type="email" class="form-control" placeholder="Nhập địa chỉ email" name="email" required autocomplete="email">
                    <!--  -->
                </div>
                <div class="form-group input-icons position-relative">
                    <label for="exampleInputPassword1">
                        <h6 class="font-weight-medium">Password</h6>
                    </label>
                    <i class="fas fa-eye-slash icon-hide"></i>
                    <input id="password" type="password" class="form-control " name="password" placeholder="Nhập mật khẩu" required autocomplete="current-password">
                    <!--  -->
                </div>
                <input type="checkbox" name="remember" checked="" hidden="">
                <button type="submit" class="btn btn-outline-primary w-100 custom-btn-shadow" style="height: 40px;">
                    <h6 class="font-weight-medium mb-0"> Đăng nhập</h6>
                </button>
            </form>
        </main>
    </main>

    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- Themes -->
    <!-- <script src="/themes/{{$theme}}/js/sidebar.js"></script> -->
</body>

</html>