class="text-muted profile" data-toggle="popover" title="{{$review->user->username}}" data-placement="top" 
data-content="
<div>
	{{$review->user->reviews->count()}} reviews
</div>
<div>
	<small>Joined {{date($settings->date_format,strtotime($review->user->created_at))}}</small>
</div>"