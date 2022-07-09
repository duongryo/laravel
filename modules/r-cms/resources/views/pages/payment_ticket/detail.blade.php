@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Chi tiết yêu cầu thanh toán @endslot
@endcomponent
<div class="row ">
    <div class="col-10 col-xxl-8 mx-auto">
        <div class=" rsolution-card-shadow">
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <span class="title">Thông tin giao dịch</span>
                    </div>
                    @if(!$data->status)
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#modal-approve">Xác nhận giao dịch</button>
                        @component('rcms::components.modals.destroy')
                        @slot('id') {{$data->id}} @endslot
                        @endcomponent
                    </div>
                    @endif

                </div>
            </div>
            <div class="rsolution-card-body">
                <h6 class="font-weight-bold mb-3 text-primary">Thông tin thành viên</h6>
                <div class="row">
                    <div class="col-auto avatar-box">
                        <div class="w-100">
                            <img src="/themes/rsolution/img/icon/avatar.svg" width="150">
                        </div>
                    </div>
                    <div class="col">

                        <h6><strong>Tên:</strong> {{ $data->member->name }}</h6>
                        <h6><strong>Họ:</strong> {{ $data->member->last_name }}</h6>
                        <h6><strong>Email:</strong> {{ $data->member->email }}</h6>
                        <h6><strong>Số điện thoại:</strong> </h6>
                        <h6><strong>Trạng thái:</strong> Hoạt động</h6>


                    </div>
                </div>
                <div class="rsolution-border-line-dashed"></div>
                <h6 class="font-weight-bold mb-3 text-primary">Thông tin giao dịch</h6>
                <div class="row">
                    <div class="col-6">
                        <h6><strong>Hình thức thanh toán:</strong> {{ $data->value['method'] == 'bank' ? 'Chuyển khoản ngân hàng' : $data->value['method'] }}</h6>
                        <h6><strong>Mã giao dịch:</strong> {{ $data->value['code'] }}</h6>
                        <h6><strong>Gói:</strong> {{ $data->value['plan']['name'] }}</h6>
                        <h6><strong>Số lượng:</strong> {{ $data->value['quantity'] }} {{ $data->value['type'] == 'monthly' ? 'tháng' : 'năm' }}</h6>
                        <h6><strong>Ngày tạo:</strong> {{ $data->created_at }}</h6>
                    </div>
                    <div class="col">
                        <h6><strong>Giá:</strong> {{ number_format($data->value['price']) }} VND</h6>
                        <h6><strong>Discount:</strong> {{ number_format($data->value['discount']) }} VND</h6>
                        <h6><strong>Coupon:</strong> {{ $data->value['coupon'] }} </h6>
                        <div class="rsolution-border-line-dashed"></div>
                        <h6><strong>Số tiền thanh toán:</strong> {{ number_format($data->value['amount']) }} VND</h6>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-approve" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ route('rcms.payment-ticket.index') }}/{{ $data->id }}">
            @csrf
            {{ method_field('PUT') }}
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Xác nhận</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input name="id" value="{{$data->id}}" hidden required />
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="customCheck1" type="checkbox" required>
                    <label class="custom-control-label pt-0" for="customCheck1">Xác nhận các thông tin giao dịch</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary btn-submit btn-sm">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

@section('js')
<script>
    // A $( document ).ready() block.
    $("form").submit(function(event) {
        $('.btn-submit').prop('disabled', true);
    });

</script>
@endsection
@endsection
