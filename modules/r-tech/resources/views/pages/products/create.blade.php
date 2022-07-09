@extends('rcms::layout.index')
@section('content')

    @component('rcms::components.breadcrumb')
        @slot('title')
            Create Product
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
                    <form id="form-create" action="{{ route('rcms.product.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" value="{{old('name')}}"
                                maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="name">Label</label>
                            <input class="form-control" type="text" name="label" value="{{old('label')}}"
                                maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="name">Link</label>
                            <input class="form-control" type="text" name="link" value="{{old('link')}}" >
                        </div>

                        <div class="form-group">
                            <label for="name">Logo Product</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="holderLogo" style="margin-top:15px;max-height:20rem;margin-bottom: 10px">
                                    @if (!!old('logo'))
                                        <img src="{{old('logo')}}">
                                    @endif
                                </div>
                                <div class="input-group mb-10">
                                    <span class="input-group-btn">
                                        <a id="lfmLogo" data-input="thumbnailLogo" data-preview="holderLogo" class="btn btn-primary"
                                            style="color:#ffff; margin-right: 10px ">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnailLogo" class="form-control" type="text" name="logo" value="{{old('logo')}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Thumbnail</label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div id="holder" style="margin-top:15px;max-height:20rem;margin-bottom: 10px">
                                    @if (!!old('images'))
                                        <img src="{{old('images')}}" height="">
                                    @endif
                                </div>
                                <div class="input-group mb-10">
                                    <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary"
                                            style="color:#ffff; margin-right: 10px ">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="images" value="{{old('images')}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Description</label>
                            <input class="form-control" type="text" value="{{old('description')}}" name="description">
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Display Order</label>
                                    <input class="form-control" type="number" min=0 value="{{old('display_order')}}" name="display_order">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary float-right" id="btn-submit">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<style>
    #holder img{
        width: 50%;
    }
</style>
@section('js')
    @include('rtech::custom.js')
    <script>
        $('[name="name"]').keyup(function() {
            let slug = ChangeToSlug($(this).val())
            $('[name="slug"]').attr('value', slug)
        })
        $('#lfm').filemanager('image');
        $('#lfmLogo').filemanager('image_logo');
        $('[name="images"]').change(function() {
            previewImg(this);
        });
    </script>
@endsection
@endsection
