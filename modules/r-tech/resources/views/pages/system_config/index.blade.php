@extends('rcms::layout.index')
@section('content')
    @component('rcms::components.breadcrumb')
        @slot('title')
            System Config
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
                            <h6 class="m-0">System Config</h6>
                        </div>
                        <div class="col-auto">
                            @component('rcms::components.modals.add')
                                <div class="form-group">
                                    <label for="name">Key Name</label>
                                    <input class="form-control" type="text" name="key_name" placeholder="Ex: title_value"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Field Name</label>
                                    <input class="form-control" type="text" name="field_name" placeholder="Ex: Title"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Type</label>
                                    <select class="form-control" name="type">
                                        <option value="1">Text</option>
                                        <option value="2">Image</option>
                                    </select>
                                </div>
                            @endcomponent
                        </div>
                    </div>
                </div>
                <div class="rsolution-card-body">
                    @foreach ($data as $key => $item)
                        <div class="row mb-20">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">{{ $item->field_name }}</label>
                                </div>
                            </div>
                            <div class="col-4">
                                @if ($item->type == 1)
                                    @if ($item->value)
                                        {{-- Text --}}
                                        {{ $item->value }}
                                    @else
                                        None
                                    @endif

                                @elseif($item->type == 2)
                                    @if ($item->value)
                                        {{-- Text --}}
                                        <img src="{{ $item->value }}" alt="">
                                    @else
                                        None
                                    @endif
                                @endif
                            </div>
                            <div class="col-4">
                                <!-- Edit -->
                                @component('rcms::components.modals.update')
                                    @slot('id')
                                        {{ $item->id }}
                                    @endslot
                                    @if ($item->type == 1)
                                        {{-- Text --}}
                                        <div class="form-group">
                                            <label for="name">{{ $item->field_name }}</label>
                                            <input class="form-control" type="text" name="value" value="{{ $item->value }}"
                                                required>
                                        </div>
                                    @elseif ($item->type == 2)
                                        {{-- Image --}}
                                        <div class="form-group">
                                            <label for="name">{{ $item->field_name }}</label>
                                            <div class="input-group mb-10">
                                                <div id="holder" style="margin-top:15px;max-height:20rem;margin-bottom: 10px; width: 100%;">
                                                    @if ($item->value)
                                                        <img src="{{ $item->value }}" alt="">
                                                    @endif
                                                </div>
                                                <span class="input-group-btn">
                                                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color:#ffff; margin-right: 10px ">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                  </a>
                                                </span>
                                                <input id="thumbnail" class="form-control" type="text" name="value" value="{{ $item->value }}">
                                              </div>
                                        </div>
                                    @endif
                                @endcomponent
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@section('js')
@include('rtech::custom.js')
<script>
    $('#lfm').filemanager('image');
    $('[name="thumbnail"]').change(function() {
        previewImg(this);
    });
</script>
@endsection
@endsection
