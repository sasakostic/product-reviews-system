<script src="{{ url('assets/js/read_more.js') }}"></script>
<!-- HTML to write -->

<script type="text/javascript" src="{{ url('assets/js/username_hover.js') }}"></script>

@foreach($reviews as $review)
<div style="margin-top:30px">

  @if(!empty($review->title) && $settings->review_title)
  <div style="margin-top:10px; text-align:justify; word-wrap:break-word;">
    <label>{{ $review->title }}</label>
  </div>
  @endif
  <div>
    <div>
      @include('reviews/rating')
    </div>
    <div class="pull-right text-muted item-name">
      <span class="text-muted">
        <small>
         <a href="{{ url('user/'.$review->user->id.'/'.$review->user->username) }}" @include('products/username_hover') ><b>{{ $review->user->username }}</b></a> on <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug.'?review='.$review->id) }}" class="text-muted">{{ date($settings->date_format,strtotime($review->created_at)) }}</a>
       </small>
     </span>                    
   </div>
 </div>    

 @if($settings->review_helpful)

 @if($review->helpful_yes <> 0 || $review->helpful_no <> 0)
 <div class="text-muted">
  <small>
    {{ $review->helpful_yes }} of {{ $review->helpful_yes + $review->helpful_no }} people found this review helpful
  </small>
</div>
@endif

@endif

@if(!empty($review->pros) && $settings->review_pros_cons)
<div style="margin-top:10px; text-align:justify; word-wrap:break-word;">
  <span class="green">Pros:</span><span> {{ $review->pros }}</span>
</div>
@endif

@if(!empty($review->cons) && $settings->review_pros_cons)
<div style="margin-top:10px; text-align:justify; word-wrap:break-word;">
  <span class="red">Cons:</span><span> {{ $review->cons }}</span>
</div>
@endif

<div style="margin-top:10px; word-wrap:break-word;">
  <div id="preview_{{$review->id}}">
    {!! nl2br(substr($review->text, 0, $settings->review_preview_len)) !!}@if(strlen($review->text)>$settings->review_preview_len)... <a href="javascript:read_more({{$review->id}})">read more</a>@else @if(!Auth::guest() && Auth::user()->admin == 1) <a href="{{url('admin/reviews')}}/{{ $review->id }}/edit"><i class="fa fa-edit"></i></a>@endif 
    @if($review->updated_at <> $review->created_at)
    <div class="text-muted">
      <small>Updated: {{ date($settings->date_format,strtotime($review->updated_at)) }}</small>
    </div>
    @endif
    @endif    
  </div>

  @if(strlen($review->text)>$settings->review_preview_len)
  <div id="whole_{{$review->id}}" style="display:none">
    {!! nl2br($review->text) !!}@if(!Auth::guest() && Auth::user()->admin == 1) <a href="{{url('admin/reviews')}}/{{ $review->id }}/edit"><i class="fa fa-edit"></i></a>@endif

    @if($review->updated_at <> $review->created_at)
    <div class="text-muted">
      <small>Updated: {{ date($settings->date_format,strtotime($review->updated_at)) }}</small>
    </div>
    @endif

  </div>
  @endif
</div>

@if($settings->review_favorite || $settings->review_helpful || $settings->review_report)
<div style="margin-top:10px">

 @if($settings->review_helpful)
 <span class="pull-left text-muted" id="helpful_review_{{ $review->id }}" style="min-width:153px">
  <span id="helpful_review_buttons_{{ $review->id }}">
    <small>Helpful review?</small>

    <a href="javascript:helpful_review('{{ $review->id }}','1')" class="btn btn-default btn-xs">Yes</a> <a href="javascript:helpful_review('{{ $review->id }}','0')" class="btn btn-default btn-xs">No</a>
  </span>
  <small>
    <span class="text-muted" style="min-width:153px" id="helpful_review_info_{{ $review->id }}"></span>
  </small>
</span>
@endif

@if($settings->review_report)
<span style="margin-left:7px">
  <a href="javascript:report_review({{ $review->id }})" id="report_icon_{{ $review->id }}"><small><span class="text-muted" title="Flag as inapropriate">Report</span></small></a>
  <span id="report_info_{{ $review->id }}" class="report_info text-muted"></span>
</span>
@endif

@if($settings->review_favorite)
<span id="favorited_review_{{ $review->id }}" class="pull-right">
  <a href="javascript:favorite_review({{ $review->id }})" >
  <i style="@if(!App\Http\Controllers\ReviewsController::isFavorited($review->id)) display:none @endif" id="unfavorited_icon_{{ $review->id }}" class="fa fa-star silver"></i>
  <i style="@if(App\Http\Controllers\ReviewsController::isFavorited($review->id)) display:none @endif" id="favorited_icon_{{ $review->id }}" class="fa fa-star-o silver"></i></a>  
  
</span>

@endif

</div>
@endif

</div>

@if($reviews_count > 1 && Input::has('review'))
<div>
  <a href="{{ url('product/'.$product->id.'/'.$review->product->slug) }}">Read other {{ $reviews_count - 1 }} reviews of {{$product->name}}</a>
</div>
@endif

@endforeach