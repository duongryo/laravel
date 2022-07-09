@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Quản lý giới hạn @endslot
@endcomponent

<!-- Content -->
<div class="row ">
    <div class="col-xxl-8 col-12 mx-auto">
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
                            <input class="form-control" type="text" name="module" placeholder="Tên module" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Free</label>
                            <input class="form-control" type="number" name="free" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Premium</label>
                            <input class="form-control" type="number" name="premium" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Platinum</label>
                            <input class="form-control" type="number" name="platinum" value="0" required>
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
                            <th style="width: 250px;">Module</th>
                            <th class="text-center">Free</th>
                            <th class="text-center">Premium</th>
                            <th class="text-center">Platinum</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td style="width: 250px;">{{ $item->module }}</td>
                            <td class="text-center">{{ $item->free }}</td>
                            <td class="text-center">{{ $item->premium }}</td>
                            <td class="text-center">{{ $item->platinum }}</td>
                            <td class="text-center">
                                <!-- Edit -->
                                @component('rcms::components.modals.update')
                                @slot('id') {{$item->id}} @endslot

                                <div class="form-group">
                                    <label for="name">Module</label>
                                    <input class="form-control" type="text" name="module" value="{{ $item->module }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Free</label>
                                    <input class="form-control" type="number" name="free" value="{{ $item->free }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Premium</label>
                                    <input class="form-control" type="number" name="premium" value="{{ $item->premium }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Platinum</label>
                                    <input class="form-control" type="number" name="platinum" value="{{ $item->platinum }}" required>
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