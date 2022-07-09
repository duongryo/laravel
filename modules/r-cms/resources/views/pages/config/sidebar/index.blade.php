@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Cấu hình Sidebar @endslot
@endcomponent


<!-- Content -->
<div class="row ">
    <div class="col-xxl-8 col-12 mx-auto">
        <div class="rsolution-card-shadow">
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h6 class="m-0">Danh sách</h6>
                    </div>
                    <div class="col-auto">
                        @component('rcms::components.modals.add')
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input class="form-control" type="text" name="name" placeholder="Tên module" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Url</label>
                            <input class="form-control" type="text" name="url" placeholder="url" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Icon</label>
                            <input class="form-control" type="text" name="icon" value="fa fa-star" placeholder="icon" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Hiển thị</label>
                            <select class="form-control" name="public">
                                <option value="0">Admin</option>
                                <option value="1">Admin + Manager</option>
                            </select>
                        </div>
                        @endcomponent
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <table class="table border rsolution-table">
                    <thead>
                        <tr class="align-middle">
                            <th class="id">#</th>
                            <th style="width: 250px;">Tên</th>
                            <th class="text-center">Url</th>
                            <th class="text-center">Icon</th>
                            <th class="text-center">Hiển thị</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        @php
                        $value = (object) $item->value;
                        @endphp
                        <tr class="align-middle">
                            <td class="id">{{ $index + $data->firstItem() }}</td>
                            <td style="width: 250px;">{{ @$value->name }}</td>
                            <td class="text-center">{{ @$value->url }}</td>
                            <td class="text-center">
                                <i class="{{ @$value->icon }}"></i>
                            </td>
                            <td class="text-center">{{ @$value->public == 0 ? 'Admin' : 'Admin + Manager' }}</td>
                            <td class="text-center">
                                <!-- Edit -->
                                @component('rcms::components.modals.update')
                                @slot('id') {{$item->id}} @endslot
                                <div class="form-group">
                                    <label for="name">Tên</label>
                                    <input class="form-control" type="text" name="name" placeholder="Tên module" value="{{ @$value->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Url</label>
                                    <input class="form-control" type="text" name="url" placeholder="url" value="{{ @$value->url }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Icon</label>
                                    <input class="form-control" type="text" name="icon" value="fa fa-star" placeholder="icon" value="{{ @$value->icon }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Hiển thị</label>
                                    <select class="form-control" name="public">
                                        <option value="0">Admin</option>
                                        <option value="1">Admin + Manager</option>
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
