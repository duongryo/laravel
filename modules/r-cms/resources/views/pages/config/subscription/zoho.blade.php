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
                        <h6 class="m-0">Cấu hình Zoho Subscription</h6>
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <div class="mb-15 content">
                    @if($data)
                    <p><strong>Trạng thái:</strong> Đang hoạt động</p>
                    @else
                    <p><strong>Trạng thái:</strong> Chưa cài đ</p>
                    <p><strong>Bước 1:</strong> Vào <a href="https://api-console.zoho.com/" target="_blank">https://api-console.zoho.com/</a>, tạo Self Client, lấy Client ID và Client Secret tương ứng</p>
                    <p><strong>Bước 2:</strong> Generate code với scope: ZohoSubscriptions.hostedpages.READ,ZohoSubscriptions.hostedpages.CREATE,ZohoSubscriptions.plans.READ,ZohoSubscriptions.subscriptions.READ</p>
                    <p><strong>Bước 3:</strong> Điền code tương ứng và bấm lưu để hệ thống tiến hành cài đặt Zoho Subscription</p>
                    @endif
                </div>
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Client ID</label>
                        <input class="form-control" type="text" name="client_id" value="{{@$data->value['client_id']}}" @if($data) disabled @else required @endif>
                    </div>
                    <div class="form-group">
                        <label for="name">Client Secret</label>
                        <input class="form-control" type="text" name="client_secret" value="{{@$data->value['client_secret']}}" @if($data) disabled @else required @endif>
                    </div>
                    <div class="form-group">
                        <label for="name">Organization ID</label>
                        <input class="form-control" type="text" name="organization_id" value="{{@$data->value['organization_id']}}" @if($data) disabled @else required @endif>
                    </div>
                    @if($data)
                    <div class="form-group">
                        <label for="name">Refresh Token</label>
                        <input class="form-control" type="text" name="refresh_token" value="{{@$data->value['refresh_token']}}" disabled>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="name">Code</label>
                        <input class="form-control" type="text" name="code" required>
                    </div>
                    @endif

                    @if(!$data)
                    <button class="btn btn-primary btn-sm" type="submit">Lưu</button>
                    @endif
                </form>
            </div>
            <div class="rsolution-card-footer">
                @if($data)
                <div class="mb-5">*Xóa và cài đặt lại cấu hình Zoho</div>
                @component('rcms::components.modals.destroy')
                @slot('id') {{$data->id}} @endslot
                @endcomponent
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
