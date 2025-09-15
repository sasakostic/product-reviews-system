@extends('admin/layout')
@section('content')

<h2>Search resutls for "{{ $search_terms }}"</h2>

<div class="pull-right">
	<a href="{{ url('admin/pages/create') }}" class="btn btn-default">New Page</a>
</div>

@if($pages->isEmpty())

<div style="text-align:center">
	<h3 class="text-muted">Not found</h3>

</div>

@else

@include('admin/pages/table')

@endif

@stop