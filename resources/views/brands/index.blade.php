@extends('layout')
@section('title', 'All Brands')
@section('content')

@include('alerts')

<div>
    {!! $widgets['brands-top'] !!}
</div>

<h3>{{ $brands->Total() }} Brands</h3>

<div class="col-md-8 col-sm-8 col-lg-8">
    <div>
        @foreach($alphabet as $letter)
        
        @if(in_array($letter, $letters)) <a href="{{ url('brands/?letter='.$letter)}}" @if(Input::get('letter') == $letter) style="font-weight:bold" @endif>{{ $letter }}</a>
        
        @else
        
        <span class="text-muted">{{ $letter }}</span>

        @endif
        @endforeach

        @if($starting_nonalpha_cnt > 0) 
        <a href="{{ url('brands?letter=other')}}" 
        @if(Input::get('letter') == $letter) style="font-weight:bold" @endif>#</a>

        @else

        <span class="text-muted">#</span>

        @endif        
    </div>
    @if($brands->isEmpty())

    <div style="text-align:center">
        <h3>No brands</h3>
    </div>

    @else

    @if($latest_added)  

    @endif

    @foreach($brands as $brand)

    <div style="margin-bottom:10px; margin-top:10px" class="item-name">
        <a href="{{ url('products?brand='.$brand->slug.'&brand_id='.$brand->id) }}">{{ $brand->name }}</a> <span class="text-muted"><small>{{ $brand->reviews }} reviews {{ $brand->products }} products</small></span>
    </div>

    @endforeach

    @if(Input::has('letter'))

    <div>
        {!! $brands->appends(array('letter' => Input::get('letter')))->setPath('custom/url')->render() !!}
    </div>

    @else

    <div>
        {!! $brands->render() !!}
    </div>

    @endif

    @endif

</div>

<div class="visible-xs clearfix"></div>

<div class="col-md-4 col-lg-4 col-sm-4">
    {!! $widgets['brands-top-right'] !!} 
</div>    


<div class="clearfix"></div>

<div>
    {!! $widgets['brands-bottom'] !!}
</div>        

@stop