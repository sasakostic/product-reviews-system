@extends('admin/layout')
@section('title', 'New Product')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<script src="{{ url('assets/libs/ckeditor/ckeditor.js') }}"></script>

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Admin</a></li>
    <li><a href="{{ url('admin/products') }}">Products</a></li>
    <li class="active">Add</li>        
  </ol>
</div>

<form action="{{ url('admin/products') }}" method="POST" enctype='multipart/form-data' role="form">

  <div class="row">

    <div class="form-group col-md-6  @if ($errors->has('name')) has-error @endif">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ Input::old('name') }}" required autofocus>
      @if ($errors->has('name')) @foreach($errors->get('name') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
    </div>
    
    <div class="select-box form-group col-md-3">
      <label>Category</label>
      <select name="category_id" class="form-control selectpicker" data-live-search="true">
        @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </select>
    </div>
    
    <div class="select-box form-group col-md-3">
      <label>Brand</label>
      <select name="brand_id" class="form-control selectpicker" data-live-search="true">
        @foreach($brands as $brand)
        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="row">
    <div class="form-group col-md-6">
      <label>Slug <span class="text-muted"><small>(Automatically generated if left blank)</small></span></label>
      <input type="text" name="slug" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label>Add images<input type="file" name="images[]" multiple /></label>
  </div>

  <div class="row">
    <div class="form-group col-md-12">
      <label>Description</label>
      <textarea name="description" class="form-control ckeditor" rows="7">{{ Input::old('description')}}</textarea>
    </div>
  </div>
  
  <div class="form-group">
    <label>Affiliate code (html/js)</label>
    <textarea name="affiliate_code" class="form-control" rows="4">{{ Input::old('affiliate_code')}}</textarea>
  </div>

  <div class="form-group">
    <div class="radio radio-inline">
      <input type="radio" name="active" id="active" value="1" checked>
      <label for="active">
        Active
      </label>
    </div>
    <div class="radio radio-inline">
      <input type="radio" name="active" id="inactive" value="0">
      <label for="inactive">
        Inactive
      </label>
    </div>
  </div>

  <div class="form-group">
    <div class="checkbox">
    <input type="checkbox" name="discontinued" id="discontinued" class="styled" value="1" />
     <label for="discontinued">Discontinued</label>
   </div>
 </div>

 <div class="form-group">
  {{ csrf_field() }}
  <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
  <button type="submit" name="save" value="save_and_new" class="btn btn-default">Save & New</button>
</div>

</form>
@stop