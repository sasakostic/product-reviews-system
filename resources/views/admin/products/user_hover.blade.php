class="text-muted profile" data-toggle="popover" title="{{$product->user->username}}" data-placement="top" 
data-content="
<div>
	{{$product->user->reviews->count()}} reviews
</div>
@if($product->user->images->count() > 0)
<div>
	{{$product->user->images->count()}} images
</div>
@endif
@if($product->user->products->count() > 0)
<div>
	{{$product->user->products->count()}} products
</div>
@endif
<div>
	<small>Joined {{date($settings->date_format,strtotime($product->user->created_at))}}</small>
</div>"