@extends('rcms::layout.index')
@section('content')
    @component('rcms::components.breadcrumb')
        @slot('title')
            Edit Blog
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
                    <form id="form-create" action="{{ route('rcms.post.update', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input class="form-control" type="text" name="name" value="{{ $data->name }}"
                                maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="name">Slug</label>
                            <input class="form-control" type="text" name="slug" placeholder=""
                                value="{{ $data->slug }}">
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
                            <label for="name">Meta Description</label>
                            <input class="form-control" type="text" value="{{ $data->meta_desc }}" name="meta_desc">
                        </div>
                        <div class="form-group">
                            <label for="name">Tag</label>
                            <input class="form-control" type="text" name="tag" value="{{ $data->tag }}"
                                data-role="tagsinput">
                        </div>
                        <div class="form-group">
                            <label for="name">Content</label>
                            <textarea id="editor" name="content">{{ $data->content }}</textarea>
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary float-right">Update</button>
                        <button type="reset" class="btn btn-danger float-right mr-2">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .bootstrap-tagsinput .badge {
            margin: 2px 2px !important;
        }

        .bootstrap-tagsinput {
            min-height: 40px;
        }
    </style>
@section('js')
    @include('rtech::custom.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap4-tagsinput@4.1.3/tagsinput.min.js"></script>
    <script>
        $('[name="name"]').keyup(function() {
            let slug = ChangeToSlug($(this).val())
            $('[name="slug"]').attr('value', slug)
        })
        $('#lfm').filemanager('image');
        $('[name="thumbnail"]').change(function() {
            previewImg(this);
        });
        tinymce.init(editor_config);
    </script>
@endsection
@endsection
