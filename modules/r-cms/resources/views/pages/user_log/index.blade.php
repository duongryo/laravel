@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Users logs @endslot
@endcomponent

<!-- Content -->
<div class="row">
    <div class="col-12">
        <div class="rsolution-card-shadow">
            <form class="rsolution-card-body">
                <div class="row d-flex align-items-center">
                    <div class="col-auto">
                        <h6>Date</h6>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">From</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" name="startDate" value="{{$range[0]}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">To</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" name="endDate" value="{{$range[1]}}">
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
            <div class="rsolution-card-body">
                <div class="row">
                    <div class="col-12">
                        <h6><strong>Date:</strong> {{ $range[0]}} -  {{ $range[1] }}</h6>
                    </div>
                    <div class="col-12">
                        <h6><strong>Users:</strong> {{ $data->total() }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="rsolution-card-shadow">
            <div class="rsolution-card-header">
                <div class="col text-right">
                        <a class="btn btn-primary" href="{{route('rcms.user-log.export')}}?startDate={{$range[0]}}&endDate={{$range[1]}}&plan={{@$_GET['plan']}}">Export</a>
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
                            <th style="width: 250px;">Email</th>
                            <th class="text-right">Action</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + $data->firstItem() }}</td>
                            <td style="width: 250px;">{{ $item->user->email }}</td>
                            <td class="text-right">{{ $item->total }} </td>
                            <td class="text-right">
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('rcms.user-log.index')}}/{{ $item->user->id }}?startDate={{$range[0]}}&endDate={{$range[1]}}">Chi tiết</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginate -->
                <div class="row mt-3">
                    <div class="col">
                        {{ number_format($data->total())}} results
                    </div>
                    <div class="col-auto">
                        {{ $data->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection