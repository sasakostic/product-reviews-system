@extends('admin/layout')
@section('title', 'Manage Widgets')
@section('content')

@include('alerts')

<div class="row page-header">

	<div class="row">
		<ol class="breadcrumb">
			<li><a href="{{ url('admin') }}">Admin</a></li>
			<li class="active">Widgets</li>        
		</ol>
	</div>
	
</div>

@include('admin/widgets/table')

@stop