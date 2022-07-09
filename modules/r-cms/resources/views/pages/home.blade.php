@extends('rcms::layout.index')
@section('content')
@component('rcms::components.breadcrumb')
@slot('title') Dashboard @endslot
@endcomponent
<!-- Content -->
<div class="row d-flex justify-content-center">
    <div class="col-xxl-9 col-12">
        <div class="row">
            <div class="col-3">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-body">
                        <h6>Total Members</h6>
                        <h3>{{ number_format(@$info[0]->total + @$info[1]->total + @$info[2]->total)}}</h3>
                    </div>
                </div>

            </div>

            <div class="col-3">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-body">
                        <h6>Free Members</h6>
                        <h3>{{ number_format(@$info[0]->total) }}</h3>
                    </div>
                </div>

            </div>

            <div class="col-3">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-body">
                        <h6>Premium Members</h6>
                        <h3>{{ number_format(@$info[1]->total) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-body">
                        <h6>Platinum Members</h6>
                        <h3>{{ number_format(@$info[2]->total) }}</h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection