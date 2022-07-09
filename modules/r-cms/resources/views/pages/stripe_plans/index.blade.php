@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Quản lý PLan Stripe @endslot
@endcomponent

<!-- Content -->
<div class="row ">
    <div class="col-12 mx-auto">
        <div class="rsolution-card-shadow">
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <span class="title">Danh sách</span>
                    </div>
                    <div class="col-auto">
                        @component('rcms::components.modals.add')
                        <div class="form-group">
                            <label for="name"> Code</label>
                            <input class="form-control" type="text" name="code" placeholder="Tên" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Gói</label>
                            <select class="form-control" name="plan_id">
                                @foreach($plans as $plan)
                                <option value="{{$plan->id}}">{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Loại</label>
                            <select class="form-control" name="type">
                                <option value="monthly">Monthly</option>
                                <option value="anual">Anual</option>
                                <option value="value">Value</option>
                                <option value="addon">Addon</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Keyword value</label>
                            <input class="form-control" type="number" name="keyword_value" value="0">
                        </div>
                        <div class="form-group">
                            <label for="name">Content value</label>
                            <input class="form-control" type="number" name="content_value" value="0">
                        </div>

                        <div class="form-group">
                            <label for="name">Addon key</label>
                            <input class="form-control" type="text" name="addon">
                        </div>
                        @endcomponent
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <table class="table rsolution-table border">
                    <thead>
                        <tr class="align-middle">
                            <th class="id">#</th>
                            <th style="width: 150px;">Stripe Code</th>
                            <th class="text-center">App Plan</th>
                            <th class="text-center">Loại</th>
                            <th class="text-center">Keyword Value</th>
                            <th class="text-center">Content Value</th>
                            <th class="text-center">Addon</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td style="width: 150px;">{{ $item->code }}</td>
                            <td class="text-center">{{ $item->type !='value' && $item->type !='addon' ? $item->plan->name : ''}}</td>
                            <td class="text-center">{{ $item->type }}</td>
                            <td class="text-center">{{ $item->type !='value' ? '' : $item->keyword_value }}</td>
                            <td class="text-center">{{ $item->type !='value' ? '' : $item->content_value }}</td>
                            <td class="text-center">{{ $item->addon }}</td>
                            <td class="text-center">
                                <!-- Destroy  -->
                                @component('rcms::components.modals.destroy')
                                @slot('id') {{$item->id}} @endslot

                                @endcomponent
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginate -->
                <div class="pt-3 text-center fit-content m-auto" style="width:fit-content">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection