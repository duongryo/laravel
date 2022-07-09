@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Cấu hình Shareasale @endslot
@endcomponent


<!-- Content -->
<div class="row ">
    <div class="col-4 mx-auto">
        <form class="rsolution-card-shadow" method="post" action="{{ $data ? route('rcms.config.shareasale.update', $data->id) : '' }}">
            @csrf
            @if($data)
            @method('PUT')
            @endif
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h6 class="m-0">Cấu hình</h6>
                    </div>
                    <div class="col-auto">
                        @if(isset($data->value['merchant_id']))
                        <span class="badge badge-success">Bật</span>
                        @else
                        <span class="badge badge-danger">Tắt</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <div class="form-group">
                    <label for="name">Merchan ID</label>
                    <input class="form-control" type="text" name="merchant_id" value="{{ $data ? @$data->value['merchant_id'] : null }}">
                </div>
                <div class="form-group">
                    <label for="name">Token</label>
                    <input class="form-control" type="text" name="token" value="{{ $data ? @$data->value['token'] : null }}">
                </div>
                <div class="form-group">
                    <label for="name">Secret Key</label>
                    <input class="form-control" type="text" name="secret_key" value="{{ $data ? @$data->value['secret_key'] : null }}">
                </div>
            </div>
            <div class="rsolution-card-footer">
                <button class="btn btn-primary btn-sm" type="submit">Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection