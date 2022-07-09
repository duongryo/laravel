@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Payment ticket @endslot
@endcomponent
<div class="row ">
    <div class="col-xxl-9 col-12 mx-auto">
        <div class="row">
            <div class="col-12">
                <form class="rsolution-card-shadow" method="get">
                    <div class="rsolution-card-body">
                        <div class="row">
                            <div class="col">
                                <select class="custom-select custom-select-lg" name="type">
                                    <option value="0">Tất cả</option>
                                    <option value="first_upgrade">Nâng cấp lần đầu</option>
                                    <option value="expired_soon">Sắp hết hạn</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Từ ngày </span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="startDate" value="{{ !empty($_GET['startDate']) ? $_GET['startDate'] : null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Đến ngày </span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="endDate" value="{{ !empty($_GET['endDate']) ? $_GET['endDate'] : null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Hiển thị</span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="number" min="1" name="limit" value="{{ !empty($_GET['limit']) ? $_GET['limit'] : 10}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-icon">
                                    <span class="fas fa-search"></span>
                                </button>
                                <a class="btn  btn-icon" href="{{ route('rcms.payment-ticket.index') }}">
                                    <span class="fas fa-redo mt-2"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class=" rsolution-card-shadow">
                    <div class="rsolution-card-header border-bottom">
                        <div class="row d-flex align-items-center">
                            <div class="col">
                                <span class="title">Danh sách giao dịch</span>
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <table class="table rsolution-table border">
                            <thead>
                                <tr>
                                    <th class="id">#</th>
                                    <th style="width: 250px;">Thành viên</th>
                                    <th class="text-center">Ngày tạo giao dịch</th>
                                    <th class="text-center">Mã giao dịch</th>
                                    <th class="text-center">Số tiền</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-right"></th>

                                </tr>
                            </thead>
                            <tbody class="rsolution-scrollbar">
                                @foreach($data as $index => $item)
                                <tr class="align-middle">
                                    <td class="id">{{ $index + $data->firstItem() }}</td>
                                    <td style="width: 250px;">{{ $item->member ? $item->member->email : 'Thành viên đã xóa'}}</td>
                                    <td class="text-center">{{ $item->created_at }}</td>
                                    <td class="text-center">{{ $item->value['code'] }}</td>
                                    <td class="text-center">{{ @number_format($item->value['total']) }} VND</td>
                                    <td class="text-center">
                                        @if($item->status)
                                        <span class="badge badge-success">Hoàn thành</span>
                                        @else
                                        <span class="badge badge-warning">Chờ xử lý</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <!-- Destroy  -->
                                        @if(!$item->status)
                                        @component('rcms::components.modals.destroy')
                                        @slot('id') {{$item->id}} @endslot
                                        @endcomponent
                                        @endif

                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('rcms.payment-ticket.index') }}/{{ $item->id }}">Chi tiết</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginate -->
                        <div class="row mt-3">
                            <div class="col">
                                Có tất cả {{ number_format($data->total())}} kết quả
                            </div>
                            <div class="col-auto">
                                {{ $data->withQueryString()->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
