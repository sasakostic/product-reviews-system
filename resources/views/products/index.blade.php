@extends('layout')
@section('title', 'All Products')
@section('content')

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

@if(isset($menu_highlight))
<script type="text/javascript">
    $(function(){
        $('#{{ $button_highlight }}').addClass('active');
    });//document ready
</script>
@endif

<div>
    {!! $widgets['products-top'] !!}
</div>

<div class="container">
    <ol class="breadcrumb">
        <li><a href="{{ url('products') }}">All products</a></li>
        
        @if(Input::has('category_id') && Input::get('category_id')<>0)
        @if(Input::has('brand_id') && Input::get('brand_id')<>0)
        <li><a href="{{ url('products?category_id=') }}{{ Input::get('category_id') }}">{{ $category_name }}</a></li>
        @else
        <li class="active">{{ $category_name }}</li>
        @endif
        @endif
        
        @if(Input::has('brand_id') && Input::get('brand_id')<>0)
        @if(Input::get('category_id')==0)
        <li class="active">All categories</li>
        @endif
        <li class="active">{{ $brand_name }}</li>
        @endif

    </ol>
</div>


<div class="col-lg-3 col-md-3 col-sm-3">        

    <form  method="GET" action="{{ url('products?') }}">

        @if(Input::has('order'))
        <input type="hidden" name="order" value="{{ Input::get('order') }}" />
        @endif
        
        <div class="select-box form-group">
            <label class="text-muted">Category</label>
            {!! Form::select('category_id', $categories, Input::Get('category_id'), array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) !!}
        </div>
        
        <div class="form-group select-box">
            <label class="text-muted">Brand</label>
            {!! Form::select('brand_id', $brands, Input::Get('brand_id'), array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) !!}
        </div>

        <div class="form-group">
            <label class="text-muted">Product name</label>
            <input type="text" name="name" class="form-control" value="{{ Input::get('name') }}">
        </div>

        <div class="form-group">
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i> Search</button>
        </div>

    </form>        

</div>

<div class="col-sm-8 col-md-8 col-lg-8" >

    <div style="margin-bottom:15px">
        <ul class="nav nav-pills">
            <li role="presentation" id="button_newest"><a href="{{ url('products?category_id=') }}{{Input::get('category_id')}}&brand_id={{Input::get('brand_id')}}&name={{Input::get('name')}}">Newest</a></li>
            <li role="presentation" id="button_rating"><a href="{{ url('products?order=rating&category_id=') }}{{Input::get('category_id')}}&brand_id={{Input::get('brand_id')}}&name={{Input::get('name')}}">Top rated</a></li>
            <li role="presentation" id="button_reviews"><a href="{{ url('products?order=reviews&category_id=') }}{{Input::get('category_id')}}&brand_id={{Input::get('brand_id')}}&name={{Input::get('name')}}">Most reviewed</a></li>
        </ul>
    </div>
    
    @if($products->Total() > 0)

    @foreach($products as $product)
    <div class="clearfix" style="margin-bottom:15px">
        <div class="pull-left">
            <a href="{{ url('product/'.$product->id.'/'.$product->slug) }}"><img src="@if($product->image_id != FALSE){{ url('images/'.$product->id.'/sm_'.$product->image->file_name) }}@else{{ url('images/no_image.png') }}@endif" class="img-home" style="width: {{ $settings->product_sm_thumb_w }}px"></a>
        </div>

        <div class="clearfix" style="overflow:auto">
            <div class="item-name text-muted">
                <a class="text-muted" href="{{ url('products?category='.$product->category->slug.'&brand='.$product->brand->slug.'&brand_id='.$product->brand_id) }}&category_id={{Input::get('category_id')}}&name={{Input::get('name')}}&order={{Input::get('order')}}">{{$product->brand->name}}</a>
                <a class="hidden-xs" href="{{ url('product/'.$product->id.'/'.$product->slug) }}">{{$product->name}}</a> <span class="hidden-xs">@if($product->discontinued == 1)(discontinued)@endif</span>
                <div class="visible-xs">
                    <a href="{{ url('product/'.$product->id.'/'.$product->slug) }}"><b>{{$product->name}}</b></a> @if($product->discontinued == 1)(discontinued)@endif
                </div>
            </div>
            <div>
                @include('products/product_rating')
            </div>                           
            <div>
                <a class="text-muted" href="{{ url('products?category='.$product->category->slug.'&category_id='.$product->category_id) }}&name={{Input::get('name')}}&order={{Input::get('order')}}">{{ $product->category->name }}</a>
            </div>
        </div>
    </div>   
    @endforeach    
    
    @endif

    <div>
        {!! $products->appends(array('order' => Input::Get('order'),'category_id' => Input::Get('category_id'),'brand_id' => Input::Get('brand_id'), 'name' => Input::Get('name'),))->render() !!}
    </div>

</div>

<div class="clearfix"></div>
<div>
    {!! $widgets['products-bottom'] !!}
</div>

@stop