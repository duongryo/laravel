@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Users management @endslot
@endcomponent

<!-- Content -->
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <form class="rsolution-card-shadow" method="get">
                    <div class="rsolution-card-body">
                        <div class="row">
                            <div class="col">
                                <input placeholder="Email" class="form-control" name="search" value="{{ !empty($_GET['search']) ? $_GET['search'] : null}}">
                            </div>
                            <div class="col-3">
                                <select class="custom-select custom-select-lg" name="plan">
                                    <option value="0">All</option>
                                    @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" @if(!empty($_GET['plan']) && $_GET['plan'] == $plan->id ) selected @endif>{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="custom-select custom-select-lg" name="role">
                                    <option value="0">All</option>
                                    <option value="4" @if(!empty($_GET['role']) && $_GET['role']==4 ) selected @endif>Tester</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-icon">
                                    <span class="fas fa-search"></span>
                                </button>
                                <a class="btn  btn-icon" href="{{ route('rcms.manage-user.index') }}">
                                    <span class="fas fa-redo mt-2"></span>
                                </a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Signup at = </span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="created_at" value="{{ !empty($_GET['created_at']) ? $_GET['created_at'] : null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Last login <= </span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="last_login" value="{{ !empty($_GET['last_login']) ? $_GET['last_login'] : null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Show</span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="number" min="1" name="limit" value="{{ !empty($_GET['limit']) ? $_GET['limit'] : 10}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header border-bottom">
                        <div class="row d-flex align-items-center">
                            <div class="col">
                                <span class="title">Users</span>
                            </div>

                        </div>
                    </div>

                    <div class="rsolution-card-body">
                        <table class="table rsolution-table border">
                            <thead>
                                <tr>
                                    <th class="id">#</th>
                                    <th style="width: 250px;">Email</th>
                                    <th class="text-center">Signup at</th>
                                    <th class="text-center">Last login</th>
                                    <th class="text-center">Plan</th>
                                    <th class="text-center">Expired date</th>
                                    <th class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="rsolution-scrollbar">
                                @foreach($data as $index => $item)
                                <tr class="align-middle">
                                    <td class="id">{{ $index + $data->firstItem() }}</td>
                                    <td style="width: 250px;">{{$item->email}}</td>
                                    <td class="text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $item->last_login ? \Carbon\Carbon::parse($item->last_login)->format('d/m/Y') : '-'  }} </td>
                                    <td class="text-center font-weight-bold">
                                        {{@$item->planInfo->name }}
                                    </td>
                                    <td class="text-center">
                                        @if( $item->activation)
                                        {{ \Carbon\Carbon::parse($item->activation->expiration_date)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('rcms.manage-user.index') }}/{{ $item->id }}">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Paginate -->
                        <div class="row mt-3">
                            <div class="col">
                               {{ number_format($data->total())}} result
                            </div>
                            <div class="col-auto">
                                {{ $data->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection