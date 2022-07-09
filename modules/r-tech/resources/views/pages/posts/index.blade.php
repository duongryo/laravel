@extends('rcms::layout.index')
@section('content')

    @component('rcms::components.breadcrumb')
        @slot('title')
            Blog
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
                                <input placeholder="Nhập tiêu đề" class="form-control" name="search"
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
                            <div class="col-auto">
                                <button class="btn btn-primary btn-icon">
                                    <span class="fas fa-search"></span>
                                </button>
                                <a class="btn btn-white btn-icon" href="{{ route('rcms.post.index') }}">
                                    <span class="fas fa-redo mt-2"></span>
                                </a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <span class="font-weight-medium">Date = </span>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" type="date" name="created_at"
                                            value="{{ !empty($_GET['created_at']) ? $_GET['created_at'] : null }}">
                                    </div>
                                </div>
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
                                <h6 class="m-0">List Blog</h6>
                            </div>
                            <div class="col-auto">
                                <a class="btn btn-primary btn-sm" href="{{ route('rcms.post.create') }}"><i
                                        class="fa fa-plus"></i>Add</a>
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <table class="table border rsolution-table">
                            <thead>
                                <tr class="align-middle">
                                    <th class="id">#</th>
                                    <th width="15%"></th>
                                    <th style="width: 250px;">Title</th>
                                    <th style="width: 15%;">Date <i class="fas fa-info" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Display position outside of Blog page => order of posting date"></i></th>
                                    <th width="15%">Status</th>
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
                                            <td style="width: 15%;">
                                                <span data-id="{{ $item->id }}">{{ $item->created_at }}</span>
                                                <input data-id="{{ $item->id }}" class="d-none form-control"
                                                    type="date" name="created_at">
                                                <button data-id="{{ $item->id }}" class="btn btn-light btn-sm btn-icon"
                                                    data-target="btn-edit-date" onclick="editData({{ $item->id }})"><i
                                                        class="far fa-edit"></i></button>
                                                <div data-id="{{ $item->id }}"
                                                    class="row d-none justify-content-center mt-2">
                                                    <div class="col-3 btn-danger btn-sm btn-icon float-right mr-2"
                                                        style="cursor:pointer" onclick="cancelEdit({{ $item->id }})">
                                                        X
                                                    </div>
                                                    <div class="col-3 btn-primary btn-sm btn-icon float-right"
                                                        style="cursor:pointer" data-target="btn-save"
                                                        onclick="saveData({{ $item->id }})">
                                                        <i class="far fa-save"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center" style="width: 15%">
                                                <select name="status" id-post="{{ $item->id }}"
                                                    data-target="status" class="custom-select custom-select-md">
                                                    <option value="1" {{ $item->status == 1 ? 'Selected' : '' }}>
                                                        Active</option>
                                                    <option value="0" {{ $item->status == 0 ? 'Selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-light btn-sm btn-icon"
                                                    href="{{ route('rcms.post.edit', $item->id) }}"><i
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        //Show update form
        function editData(id) {
            $('[data-id=' + id + ']').toggleClass('d-none')

            $('[data-target="btn-edit-date"]').each(function() {
                $(this).attr('disabled', true)
            })

        }

        //Cancel update form
        function cancelEdit(id) {
            $('[data-target="btn-edit-date"]').each(function() {
                $(this).attr('disabled', false)
            })
            $('[data-id=' + id + ']').toggleClass('d-none')
        }


        //Update date
        function saveData(id) {
            let date = $('input[data-id="' + id + '"]').val()
            if (Date.parse(date)) {
                $.ajax({
                    type: "PATCH",
                    url: "/rcms/post/{" + id + "}/date",
                    data: {
                        _token: $('input[name=_token]').val(),
                        id: id,
                        created_at: date
                    },
                    success: function(data, status) {
                        toastr.success("Success");
                        location.reload()
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.warning("Some error");
                    }
                })
            }
        }

        //Update status
        $('[data-target="status"]').change(function() {
            let status = $(this).val()
            let id = $(this).attr('id-post')
            $.ajax({
                type: "PATCH",
                url: "/rcms/post/" + id + "/update-fillable",
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
