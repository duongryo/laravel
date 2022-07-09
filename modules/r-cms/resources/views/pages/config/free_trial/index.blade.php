@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Cấu hình Free Trial @endslot
@endcomponent


<!-- Content -->
<div class="row ">
    <div class="col-4 mx-auto">
        <form class="rsolution-card-shadow" method="post" action="{{ $data ? route('rcms.config.free-trial.update', $data->id) : '' }}">
            @csrf
            @if($data)
            @method('PUT')
            @endif
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h6 class="m-0">Cấu hình</h6>
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <div class="form-group">
                    <label for="name">Gói</label>
                    <select class="form-control" name="plan_id">
                        <option value="0">Tắt Freetrial</option>
                        @foreach($plans as $plan)
                        <option value="{{$plan->id}}" @if($data && $data->value['plan_id']== $plan->id)selected @endif>{{ $plan->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Số ngày</label>
                    <input class="form-control" type="text" name="plan_time" value="{{ $data ? $data->value['plan_time'] : 0}}" required>
                </div>
            </div>
            <div class="rsolution-card-footer">
                <button class="btn btn-primary btn-sm" type="submit">Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection
