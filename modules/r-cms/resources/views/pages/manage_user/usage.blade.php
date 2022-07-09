@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Remaining Limit @endslot
@endcomponent
<a class="btn btn-primary btn-sm" href="{{ route('rcms.manage-user.index') }}/{{ $user->id }}">Back</a>
<div class="rsolution-card-shadow">
    <div class="rsolution-card-header border-bottom">
        <div class="title">Remaining Credit</div>
    </div>
    <div class="rsolution-card-body">
        <table class="table rsolution-table border">
            <thead>
                <tr class="align-middle">
                    <th class="id">#</th>
                    <th class="text-left">Module</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Limit</th>
                    <th class="text-center">Usage</th>
                    <th class="text-center">Monthly Available</th>
                    <th class="text-center">OneTime Available</th>
                    <th class="text-center">Total Available</th>
                    <th class="text-right id">-</th>
                </tr>
            </thead>
            <tbody class="rsolution-scrollbar" style="max-height:400px">
                @foreach($usage as $index => $item)
                @if($item['module'] == 'keyword_value' || $item['module'] == 'content_value')
                <tr class="align-middle">
                    <td class="id">{{ $index + 1 }}</td>
                    <td class="text-left">{{ $item['module'] }}</td>
                    <td class="text-center">{{ $item['type']}}</td>
                    <td class="text-center">{{ number_format($item['limit']) }}</td>
                    <td class="text-center">{{ number_format($item['usage']) }}</td>
                    <td class="text-center">{{ number_format($item['monthly_available']) }}</td>
                    <td class="text-center">{{ number_format($item['one_time_available']) }}</td>
                    <td class="text-center">{{ number_format($item['available']) }}</td>
                    <td class="text-right id"></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="rsolution-card-shadow">
    <div class="rsolution-card-header border-bottom">
        <div class="title">Remaining Limit</div>
    </div>
    <div class="rsolution-card-body">
        <table class="table rsolution-table border">
            <thead>
                <tr class="align-middle">
                    <th class="id">#</th>
                    <th class="text-left">Module</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Limit</th>
                    <th class="text-center">Usage</th>
                    <th class="text-center">Available</th>
                    <th class="text-right id">-</th>
                </tr>
            </thead>
            <tbody class="rsolution-scrollbar" style="max-height:400px">
                @foreach($usage as $index => $item)
                @if($item['module'] != 'keyword_value' && $item['module'] != 'content_value' && $item['type'] != 'custom')
                <tr class="align-middle">
                    <td class="id">{{ $index + 1 }}</td>
                    <td class="text-left">{{ $item['module'] }}</td>
                    <td class="text-center">{{ $item['type']}}</td>
                    <td class="text-center">{{ number_format($item['limit']) }}</td>
                    <td class="text-center">{{ number_format($item['usage']) }}</td>
                    <td class="text-center">{{ number_format($item['available']) }}</td>
                    <td class="text-right id"></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection