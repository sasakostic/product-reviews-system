@if($product->reviews_count > 0)
<div>
    <h2><strong>{{ $product->rating }}</strong></h2>
</div>
@endif
@if($product_rating == 0)
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($product_rating == 1)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($product_rating == 2)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($product_rating == 3)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($product_rating == 4)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($product_rating == 5)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
@endif

@if($product->reviews_count > 0) 
&nbsp;<span class="text-muted">{{ $product->reviews_count }} reviews</span>
@else

@endif