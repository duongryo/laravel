@extends('rcms::layout.index')
@section('content')
@component('rcms::components.breadcrumb')
@slot('title') Dashboard @endslot
@endcomponent
<!-- Content -->
<div class="row d-flex justify-content-center">
    <div class=" col-12">
        <h4 class="font-weight-bold text-primary">Overview</h4>
        <div class="row" style="margin-top: -20px;">
            <div class="col-xxl-2 col-3">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header">
                        <div class="title">
                            Total
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <h6 class="mt-5">
                            <a href="{{ route('rcms.manage-user.index') }}" target="_blank"> {{ number_format(@$data->user->sum('total')) }} users</a>
                        </h6>
                    </div>
                </div>
            </div>
            @foreach($data->user as $item)
            <div class="col-xxl-2 col-3">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header">
                        <div class="title">
                            {{ $item->planInfo->name }}
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <h6 class="mt-5">
                            <a href="{{ route('rcms.manage-user.index') }}?plan={{ $item->planInfo->id }}" target="_blank"> {{ number_format(@$item->total) }} users</a>
                        </h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <h4 class="font-weight-bold text-primary mt-30">Report</h4>
        <!-- Filter -->
        <div class="row" style="margin-top: -20px;">
            <div class="col-12">
                <form class="rsolution-card-shadow" method="get">
                    <div class="rsolution-card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">From</span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="startDate" value="{{ !empty($_GET['startDate']) ? $_GET['startDate'] : now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">To</span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="endDate" value="{{ !empty($_GET['endDate']) ? $_GET['endDate'] : now()->format('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 text-right">
                                <button class="btn btn-primary btn-icon">
                                    <span class="fas fa-search"></span>
                                </button>
                                <a class="btn  btn-icon" href="{{ route('rcms.crm.index') }}">
                                    <span class="fas fa-redo "></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header">
                        <div class="title">
                            New users
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <h6 class="mt-5 text-primary">
                            {{ number_format(@$data->newUsers->count()) }} users
                        </h6>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header">
                        <div class="title">
                            Refund rate
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <h6 class="mt-5 text-primary">
                            {{ $data->userUpgradeDeal ? number_format($data->refund->sum('total') / $data->userUpgradeDeal * 100,2) : 0}} %
                        </h6>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header">
                        <div class="title">
                            Conversion Rate
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <h6 class="mt-5 text-primary">
                            {{ $data->newUsers->count() ? number_format($data->userUpgradeDeal / $data->newUsers->count() * 100, 2) : 0 }} %
                        </h6>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-4">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header border-bottom">
                        <div class="title">
                            <div class="row">
                                <div class="col">
                                    Transactions
                                </div>
                                <div class="col-auto text-primary">
                                    {{ number_format($data->transaction->sum('total') ) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        @foreach($data->transaction as $item)
                        <div class="row ">
                            <div class="col font-weight-semi-bold">
                                {{ $item->method ? $item->method : 'another'}}
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('rcms.crm.index') }}?method={{ $item->method }}&startDate={{ @$_GET['startDate']}}&endDate={{ @$_GET['endDate'] }}" target="_blank"> {{ number_format(@$item->total) }} </a>
                            </div>
                            <div class="col-12">
                                <div class="rsolution-border-line-dashed"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header border-bottom">
                        <div class="title">
                            <div class="row">
                                <div class="col">
                                    TOTAL REFUNDS
                                </div>
                                <div class="col-auto text-primary">
                                    {{ number_format($data->refund->sum('total') ) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        @foreach($data->refund as $item)
                        <div class="row ">
                            <div class="col font-weight-semi-bold">
                                {{ $item->method ? $item->method : 'another'}}
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('rcms.crm.index') }}?method={{ $item->method }}&startDate={{ @$_GET['startDate']}}&endDate={{ @$_GET['endDate'] }}&status=0" target="_blank"> {{ number_format(@$item->total) }} </a>
                            </div>
                            <div class="col-12">
                                <div class="rsolution-border-line-dashed"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header border-bottom">
                        <div class="title">
                            <div class="row">
                                <div class="col">
                                    Others
                                </div>
                                <div class="col-auto text-primary">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <div class="row ">
                            <div class="col font-weight-semi-bold">
                                User upgrade their deal
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('rcms.crm.index') }}?&startDate={{ @$_GET['startDate']}}&endDate={{ @$_GET['endDate'] }}&special_type=upgrade_deal" target="_blank"> {{ number_format($data->userUpgradeDeal) }} </a>
                            </div>
                            <div class="col-12">
                                <div class="rsolution-border-line-dashed"></div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col font-weight-semi-bold">
                                User upgrade their deal from Trial
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('rcms.crm.index') }}?startDate={{ @$_GET['startDate']}}&endDate={{ @$_GET['endDate'] }}&special_type=upgrade_deal_from_trial" target="_blank"> {{ number_format($data->userUpgradeDealFromTrial) }} </a>
                            </div>
                            <div class="col-12">
                                <div class="rsolution-border-line-dashed"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection