@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Quản lý Limit @endslot
@endcomponent

<!-- Content -->
<div class="row ">
    <div class="col-12 mx-auto">
        <form class="rsolution-card-shadow" method="post">
            @csrf
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <span class="title">Danh sách</span>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" type="submit">Save</button>
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <table class="table rsolution-table border">
                    <thead>
                        <tr class="align-middle">
                            <th class="id">#</th>
                            <th>Module</th>
                            <th>Type</th>
                            @foreach($data->plans as $plan)
                            <th class="text-center">{{ $plan->name }}</th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data->data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td>{{ $item['module'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            @foreach($item['values'] as $value)
                            <td class="text-center">
                                <input class="form-control form-control-sm mx-auto" name="limit[{{ $value['module_id'] }}][{{ $value['plan_id'] }}]" type="number" style="width:100px" value="{{ $value['limit'] }}">
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </form>
    </div>
</div>
@endsection