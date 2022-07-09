@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Quản lý PLan Zoho @endslot
@endcomponent

<!-- Content -->
<div class="row ">
    <div class="col-auto mx-auto" style="width:675px">
        <div class="rsolution-card-shadow">
            <div class="rsolution-card-header border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <span class="title">Danh sách</span>
                    </div>
                    <div class="col-auto">
                        @component('rcms::components.modals.add')
                        <div class="form-group">
                            <label for="name">Zoho Code</label>
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
                        @endcomponent
                    </div>
                </div>
            </div>
            <div class="rsolution-card-body">
                <table class="table rsolution-table border">
                    <thead>
                        <tr class="align-middle">
                            <th class="id">#</th>
                            <th style="width: 150px;">Zoho Code</th>
                            <th class="text-center">App Plan</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td style="width: 150px;">{{ $item->code }}</td>
                            <td class="text-center">{{ $item->plan->name }}</td>
                            <td class="text-center">

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
