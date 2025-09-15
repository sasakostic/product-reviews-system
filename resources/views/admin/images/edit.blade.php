@extends('admin/layout')
@section('title', 'Edit Image')
@section('content')

@include('alerts')

<div class="row">
	<ol class="breadcrumb">
		<li><a href="{{ url('admin/images') }}">Images</a></li>
		<li class="active">Edit</li>        
	</ol>
</div>

<div class="form-group">
	<img class="img-home" src="{{ url('images/'.$image->product->id.'/sm_'.$image->file_name) }}">
</div>

<form action="{{ url('admin/images') }}/{{ $image->id }}" method="POST">
	<div class="form-group">
		<input type="text" name="description" class="form-control" value="{{ $image->description }}" autofocus>
	</div>
	<div class="form-group">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		<button type="submit" class="btn btn-primary">Update</button>
		<div class="pull-right">
			<a href="{{ url('admin/images/delete/'.$image->id) }}" onClick="return confirm('Confirm deletion')" class="btn btn-default">Delete</a>
		</div>
	</div>
	
</form>   


@stop