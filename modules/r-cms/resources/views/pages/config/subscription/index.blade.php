@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Cấu hình Subscription @endslot
@endcomponent

<!-- Content -->
<div class="row">
    <div class="col-4 mx-auto">
        <div class="rsolution-card-shadow">
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h6 class="m-0">Cấu hình Stripe</h6>
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <div class="mb-15 content">
                    @if($data)
                    <p><strong>Trạng thái:</strong> Đang hoạt động</p>
                    @else
                    <p><strong>Trạng thái:</strong> Chưa cài đặt</p>
                    @endif
                </div>
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">API Key</label>
                        <input class="form-control" type="text" name="key" value="{{@$data->value['key']}}" @if($data) disabled @else required @endif>
                    </div>
                    @if(!$data)
                    <button class="btn btn-primary btn-sm" type="submit">Lưu</button>
                    @endif
                </form>
            </div>
            <div class="rsolution-card-footer">
                @if($data)
                <div class="mb-5">*Xóa và cài đặt lại cấu hình Stripe</div>
                @component('rcms::components.modals.destroy')
                @slot('id') {{$data->id}} @endslot
                @endcomponent
                @endif
            </div>
        </div>
    </div>
</div>
@endsection