@if($favorited_review->review->rating == 1)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($favorited_review->review->rating == 2)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($favorited_review->review->rating == 3)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($favorited_review->review->rating == 4)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star silver"></span>
@endif
@if($favorited_review->review->rating == 5)
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
	<span class="glyphicon glyphicon-star star-full"></span>
@endif