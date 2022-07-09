@extends('rcms::layout.index')
@section('content')

    @component('rcms::components.breadcrumb')
        @slot('title')
            Team Members
        @endslot
    @endcomponent

    <!-- Content -->
    <div class="row ">
        <div class="col-xxl-10 col-12 mx-auto">
            <div class="col-12">
                <form class="rsolution-card-shadow" method="get">
                    <div class="rsolution-card-body">
                        <div class="row">
                            <div class="col">
                                <input placeholder="Nhập tên" class="form-control" name="search"
                                    value="{{ !empty($_GET['search']) ? $_GET['search'] : null }}">
                            </div>

                            <div class="col-3">
                                <select class="custom-select custom-select-lg" name="status">
                                    <option value="" selected>All</option>
                                    <option value="1" @if (!empty($_GET['status']) && $_GET['status'] == 1) selected @endif>Active</option>
                                    <option value="2" @if (!empty($_GET['status']) && $_GET['status'] == 2) selected @endif>Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Show</span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="number" min="1" name="limit"
                                            value="{{ !empty($_GET['limit']) ? $_GET['limit'] : 10 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-icon">
                                    <span class="fas fa-search"></span>
                                </button>
                                <a class="btn btn-white btn-icon" href="{{ route('rcms.team-members.index') }}">
                                    <span class="fas fa-redo mt-2"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="rsolution-card-shadow">
                    @if (Session::has('status'))
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}
                        </div>
                    @endif

                    <div class="rsolution-card-header border-bottom">
                        <div class="row d-flex align-items-center">
                            <div class="col">
                                <h6 class="m-0">List Member</h6>
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-primary btn-sm" href="{{ route('rcms.team-members.create') }}"><i
                                        class="fa fa-plus"></i>Add</a>
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <table class="table border rsolution-table">
                            <thead>
                                <tr class="align-middle">
                                    <th class="id">#</th>
                                    <th width="15%">Image</th>
                                    <th style="width: 250px;">Name</th>
                                    <th style="width: 150px;">Position</th>
                                    <th width="15%">Status</th>
                                    <th width="15%" class="text-center">Display Order</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="rsolution-scrollbar">
                                @if ($data->isEmpty())
                                    <td>Not found data.</td>
                                @else
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td class="id">{{ $key = $key + 1 }}</td>
                                            <td width="15%">
                                                <img width="100px" src="{{ env('APP_URL') . $item->images }}"
                                                    alt="">
                                            </td>
                                            <td style="width: 250px;">{{ $item->name }}</td>
                                            <td style="width: 150px;">{{ $item->position }}</td>
                                            <td class="text-center" style="width: 15%">
                                                <select name="status" id-member="{{ $item->id }}"
                                                    data-target="status" class="custom-select custom-select-md">
                                                    <option value="1" {{ $item->status == 1 ? 'Selected' : '' }}>
                                                        Active</option>
                                                    <option value="0" {{ $item->status == 0 ? 'Selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </td>
                                            <td width="15%" class="text-center">
                                                {{ $item->display_order }}
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-light btn-sm btn-icon"
                                                    href="{{ route('rcms.team-members.edit', $item->id) }}"><i
                                                        class="far fa-edit"></i></a> &emsp;
                                                @component('rcms::components.modals.destroy')
                                                    @slot('id')
                                                        {{ $item->id }}
                                                    @endslot
                                                @endcomponent
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                        <!-- Paginate -->
                        <div class="pt-3 text-center fit-content m-auto" style="width:fit-content">
                            {{ $data->appends(request()->input())->links() }} 
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@section('js')
    <script>
        //Update status
        $('[data-target="status"]').change(function() {
            let status = $(this).val()
            let id = $(this).attr('id-member')
            $.ajax({
                type: "PATCH",
                url: "/rcms/team-members/" + id + "/update-fillable",
                data: {
                    _token: $('input[name=_token]').val(),
                    id: id,
                    field: 'status',
                    value: status
                },
                success: function(data, status) {
                    toastr.success("Success");
                    // location.reload()
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.warning("Some error");
                }
            })
        })
    </script>
@endsection
@endsection
