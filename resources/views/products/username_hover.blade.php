class="text-muted profile" data-toggle="popover" title="{{$review->user->username}}" data-placement="top" 
data-content="
@if($review->user->reviews->count()>0)
<div>
	{{$review->user->reviews->count()}} reviews
</div>
@endif
@if($review->user->images->count() > 0)
<div>
	{{$review->user->images->count()}} images
</div>
@endif
<div>
	<small>Joined {{date($settings->date_format,strtotime($review->user->created_at))}}</small>
</div>"