@if($top_product->rating == 0)
<span title="{{ $top_product->rating }}">
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($top_product->rating) == 1)
<span title="{{ $top_product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($top_product->rating) == 2)
<span title="{{ $top_product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($top_product->rating) == 3)
<span title="{{ $top_product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($top_product->rating) == 4)
<span title="{{ $top_product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($top_product->rating) == 5)
<span title="{{ $top_product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
</span>
@endif

<span class="text-muted">{{ $top_product->reviews_count }} reviews</span>