@if(round($product->rating) == 0)
<span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span> 
@endif
@if(round($product->rating) == 1)
<span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 2)
<span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 3)
<span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 4)
<span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 5)
<span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>	
</span>
@endif

<span class="text-muted">{{ $product->reviews_count }} reviews</span>