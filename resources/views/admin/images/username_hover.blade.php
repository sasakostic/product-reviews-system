class="text-muted profile" data-toggle="popover" title="{{$image->user->username}}" data-placement="top" 
data-content="
<div>
	{{$image->user->reviews->count()}} reviews
</div>
@if($image->user->images->count() > 0)
<div>
	{{$image->user->images->count()}} images
</div>
@endif
@if($image->user->products->count() > 0)
<div>
	{{$image->user->products->count()}} products
</div>
@endif
<div>
	<small>Joined {{date($settings->date_format,strtotime($image->user->created_at))}}</small>
</div>"