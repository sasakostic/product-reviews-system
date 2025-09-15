@extends('layout')
@section('content')

@include('alerts')

<div class="col-lg-2 col-md-2 col-sm-2">
	@include('account/sidebar')
</div>
<div class="col-lg-10 col-md-10 col-sm-10">

	<ol class="breadcrumb">
		<li><a href="{{ url('account') }}">Account</a></li>
		<li><a href="{{ url('account/images') }}">Images</a></li>
		<li class="active">edit</li>        
	</ol>

	<div class="form-group">
		<img src="{{ url('images/'.$image->product->id.'/sm_'.$image->file_name) }}" class="img-home">
	</div>

	<form action="{{ url('account/images') }}/{{ $image->id }}" method="POST">
		<div class="form-group">
			<input type="text" name="description" class="form-control" value="{{ $image->description }}" autofocus>
		</div>

		<div class="form-group">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<button type="submit" class="btn btn-primary">Update</button>
		</div>
		

	</form>   

</div>
@stop