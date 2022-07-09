@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Quản lý Module @endslot
@endcomponent

<!-- Content -->
<div class="row">
    <div class="col-12">
        <div class="rsolution-card-shadow">
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <span class="title">Danh sách</span>
                    </div>
                    <div class="col-auto">
                        @component('rcms::components.modals.add')
                        <div class="form-group">
                            <label for="name">Module</label>
                            <input class="form-control" type="text" name="module" placeholder="Module" required>
                        </div>

                        <div class="form-group">
                            <label>Type</label>
                            <select class="form-control" name="type" required>
                                <option value="daily">Daily</option>
                                <option value="monthly">Monthly</option>
                                <option value="custom">Custom</option>
                            </select>
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
                            <th>Module</th>
                            <th>Type</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td>{{ $item->module }}</td>
                            <td>{{ $item->type }}</td>
                            <td class="text-right">
                                <!-- Edit -->
                                @component('rcms::components.modals.update')
                                @slot('id') {{$item->id}} @endslot
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="daily">Daily</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>
                                @endcomponent
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