@extends('layout')
@section('content')
<div>
	<h2>{{ $page->title }}</h2>
</div>
<div>
	{!! nl2br($page->content) !!}
</div>
@stop