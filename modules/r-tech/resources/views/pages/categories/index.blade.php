@extends('rcms::layout.index')
@section('content')
    @component('rcms::components.breadcrumb')
        @slot('title')
            Blog Categories
        @endslot
    @endcomponent

    <!-- Content -->
    <div class="row ">
        <div class="col-xxl-10 col-12 mx-auto">
            <div class="rsolution-card-shadow">
                @if (Session::has('status'))
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('status') }}</div>
                @endif

                <div class="rsolution-card-header border-bottom">
                    <div class="row d-flex align-items-center">
                        <div class="col">
                            <h6 class="m-0">List Categories</h6>
                        </div>
                        <div class="col-auto">
                            @component('rcms::components.modals.add')
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input class="form-control" type="text" name="name" placeholder="Title" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Slug</label>
                                    <input class="form-control" type="text" name="slug" placeholder="Slug" required readonly>
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
                                <th style="width: 50%;">Title</th>
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
                                        <td style="width: 50%;">{{ $item->name }}</td>
                                        <td class="text-center" style="width: 15%">
                                            <select name="status" id-post="{{ $item->id }}" data-target="status"
                                                class="custom-select custom-select-md">
                                                <option value="1" {{ $item->status == 1 ? 'Selected' : '' }}>Active</option>
                                                <option value="0" {{ $item->status == 0 ? 'Selected' : '' }}>Inactive</option>
                                            </select>
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-light btn-sm btn-icon"
                                                href="{{ route('rcms.category.edit', $item->id) }}"><i
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
                </div>
            </div>
        </div>
    </div>

@section('js')
    @include('rtech::custom.js')
    <script>
        $('[name="name"]').keyup(function() {
            let slug = ChangeToSlug($(this).val())
            $('[name="slug"]').attr('value', slug)
        })

        //Update status
        $('[data-target="status"]').change(function() {
            let status = $(this).val()

            let id = $(this).attr('id-post')
            $.ajax({
                type: "PATCH",
                url: "/rcms/category/" + id + "/update-fillable",
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
