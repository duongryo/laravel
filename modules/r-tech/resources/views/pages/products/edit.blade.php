@extends('rcms::layout.index')
@section('content')
    @component('rcms::components.breadcrumb')
        @slot('title')
            Edit Product
        @endslot
    @endcomponent

    <div class="row ">
        <div class="col-10 col-xxl-8 mx-auto">
            <div class=" rsolution-card-shadow">
                <div class="rsolution-card-header border-bottom">
                    <div class="row d-flex align-items-center">
                        <div class="col">
                            <span class="title">INFORMATION</span>
                        </div>
                    </div>
                </div>
                <div class="rsolution-card-body">
                    <form id="form-create" action="{{ route('rcms.product.update', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" value="{{ $data->name }}"
                                maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="name">Label</label>
                            <input class="form-control" type="text" name="label" value="{{ $data->label }}"
                                maxlength="255">
                        </div>

                        <div class="form-group">
                          <label for="name">Link</label>
                          <input class="form-control" type="text" name="link" value="{{ $data->link }}">
                      </div>

                        <div class="form-group">
                            <label for="name">Logo Product</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="holderLogo" style="margin-top:15px;max-height:20rem;margin-bottom: 10px">
                                    @if ($data->logo)
                                        <img src="{{ env('APP_URL') . $data->logo }}" alt="">
                                    @endif
                                </div>
                                <div class="input-group mb-10">
                                    <span class="input-group-btn">
                                        <a id="lfmLogo" data-input="thumbnailLogo" data-preview="holderLogo"
                                            class="btn btn-primary" style="color:#ffff; margin-right: 10px ">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnailLogo" class="form-control" type="text" name="logo"
                                        value="{{ env('APP_URL') . $data->logo }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Thumbnail</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-10">
                                    <div id="holder" style="margin-top:15px;margin-bottom: 10px">
                                        @if ($data->images)
                                            <img src="{{ env('APP_URL') . $data->images }}" alt="">
                                        @endif
                                    </div>
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-primary" style="color:#ffff; margin-right: 10px ">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="images"
                                        value="{{ env('APP_URL') . $data->images }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Description</label>
                            <input class="form-control" type="text" value="{{ $data->description }}"
                                name="description">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Display Order</label>
                                    <input class="form-control" type="number" min=0 value="{{ $data->display_order }}" name="display_order">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary float-right">Update</button>
                        <button type="reset" class="btn btn-danger float-right mr-2">Reset</button>
                    </form>
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
        $('#lfm').filemanager('image');
        $('#lfmLogo').filemanager('image_logo');
        $('[name="thumbnail"]').change(function() {
            previewImg(this);
        });
    </script>
@endsection
@endsection
