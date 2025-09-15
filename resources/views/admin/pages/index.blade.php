@extends('admin/layout')
@section('title', 'Manage Pages')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div class="page-header">    
	<h3>
		<i class="fa fa-file-text"></i> Pages
	</h3>    
</div>

<div class="form-group">	
	<a href="{{ url('admin/pages/create') }}" class="btn btn-default btn-xs pull-right">New page</a>	
</div>

@if($pages->isEmpty())
<div style="text-align:center">
	<h3 class="text-muted">No pages</h3>
</div>
@else
@include('admin/pages/table')
@endif
@stop