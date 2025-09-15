@extends('admin/layout')
@section('title', 'New Page')
@section('content')

@include('alerts')

<script src="{{ url('assets/libs/ckeditor/ckeditor.js') }}"></script>

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin/pages') }}">Pages</a></li>
    <li class="active">add</li>        
</ol>
</div>

<form action="{{ url('admin/pages') }}" method="POST" role="form">

  <div class="form-group @if ($errors->has('title')) has-error @endif">
    <label>Title</label>
    <input type="text" name="title" class="form-control" value="{{ Input::old('title') }}" required autofocus>
    @if ($errors->has('title')) @foreach($errors->get('title') as $error)
            <p class="help-block">{{ $error }}</p>@endforeach @endif
  </div>

  <div class="form-group  @if ($errors->has('slug')) has-error @endif">
    <label>Slug </label> <span class="text-muted"><small>(automatically generated if left blank)</small></span> 
    <input type="text" name="slug" class="form-control" value="{{ Input::old('slug') }}" autofocus>
    @if ($errors->has('slug')) @foreach($errors->get('slug') as $error)
            <p class="help-block">{{ $error }}</p>@endforeach @endif
  </div>

  <div class="form-group @if ($errors->has('content')) has-error @endif">
    <label>Content</label>
    <textarea name="content" class="form-control ckeditor" rows="10">{{ Input::old('content') }}</textarea>
  </div>
  
  <div class="form-group">
    {{ csrf_field() }}
    <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
    <button type="submit" name="save" value="save_and_new" class="btn btn-default">Save & New</button>
  </div>
  
</form>
@stop