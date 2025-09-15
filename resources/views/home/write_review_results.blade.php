@extends('layout')
@section('title', 'Find Product And Write Review')
@section('content')

<h3><i class="fa fa-comment"></i> Write a review</h3>

<form action="{{ url('products/search') }}" method="GET">

	<div class="form-group">
		<div class="input-group">
			<input type="text" name="name" class="form-control" placeholder="Product name" value="{{ Input::get('name') }}" required/> 
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
			</span>
		</div>
	</div>

</form>

@if($products->count()>0)


@foreach($products as $product)

<div class="clearfix" style="margin-bottom:15px">
	<div class="pull-left">
		
		@if($product->image_id != FALSE)
		<a href="{{ url('product/'.$product->id.'/'.$product->slug) }}"><img src="{{ url('images/'.$product->id.'/sm_'.$product->image->file_name) }}" class="img-home"></a>
		
		@else

		<div style="text-align:center; width:{{ $settings->product_sm_thumb_w }}px; height:{{ $settings->product_sm_thumb_h }}px" >
			<a href="{{ url('product/'.$product->id.'/'.$product->slug) }}"><i class="fa fa-photo fa-3x silver"></i></a>
		</div>

		@endif

	</div>

	<div style="overflow:auto">
		<div class="pull-left">
			<a href="{{ url('product/'.$product->id.'/'.$product->slug) }}">{{$product->brand->name}} | {{$product->name}}</a> @if($product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
			<div>
				@include('products/product_rating')
			</div>
			<div>
				<a class="text-muted" href="{{ url('products?category='.$product->category->slug.'&category_id='.$product->category_id) }}&name={{Input::get('name')}}&order={{Input::get('order')}}">{{ $product->category->name }}</a>
			</div>
		</div>                        
		
		@if(App\Http\Controllers\UserController::reviewedProduct($product->id))
		<div class="pull-right">
			<a href="{{ url('product-')}}{{ $product->id }}/write_review" class="text-muted">update review</a>
		</div>
		@else
		<div class="pull-right">
			<a href="{{ url('product-')}}{{ $product->id }}/write_review" class="btn btn-default">Write review</a>
		</div>
		@endif
	</div>

</div>
<div>
	<hr>
</div>
@endforeach



<div>
	{!! $products->appends(array('name' => Input::get('name') ))->render() !!}
</div>

@else

<div>
	<h3 class="text-muted">Product not found</h3>
</div>
@endif

@if($settings->users_add_products)
<div>
	If you cannot find it, <a href="{{ url('add_product?name=') }}{{ Input::get('name') }}">add new product</a>
</div>
@endif

@stop
