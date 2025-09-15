@extends('admin/layout')
@section('title', 'Edit Category')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin/categories') }}">Categories</a></li>
    <li>
      <a href="{{ url('products?category='.$category->slug.'&category_id='.$category->id) }}" target="_blank">{{ $category->name }}</a>
    </li>
    <li class="active">edit</li>        
  </ol>
</div>

<form action="{{ url('admin/categories') }}/{{ $category->id }}" method="POST" role="form">

  <div class="row">
    <div class="form-group col-md-4 @if ($errors->has('name')) has-error @endif">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ $category->name }}" required autofocus>@if ($errors->has('name')) @foreach($errors->get('name') as $error)
      <p class="help-block">{{ $error }}</p>@endforeach @endif
    </div>
    <div class="form-group col-md-4">
      <label>Slug</label> <span class="text-muted"><small>(automatically generated if left blank)</small></span> 
      <input type="text" name="slug" class="form-control" value="{{ $category->slug }}">
    </div>
  </div>

  <div class="form-group">
    <label>Meta description <span class="text-muted"><small>(max 160 chars)</small></span>
    </label>
    <textarea name="meta_description" class="form-control" rows="3" maxlength="160">{{ $category->meta_description }}</textarea>
  </div>

  <div class="form-group">
    <div class="checkbox">
     <input type="checkbox" name="featured" id="featured" class="styled" value="1" @if($category->featured == 1) checked="checked" @endif />
     <label for="featured">Featured</label> <small> <span class="text-muted">(will be displayed on homepage)</span></small>
   </div>
 </div>

 <div class="text-muted form-group col-md-12 row">
   <small>{{ $category->products->count() }} products
     | {{ $category->getReviewsCount() }} reviews
   </small>
 </div>

 <div class="form-group text-muted">
  <small>
    Created: {{ $category->created_at }} | Updated: {{ $category->updated_at }}
  </small>
</div>

<div class="form-group">
  {{ csrf_field() }}
  <input type="hidden" name="_method" value="PUT">
  <div class="pull-left">
    <button type="submit" name="update" value="update" class="btn btn-primary">Update</button>
    <button type="submit" name="update" value="update_and_new" class="btn btn-default">Update & New</button>
    <a href="{{ url('admin/categories/create') }}" class="btn btn-default">New</a>  
  </div>

  
  @if($category->id

  <>1)
  <div class="pull-right">
    <a href="{{ url('admin/categories/delete/'.$category->id.'/0') }}" onClick="return confirm('Confirm deletion')" class="btn btn-default" >Delete</a>
  </div>
  @endif
  
</div>

</form>
@stop