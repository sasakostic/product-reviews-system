@if($review->review->rating == 1) 
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
@endif
@if($review->review->rating == 2) 
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
@endif
@if($review->review->rating == 3)
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
@endif
@if($review->review->rating == 4) 
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-empty"></span>
@endif
@if($review->review->rating == 5) 
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
<span class="glyphicon glyphicon-star star-full"></span>
@endif