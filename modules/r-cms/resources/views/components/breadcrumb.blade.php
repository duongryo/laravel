<!--  BreadCrumb-->
<div class="row row-border-bottom row-breadcrumb bg-white mb-3">
    <div class="col-lg-6">
        <nav aria-label="breadcrumb pt-1">
            <ol class="breadcrumb px-0 pb-0 mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('rcms.dashboard.index') }}" class="">Home</a></li>
                <li aria-current="page" class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </nav>
        <h1 class="page-title mb-2">{{ $title }}</h1>
    </div>
</div>
<!--  End BreadCrumb-->
