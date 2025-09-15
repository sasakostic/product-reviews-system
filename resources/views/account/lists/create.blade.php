@extends('layout')
@section('title', 'New Product list')
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
        <li class="active">Create</li>        
    </ol>
</div>

<form action="{{ url('account/lists') }}" method="POST" role="form">

    <div class="row">
        <div class="form-group col-md-4 @if ($errors->has('name')) has-error @endif">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ Input::old('name') }}" required autofocus>
            @if ($errors->has('name')) @foreach($errors->get('name') as $error)
            <p class="help-block">{{ $error }}</p>@endforeach @endif
        </div>
        <div class="form-group col-md-4">
            <label>Slug <span class="text-muted"><small>(automatically generated if left blank)</small></span>
            </label>
            <input type="text" name="slug" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label>Description <span class="text-muted"><small>(max 160 chars)</small></span>
        </label>
        <textarea name="description" class="form-control" rows="3" maxlength="160">{{ Input::old('description') }}</textarea>
    </div>

    @if($is_admin)
    <div class="form-group pull-right">
        <div class="checkbox">
            <input type="checkbox" name="featured" id="featured" class="styled" value="1" />
            <label for="featured">Featured</label> <small> <span class="text-muted">(will be displayed on homepage)</span></small>
        </div>
    </div>
    @endif
    
    <div class="form-group">
        <div class="radio radio-inline">
            <input type="radio" name="public" id="public" value="1" checked>
            <label for="public">
                Public
            </label>
        </div>
        <div class="radio radio-inline">
          <input type="radio" name="public" id="private" value="0">
          <label for="private">
            Private
        </label>
    </div>
</div>

<div class="form-group">
    {{ csrf_field() }}
    <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
    <button type="submit" name="save" value="save_and_new" class="btn btn-default">Save & New</button>
</div>

</form>

</div>
@stop