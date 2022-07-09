@php
$theme = config('rcms-core.theme')
@endphp
<nav class="nav align-items-center menu-top" >
    <div class="d-flex flex-row-reverse bd-highlight w-100 pt-1 pr-50">
        <!-- Profile -->
        <div class="px-2 border-left border-width-custom">
            <div class="dropdown show">
                <span class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-user-circle"></i>
                </span>

                <div class="dropdown-menu dropdown-menu-right profile">
                    <div class="dropdown-menu-content bg-white rounded">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <img src="/themes/{{$theme}}/img/avatar/default.svg" width="65">
                            </div>
                            <div class="col">
                                <h6 class="font-weight-bold">{{ Auth::user()->name }}</h6>
                                <p class="mb-2">Admin</p>
                                <a href="#!">Cài đặt tài khoản</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>