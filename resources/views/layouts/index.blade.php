@php
$theme = config('app.theme');
$version = '0.1.2';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>
    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.script')
</body>

</html>