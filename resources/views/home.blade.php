@extends('layout')
@section('title', $settings->site_description)
@section('content')

@include('alerts')

<div>
    {!! $widgets['home-top'] !!} 
</div>

@if(!$featured_categories->isEmpty() )
<div>

    <h3>Featured categories</h3>

    @foreach($featured_categories as $category)
    <span style="margin-bottom:10px; margin-top:10px" class="item-name">
        <a href="{{ url('products?brand='.$category->slug.'&category_id='.$category->id) }}">{{ $category->name }}</a>
    </span>
    &nbsp;&nbsp;
    @endforeach
    
</div>
@endif

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
    <div class="pull-right">
        <a href="{{ url('products/featured-lists') }}">more featured product lists</a>
    </div>

</div>
@endif

<div class="clearfix"></div>

<div class="row">
    <div class="col-lg-6 col-md-6">

        <div>
            {!! $widgets['home-top-right'] !!} 
        </div>
        
        @if(!$reviews->isEmpty() )

        <h3>Latest reviews</h3>

        @foreach($reviews as $review)
        <div class="clearfix">

            <div class="pull-left">
                <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}"><img src="@if($review->product->image_id != FALSE){{ url('images/'.$review->product->id.'/sm_'.$review->product->image->file_name) }}@else{{ url('images/no_image.png') }}@endif" class="img-home" style="width: {{ $settings->product_sm_thumb_w }}px"></a>
            </div>


            <div class="clearfix" style="overflow:auto">
                <div style="overflow:auto">
                    <div class="item-name pull-left">
                        <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}?review={{ $review->id }}">{{$review->product->brand->name}} {{ $review->product->name }}</a>
                    </div>

                    <div class="pull-right hidden-xs">
                        @include('reviews/rating')
                    </div>
                    <div class="pull-left visible-xs">
                        @include('reviews/rating')
                    </div>
                </div>

                <div id="preview_{{$review->id}}" class="text-muted item-name">
                    <p style="overflow: hidden;">
                        {!! nl2br(substr($review->text, 0, 120)) !!}@if(strlen($review->text)>120)...@endif
                    </p>
                </div>
            </div>

        </div>
        @endforeach       

        <div class="pull-right">
            <a href="{{ url('reviews') }}">more recent reviews</a>
        </div>    

        @endif

    </div>
    
    <div class="col-lg-6 col-md-6">

        <div>
            {!! $widgets['home-top-right'] !!} 
        </div>
        
        @if(!$featured_reviews->isEmpty())

        <h3>Latest featured reviews</h3>

        @foreach($featured_reviews as $review)
        <div class="clearfix">

            <div class="pull-left">
                <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}"><img src="@if($review->product->image_id != FALSE){{ url('images/'.$review->product->id.'/sm_'.$review->product->image->file_name) }}@else{{ url('images/no_image.png') }}@endif" class="img-home" style="width: {{ $settings->product_sm_thumb_w }}px"></a>
            </div>


            <div class="clearfix" style="overflow:auto">
                <div style="overflow:auto">
                    <div class="item-name pull-left">
                        <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}?review={{ $review->id }}">{{$review->product->brand->name}} {{ $review->product->name }}</a>
                    </div>

                    <div class="pull-right hidden-xs">
                        @include('reviews/rating')
                    </div>
                    <div class="pull-left visible-xs">
                        @include('reviews/rating')
                    </div>
                </div>

                <div id="preview_{{$review->id}}" class="text-muted item-name">
                    <p style="overflow: hidden;">
                        {!! nl2br(substr($review->text, 0, 120)) !!}@if(strlen($review->text)>120)...@endif
                    </p>
                </div>
            </div>

        </div>
        @endforeach       

        <div class="pull-right">
            <a href="{{ url('reviews?featured=1') }}">more recently featured reviews</a>
        </div>    
        @endif
    </div>  

</div>

<div class="clearfix"></div>

@if(!$images->isEmpty() )

<div>
 <h3>Latest images</h3>
 @foreach($images as $image)
 <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
    <a href="{{ url('product/'.$image->product->id)}}/{{ $image->product->slug }}">
        <img src="{{ url('images/'.$image->product->id.'/sm_'.$image->file_name) }}" >
    </a>
</div>
@endforeach
</div>

@endif

@if($reviews->isEmpty())
<div style="text-align: center;">
    <h3 class="text-muted">No reviews found</h3>
</div>
@endif

<div class="visible-xs clearfix"></div>

<div>
    {!! $widgets['home-bottom'] !!} 
</div>

@stop