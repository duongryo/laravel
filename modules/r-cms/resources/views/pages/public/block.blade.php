@php
$theme = config('rcms-core.theme')
@endphp
<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
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
    <style>
        .bg-error {

            background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
            height: 400px;
            background-position: center;
        }

    </style>
</head>

<body class="rsolution-scrollbar-xl">
    <main class="main wrapper">
        <main class="main wrapper min-vh-100 d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-12 bg-error">
                    <h1 class="text-center">Oops!</h1>
                </div>
                <div class="col-12 text-center">
                    <h6>Your account has been permanently locked due to a violation of policy</h6>
                    <h6>If you think this is a mistake, please contact support.</h6>
                </div>
            </div>


        </main>
    </main>
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
