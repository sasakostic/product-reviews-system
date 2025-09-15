@extends('admin/layout')
@section('content')

@include('alerts')

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Admin</a></li>
    <li><a href="{{ url('admin/widgets') }}">Widgets</a></li>   
  <li class="active">{{ $widget->slug }} preview</li>        
</ol>
</div>


<div style="text-align:center">
	{!! $widget->code !!}
</div>
@stop
