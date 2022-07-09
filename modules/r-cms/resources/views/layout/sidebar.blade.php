@php
$theme = config('rcms-core.theme')
@endphp

<nav class="sidebar app-sidebar">
    <a class="logo text-left">
        <img class="navbar-brand px-25 pt-60 mr-0" src="/themes/{{$theme}}/img/logo.png" />
        <img class="custom-reponsive-logo pt-60 d-none" src="/themes/{{$theme}}/img/logo-responsive.png" alt="" width="50">
    </a>

    <div class="menu menu-sidebar pt-20 rsolution-scrollbar">
        <ul class="nav flex-column">
            <li class="nav-item small-hidden">
                <span class="font-weight-bold title-menu">Overview</span>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rcms.dashboard.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">Dashboard</span>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rcms.crm.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-address-card"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">Transaction Report</span>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rcms.chart-log.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-project-diagram"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">Module report</span>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rcms.manage-user.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">Users</span>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rcms.payment-ticket.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-money-check-alt"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">Payment ticket</span>
                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rcms.user-log.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-history"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">User logs</span>
                    </div>
                </a>
            </li>

            @foreach($public as $item)
            <li class="nav-item">
                <a class="nav-link" href="/rcms/{{ @$item->url }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="{{ @$item->icon }}"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">{{ @$item->name }}</span>
                    </div>
                </a>
            </li>
            @endforeach

            @if(Auth::user()->role == RSolution\RCms\Repositories\UserRepository::ROLE_ADMIN)

            <li class="nav-item small-hidden mt-3">
                <span class="font-weight-bold title-menu">Hệ thống</span>
            </li>

            @foreach($private as $item)
            <li class="nav-item">
                <a class="nav-link" href="/rcms/{{ @$item->url }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="{{ @$item->icon }}"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">{{ @$item->name }}</span>
                    </div>
                </a>
            </li>
            @endforeach

            <!--  -->
            <li class="nav-item">
                <a data-toggle="collapse" data-target="#limit" class="nav-link pointer">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-gem"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">Giới hạn</span>
                    </div>
                </a>
                <ul id="limit" class="sub-menu pl-0 small-hidden mb-1 collapse ">
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.plans.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Quản lý Plan</span>
                        </a>
                    </li>
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.modules.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Quản lý Module</span>
                        </a>
                    </li>
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.limits.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Quản lý Limit</span>
                        </a>
                    </li>

                </ul>
            </li>
            <!--  -->
            <li class="nav-item">
                <a data-toggle="collapse" data-target="#config" class="nav-link pointer">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon">
                            <i class="fas fa-cogs"></i>
                        </span>
                        <span class="nav-link-title custom-resize small-hidden">Cấu hình</span>
                    </div>
                </a>
                <ul id="config" class="sub-menu pl-0 small-hidden mb-1 collapse ">
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.config.sidebar.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Sidebar</span>
                        </a>
                    </li>
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.config.free-trial.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Free Trial</span>
                        </a>
                    </li>
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.config.subscription.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Subscription</span>
                        </a>
                    </li>
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.zoho-plans.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Zoho Plans</span>
                        </a>
                    </li>
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.stripe-plans.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Stripe Plans</span>
                        </a>
                    </li>
                    <li class="sub-nav-item">
                        <a href="{{ route('rcms.config.shareasale.index') }}" class="nav-link pr-0">
                            <span class="nav-link-title custom-resize small-hidden">Shareasale</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
        <div class="text-center mt-20">
            <a class="btn btn-primary px-15" href="/logout" style="min-width:fit-content">
                <span class="fas fa-sign-out-alt"></span>
                <span class="d-xs-inline-block ml-1 small-hidden">Logout</span>
            </a>
        </div>
    </div>
</nav>