@extends('admin/layout')
@section('title', 'New Brand')
@section('content')

@include('alerts')

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin/brands') }}">Brands</a></li>
    <li class="active">Add</li>        
  </ol>
</div>

<form action="{{ url('admin/brands') }}" method="POST" role="form">

    <div class="row">
    
        <div class="form-group col-md-4 @if ($errors->has('name')) has-error @endif">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ Input::old('name') }}" required autofocus>
            @if ($errors->has('name')) @foreach($errors->get('name') as $error)
            <p class="help-block">{{ $error }}</p>@endforeach @endif
        </div>

        <div class="form-group col-md-4">
            <label>Slug</label> <label>Slug</label> <span class="text-muted"><small>(automatically generated if left blank)</small></span> 
            <input type="text" name="slug" class="form-control">
        </div>

    </div>

    <div class="form-group">
        <label>Meta description <span class="text-muted"><small>(max 160 chars)</small></span>
        </label>
        <textarea name="meta_description" class="form-control" rows="3" maxlength="160">{{ Input::old('meta_description') }}</textarea>
    </div>
    
    <div class="form-group">
        {{ csrf_field() }}
        <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
        <button type="submit" name="save" value="save_and_new" class="btn btn-default">Save & New</button>        
    </div>
    
</form>
@stop