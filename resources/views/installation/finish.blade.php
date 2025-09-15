@extends('installation.home')
@section('installation_step')

@include('alerts')

<div class="col-md-12 col-lg-12">
	<h3 class="page-header">Installation successfully completed</h3>

	<a href="{{ URL::to('/admin') }}" class="btn btn-primary">Log In</a> to admin panel
</div>
@stop