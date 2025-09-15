@extends('admin/layout')
@section('title', 'Edit Brand')
@section('content')

@include('alerts')

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin/brands') }}">Brands</a></li>
    <li>
      <a href="{{ url('products?brand='.$brand->slug.'&brand_id='.$brand->id) }}" target="_blank">{{ $brand->name }}</a>
  </li>
  <li class="active">edit</li>        
</ol>
</div>

<form action="{{ url('admin/brands') }}/{{ $brand->id }}" method="POST" role="form">

    <div class="row">

        <div class="form-group col-md-4 @if ($errors->has('name')) has-error @endif">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required autofocus>@if ($errors->has('name')) @foreach($errors->get('name') as $error)
            <p class="help-block">{{ $error }}</p>@endforeach @endif
        </div>

        <div class="form-group col-md-4">
            <label>Slug</label><label>Slug</label> <span class="text-muted"><small>(automatically generated if left blank)</small></span> 
            <input type="text" name="slug" class="form-control" value="{{ $brand->slug }}">
        </div>
        
    </div>

    <div class="form-group">
        <label>Meta description <span class="text-muted"><small>(max 160 chars)</small></span>
        </label>
        <textarea name="meta_description" class="form-control" rows="3" maxlength="160">{{ $brand->meta_description }}</textarea>
    </div>
    
    <div class="form-group text-muted">
        <small>
            {{ $brand->products->count() }} products | {{ $brand->getReviewsCount() }} reviews
        </small>
    </div>
    
    <div class="form-group text-muted">
        <small>
            Created: {{ date($settings->date_format,  strtotime($brand->created_at)) }} | Updated: {{ date($settings->date_format,  strtotime($brand->updated_at)) }}
        </small>
    </div>

    <div class="form-group">

        <div class="pull-left">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" name="update" value="update" class="btn btn-primary">Update</button>
            <button type="submit" name="update" value="update_and_new" class="btn btn-default">Update & New</button>
            <a href="{{ url('admin/brands/create') }}" class="btn btn-default">New</a>  
        </div>

        <div class="pull-right">
            @if($brand->id <>1)
            <a href="{{ url('admin/brands/delete/'.$brand->id.'/0') }}" onClick="return confirm('Confirm deletion')" class="btn btn-default" >Delete</a>
            @endif
        </div>
    </div>

</form>
@stop