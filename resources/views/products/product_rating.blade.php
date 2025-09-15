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
<span title="{{ $product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 2)
<span title="{{ $product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 3)
<span title="{{ $product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 4)
<span title="{{ $product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
</span>
@endif
@if(round($product->rating) == 5)
<span class="text-muted" title="{{ $product->rating }}">
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>	
</span>
@endif

@if($product->reviews_count > 0) 
<span class="text-muted"><small> {{ $product->reviews_count }} reviews</small></span>
@else
<span class="text-muted hidden-xs"><small>not reviewed</small></span>
@endif