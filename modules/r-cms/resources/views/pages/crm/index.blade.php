@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Transaction report @endslot
@endcomponent
<!-- Content -->
<div class="row">
    <!-- Filter -->
    <div class="col-12">
        <form class="rsolution-card-shadow" method="get">
            <div class="rsolution-card-body">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">From plan</span>
                            </div>
                            <div class="col">
                                <select class="custom-select custom-select-lg" name="from_plan">
                                    <option value="">All</option>
                                    @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" @if(!empty($_GET['from_plan']) && $_GET['from_plan']==$plan->id ) selected @endif>{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">To plan</span>
                            </div>
                            <div class="col">
                                <select class="custom-select custom-select-lg" name="to_plan">
                                    <option value="">All</option>
                                    @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" @if(!empty($_GET['to_plan']) && $_GET['to_plan']==$plan->id ) selected @endif>{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">From</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" name="startDate" value="{{ !empty($_GET['startDate']) ? $_GET['startDate'] : null}}">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">To</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" name="endDate" value="{{ !empty($_GET['endDate']) ? $_GET['endDate'] : null}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">Status</span>
                            </div>
                            <div class="col">
                                <select class="custom-select custom-select-lg" name="status">
                                    <option value="">All</option>
                                    <option value="0" @if(!empty($_GET['status']) && $_GET['status']==0 ) selected @endif>Refund</option>
                                    <option value="1" @if(!empty($_GET['status']) && $_GET['status']==1 ) selected @endif>Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-15">
                    <div class="col-2">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">Note</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="text" name="note" value="{{ @$_GET['note'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">Show</span>
                            </div>
                            <div class="col">
                                <input min="1" class="form-control" type="number" name="limit" value="{{ !empty($_GET['limit']) ? $_GET['limit'] : 10}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-auto text-right">
                        <button class="btn btn-primary btn-icon">
                            <span class="fas fa-search"></span>
                        </button>
                        <a class="btn  btn-icon" href="{{ route('rcms.crm.index') }}">
                            <span class="fas fa-redo"></span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="col-12">
        <div class=" rsolution-card-shadow">
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <span class="title">Transactions</span>
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <table class="table rsolution-table border">
                    <thead>
                        <tr>
                            <th class="id">#</th>
                            <th style="width: 235px;">User</th>

                            <th class="text-center">Type</th>
                            <th class="text-center">From Plan</th>
                            <th class="text-center">To Plan</th>
                            <th class="text-center">Plan time</th>
                            <th class="text-center">Created at</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Method</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + $data->firstItem() }}</td>
                            <td style="width: 235px;">
                                {{ $item->member ? $item->member->email : 'Deleted member'}}
                            </td>

                            <td class="text-center">{{ $item->type }}</td>
                            <td class="text-center font-weight-bold">{{ @$item->fromPlanInfo->name }}</td>
                            <td class="text-center font-weight-bold">{{ @$item->toPlanInfo->name }}</td>
                            <td class="text-center">
                                {{ $item->plan_time }} days
                            </td>


                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                {{ $item->status ? 'Paid' : 'Refunded'}}
                            </td>
                            <td class="text-center">
                                {{ $item->method }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('rcms.manage-user.index') }}/{{ $item->member->id }}">Detail</a>
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

<!-- Modal Chart Transaction -->
<div class="modal fade" id="modalTransaction" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Biểu đồ dữ liệu thu nhập </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-30">
                <div id="chart"></div>
                <p> <span class="text-danger">*</span> <b>Lưu ý:</b>
                    Nếu không xuất hiện một số ngày trong biểu đồ thì ngày đó không có giao dịch nào.
                </p>
            </div>
        </div>
    </div>
</div>
@section('js')
<script>
    chartTransaction({
        !!json_encode(array_values($overview - > chartTransaction)) !!
    }, {
        !!json_encode(array_keys($overview - > chartTransaction)) !!
    })
</script>
@endsection
@endsection