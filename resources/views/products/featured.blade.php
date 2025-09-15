@extends('layout')
@section('title', 'Fetured Products')
@section('content')

@include('alerts')

@if(!$featured_product_lists->isEmpty() )

<div>

    <h3>Featured products</h3>

    <div class="row">

        @foreach($featured_product_lists as $product_list)
        <div class="col-md-6 col-lg-6 col-sm-6 clearfix">
            <div class="pull-left">
                <a href="{{ url('product/'.$product_list->id.'/'.$product_list->slug) }}"><img src="{{ url('images/no_image.png') }}" class="img-home" style="width: {{ $settings->product_sm_thumb_w }}px"></a>
            </div>

            <div style="overflow:auto">
                <div class="item-name">
                    <a href="{{ url('product/'.$product_list->id.'/'.$product_list->slug) }}">{{$product_list->name}}</a>
                </div>
                <div>
                    {!! substr($product_list->description, 0, 120) !!}
                </div>
            </div>
        </div>
        @endforeach    

    </div>
    <div>
        {!! $featured_product_lists->render() !!}
    </div>

</div>
@endif


@stop