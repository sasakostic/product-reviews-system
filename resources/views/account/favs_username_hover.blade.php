class="text-muted profile" data-toggle="popover" title="{{$favorited_review->review->user->username}}" data-placement="top" 
data-content="
<div>
{{$favorited_review->review->user->reviews->count()}} reviews
</div>
@if($favorited_review->review->user->images->count() > 0)
<div>
	{{$favorited_review->review->user->images->count()}} images
</div>
@endif
<div>
	<small>Joined {{date($settings->date_format,strtotime($favorited_review->review->user->created_at))}}</small>
</div>"