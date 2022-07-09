@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') User Logs @endslot
@endcomponent

<!-- Content -->
<div class="row ">
    <div class="col-12">
        <div class="mb-3 rsolution-card-shadow h-auto">
            <form class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">From</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" name="startDate" value="{{ !empty($_GET['startDate']) ? $_GET['startDate'] : null}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">To</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="date" name="endDate" value="{{ !empty($_GET['endDate']) ? $_GET['endDate'] : null}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <span class="font-weight-medium">Module</span>
                            </div>
                            <div class="col">

                                <select class="form-control" name="module">
                                    <option value="">All</option>
                                    @foreach($modules as $item)
                                    <option value="{{ $item->module }}">{{ $item->module }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col text-right">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="mb-3 rsolution-card-shadow h-auto">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <h6 class="mb-0"><strong>User:</strong> {{ $user->name }}</h6>
                    </div>
                    <div class="col-auto">
                        <h6 class="mb-0"><strong>Count:</strong> {{ $total }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="rsolution-card-shadow h-auto">
            <div class="rsolution-card-header">
                <div class="col text-right">
                        <a class="btn btn-primary" href="{{route('rcms.user-log.export-detail',$user->id)}}?startDate={{ !empty($_GET['startDate']) ? $_GET['startDate'] : null}}&endDate={{ !empty($_GET['endDate']) ? $_GET['endDate'] : null}}&module={{ !empty($_GET['module']) ? $_GET['module'] : null}}">Export</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h6 class="m-0">Logs</h6>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>

                <table class="mt-3 table  rsolution-table">
                    <thead>
                        <tr class="align-middle">
                            <th class="id">#</th>
                            <th>Action</th>
                            <th class="text-center">Module</th>
                            <th class="text-center">Count</th>
                            <th class="text-right">Created at</th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @foreach($data as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td>{{ $item->message }}</td>
                            <td class="text-center text-capitalize">
                                @if($item->module == 'keyword_value')
                                Keyword Credit
                                @elseif($item->module == 'keyword_value')
                                AI Credit
                                @else
                                {{ str_replace("_"," ",$item->module) }}
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($item->value) }}</td>
                            <td class="text-right">
                                {{ $item->created_at }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginate -->
                <div class="pt-3 text-center fit-content m-auto" style="width:fit-content">
                    {{ $data->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection