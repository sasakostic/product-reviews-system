@extends('layout')
@section('title', 'Edit Product List')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div class="col-lg-2 col-md-2 col-sm-2">
  @include('account/sidebar')
</div>
<div class="col-lg-10 col-md-10 col-sm-10">

  <div class="row">
    <ol class="breadcrumb">
      <li><a href="{{ url('account') }}">Account</a></li>
      <li><a href="{{ url('account/lists') }}">Product lists</a></li>
      <li>
        <a href="{{ url('products?category='.$list->slug.'&category_id='.$list->id) }}" target="_blank">{{ $list->name }}</a>
      </li>
      <li class="active">edit</li>        
    </ol>
  </div>

  <form action="{{ url('account/lists') }}/{{ $list->id }}" method="POST" role="form">

    <div class="row">
      <div class="form-group col-md-4 @if ($errors->has('name')) has-error @endif">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $list->name }}" required autofocus>@if ($errors->has('name')) @foreach($errors->get('name') as $error)
        <p class="help-block">{{ $error }}</p>@endforeach @endif
      </div>
      <div class="form-group col-md-4">
        <label>Slug</label> <span class="text-muted"><small>(automatically generated if left blank)</small></span> 
        <input type="text" name="slug" class="form-control" value="{{ $list->slug }}">
      </div>
    </div>

    <div class="form-group">
      <label>Description <span class="text-muted"><small>(max 160 chars)</small></span>
      </label>
      <textarea name="description" class="form-control" rows="3" maxlength="160">{{ $list->description }}</textarea>
    </div>

    @if($is_admin)
    <div class="form-group pull-right">
      <div class="checkbox">
       <input type="checkbox" name="featured" id="featured" class="styled" value="1" @if($list->featured == 1) checked="checked" @endif />
       <label for="featured">Featured</label> <small> <span class="text-muted">(will be displayed on homepage)</span></small>
     </div>
   </div>
   @endif

   <div class="form-group">
    <div class="radio radio-inline">
      <input type="radio" name="public" id="public" value="1" @if($list->public == 1) checked="checked" @endif >
      <label for="public">
        Public
      </label>
    </div>
    <div class="radio radio-inline">
      <input type="radio" name="public" id="private" value="0" @if($list->public == 0) checked="checked" @endif >
      <label for="private">
        Private
      </label>
    </div>
  </div>

  <div class="form-group text-muted">
    <small>
      Created: {{ $list->created_at }} | Updated: {{ $list->updated_at }}
    </small>
  </div>

  <div class="form-group">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    <div class="pull-left">
      <button type="submit" name="update" value="update" class="btn btn-primary">Update</button>
      <button type="submit" name="update" value="update_and_new" class="btn btn-default">Update & New</button>
      <a href="{{ url('account/lists/create') }}" class="btn btn-default">New</a>  
    </div>

    
    @if($list->id

    <>1)
    <div class="pull-right">
      <a href="{{ url('account/lists/delete/'.$list->id.'/0') }}" onClick="return confirm('Confirm deletion')" class="btn btn-default" >Delete</a>
    </div>
    @endif
    
  </div>

</form>

</div>
@stop