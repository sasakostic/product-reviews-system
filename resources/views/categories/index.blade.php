@extends('layout')
@section('title', 'All Categories')
@section('content')

@include('alerts')

<div>
    {!! $widgets['categories-top'] !!}
</div>

<h3>{{ $categories->Total() }} categories</h3>

<div class="col-md-8 col-lg-8 col-sm-8">
<div>
    @foreach($alphabet as $letter)
    
    @if(in_array($letter, $letters)) <a href="{{ url('categories/?letter='.$letter)}}" @if(Input::get('letter') == $letter) style="font-weight:bold" @endif>{{ $letter }}</a>
    
    @else
    
    <span class="text-muted">{{ $letter }}</span>

    @endif
    @endforeach

    @if($starting_nonalpha_cnt > 0) 
    <a href="{{ url('categories?letter=other')}}" 
    @if(Input::get('letter') == $letter) style="font-weight:bold" @endif>#</a>

    @else

    <span class="text-muted">#</span>

    @endif        
</div>

@if($categories->isEmpty())

<div style="text-align:center">
    <h3>No categories</h3>
</div>

@else

@if($latest_added)  

@endif

@foreach($categories as $category)

<div style="margin-bottom:10px; margin-top:10px" class="item-name">
    <a href="{{ url('products?category='.$category->slug.'&category_id='.$category->id) }}">{{ $category->name }}</a> <span class="text-muted"><small>{{ $category->reviews }} reviews {{ $category->products }} products</small></span>
</div>

@endforeach

@if(Input::has('letter'))

<div>
    {!! $categories->appends(array('letter' => Input::get('letter')))->setPath('custom/url')->render() !!}
</div>

@else

<div>
    {!! $categories->render() !!}
</div>

@endif

@endif

</div>

<div class="visible-xs clearfix"></div>

<div class="col-md-4 col-lg-4 col-sm-4">
    {!! $widgets['categories-top-right'] !!} 
</div>    


<div class="clearfix"></div>
<div>
    {!! $widgets['categories-bottom'] !!}
</div>        

@stop