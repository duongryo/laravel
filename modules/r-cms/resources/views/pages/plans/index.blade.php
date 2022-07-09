@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Quản lý gói @endslot
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
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Tên " required>
                        </div>
                        <div class="form-group">
                            <label for="name">Monthly price</label>
                            <input class="form-control" type="number" name="monthly_price" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Anual Price</label>
                            <input class="form-control" type="number" name="anual_price" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Credit</label>
                            <input class="form-control" type="number" name="credit" value="0" required>
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
                            <th style="width: 150px;">Name</th>
                            <th class="text-center"></th>
                            <th class="text-center">Monthly Price</th>
                            <th class="text-center">Anual Price</th>
                            <th class="text-center">Credit</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td style="width: 150px;">{{ $item->name }}</td>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">{{ number_format($item->monthly_price) }}</td>
                            <td class="text-center">{{ number_format($item->anual_price) }}</td>
                            <td class="text-center">{{ $item->credit }}</td>
                            <td class="text-center">
                                <!-- Edit -->
                                @component('rcms::components.modals.update')
                                @slot('id') {{$item->id}} @endslot

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" value="{{ $item->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Monthly Price</label>
                                    <input class="form-control" type="number" name="monthly_price" value="{{ $item->monthly_price }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Anual Price</label>
                                    <input class="form-control" type="number" name="anual_price" value="{{ $item->anual_price }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Credit</label>
                                    <input class="form-control" type="number" name="credit" value="{{ $item->credit }}" required>
                                </div>
                                @endcomponent
                                <!-- Destroy  -->

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
