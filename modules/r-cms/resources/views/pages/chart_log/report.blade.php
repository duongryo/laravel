@extends('rcms::layout.index')
@section('content')

    @component('rcms::components.breadcrumb')
        @slot('title') Lịch sử hoạt động @endslot
    @endcomponent

    <!-- Content -->
    <div class="row ">
        <div class="col-xxl-12 col-12 mx-auto">
            <div class="rsolution-card-shadow h-auto">
                <form class="rsolution-card-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-2">
                            <div class="row">
                                <div class="col-auto d-flex align-items-center">
                                    <span class="font-weight-medium">Từ ngày </span>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="date" name="startDate"
                                        value="{{ !empty($_GET['startDate']) ? $_GET['startDate'] : null }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <div class="col-auto d-flex align-items-center">
                                    <span class="font-weight-medium">Đến ngày </span>
                                </div>
                                <div class="col">
                                    <input class="form-control" type="date" name="endDate"
                                        value="{{ !empty($_GET['endDate']) ? $_GET['endDate'] : null }}">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-auto d-flex align-items-center">
                                    <span class="font-weight-medium">Plan</span>
                                </div>
                                <div class="col">
                                    <select class="custom-select custom-select-lg" name="plan">
                                        <option value="">All</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}" @if (!empty($_GET['plan']) && $_GET['plan'] == $plan->id) selected @endif>{{ $plan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                            <span class="font-weight-medium">Column</span>
                        </div>
                        <div class="col">
                            <select class="custom-select custom-select-lg" name="column">
                                <option @if (!empty($_GET['column']) && $_GET['column'] == 'created_at')  selected  @endif value="created_at">Thời gian</option>
                                <option @if (!empty($_GET['column']) && $_GET['column'] == 'total')  selected  @endif value="total">Tổng số lần</option>
                            </select>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                            <span class="font-weight-medium">Sort By:</span>
                        </div>
                        <div class="col">
                            <select class="custom-select custom-select-lg" name="sort">
                                <option @if (!empty($_GET['sort']) && $_GET['sort'] == 'DESC')  selected  @endif value="desc">DESC</option>
                                <option @if (!empty($_GET['sort']) && $_GET['sort'] == 'asc')  selected  @endif value="asc">ASC</option>
                            </select>
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-primary" type="submit">Áp dụng</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="rsolution-card-shadow h-auto">
                <div class="rsolution-card-body">
                    <div class="row">
                        <div class="col-auto">
                            <h6><strong>Tên Module:</strong> {{ $data->module }}</h6>
                        </div>
                        <div class="col-auto">
                            <h6><strong> Tổng số người sử dụng:</strong> {{ $data->table->total() }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rsolution-card-shadow h-auto">
                <div class="rsolution-card-header">
                    <span class="title"> Biểu đồ thống kê lượt sử dụng</span>
                </div>
                <div class="rsolution-card-body">
                    <div id="chart"></div>
                </div>
            </div>
            <div class="rsolution-card-shadow h-auto">
                <div class="rsolution-card-header">
                    <span class="title">Danh sách</span>
                </div>
                <div class="rsolution-card-body">
                    <table class="table  rsolution-table">
                        <thead>
                            <tr class="align-middle">
                                <th class="id">#</th>
                                <th>User</th>
                                <th>Tổng số lần</th>
                                <th class="text-center">Module</th>
                                <th class="text-center">Thời gian</th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="rsolution-scrollbar">
                            @foreach ($data->table as $index => $item)
                                <tr class="align-middle">
                                    <td class="id">{{ $index + 1 }}</td>
                                    <td>{!! $item->user->email ?? ' <span class="text-danger"> Không xác định </span>' !!}</td>
                                    <td>{{ $item->total }}</td>
                                    <td class="text-center">{{ $item->module }}</td>
                                    <td class="text-center">
                                        {{ $item->created_at->format('H:s d/m/Y') }}
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-outline-primary btn-sm" target="_blank"
                                            href="{{ route('rcms.user-log.index') }}/{{ $item->user->id ?? '' }}?module={{ $data->module }}&startDate={{ $_GET['startDate'] }}&endDate={{ $_GET['endDate'] }}">Chi
                                            tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginate -->
                    <div class="pt-3 text-center fit-content m-auto" style="width:fit-content">
                        {{ $data->table->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('js')
    <script>
        chartOverViewModule(
            {!! json_encode(array_values($data->chart)) !!},
            {!! json_encode(array_keys($data->chart)) !!},
            {!! json_encode($data->module) !!}
        )
    </script>
@endsection
@endsection
