@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') Edit Blog Categories @endslot
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
              <form id="form-create" action="{{route('rcms.category.update', $data->id)}}" method="post" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
              <div class="form-group">
                  <label for="name">Title</label>
                  <input class="form-control" type="text" name="name" value="{{ $data->name }}" maxlength="255">
              </div>
              <div class="form-group">
                  <label for="name">Slug</label>
                  <input class="form-control" type="text" name="slug" placeholder="" value="{{ $data->slug }}">
              </div>
              <button type="submit" id="submit" class="btn btn-primary float-right" >Update</button>
              <button type="reset"  class="btn btn-danger float-right mr-2" >Reset</button>
          </form>
          </div>
      </div>
  </div>
</div>
@section('js')
@include('rtech::custom.js')
<script>
  $('[name="name"]').keyup(function(){
    let slug = ChangeToSlug( $(this).val() )
    $('[name="slug"]').attr('value',slug)
  })
</script>
@endsection
@endsection