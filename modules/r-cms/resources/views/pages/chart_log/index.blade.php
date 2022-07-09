@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Module report @endslot
@endcomponent

<!-- Content -->
<div class="row ">
    <div class=" col-12 ">
        <div class="row">
            <div class="col-12">
                <div class="rsolution-card-shadow">
                    <form class="rsolution-card-body">
                        <div class="row d-flex align-items-center">
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">From</span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="startDate" value="{{current($data->range)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">To</span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="endDate" value="{{last($data->range)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <select class="custom-select custom-select-lg" name="plan">
                                    <option value="">All</option>
                                    @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" @if(!empty($_GET['plan']) && $_GET['plan']==$plan->id ) selected @endif>{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-primary" type="submit">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header">
                        <span class="title">Module usage overview</span>
                    </div>
                    <div class="rsolution-card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header">
                        <div class="col text-right">
                                <a class="btn btn-primary" href="{{route('rcms.chart-log.export')}}?startDate={{current($data->range)}}&endDate={{ last($data->range)}}&plan={{@$_GET['plan']}}">Export</a>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <div class="row d-flex align-items-center">
                            <div class="col">
                                <h6 class="m-0">Detail</h6>
                            </div>
                            <div class="col-auto">

                            </div>
                        </div>

                        <table class="mt-3 table  rsolution-table">
                            <thead>
                                <tr class="align-middle">
                                    <th class="id">#</th>
                                    <th style="width: 250px;">Module</th>
                                    <th class="text-center">Usage</th>
                                    <th class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="rsolution-scrollbar">
                                @foreach($data->table as $index => $item)
                                <tr class="align-middle">
                                    <td class="id">{{ $index + 1 }}</td>
                                    <td style="width: 250px;">{{ $item->module }}</td>
                                    <td class="text-center">{{ $item->total }} </td>
                                    <td class="text-right">
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('rcms.chart-log.index')}}/{{ $item->module }}?startDate={{current($data->range)}}&endDate={{ last($data->range)}}&plan={{@$_GET['plan']}}">
                                        Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginate -->
                        {{-- <div class="row mt-3">
                            <div class="col">
                                Có tất cả {{ number_format($data->total())}} kết quả
                    </div>
                    <div class="col-auto">
                        {{ $data->withQueryString()->links() }}
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
</div>
</div>
@php
// dd( $chart);
@endphp
@section('js')
    <script>
        chartOverViewTotal(
            {!! json_encode($data->chart) !!},
            {!! json_encode($data->range) !!}
        )
    </script>
@endsection
@endsection
