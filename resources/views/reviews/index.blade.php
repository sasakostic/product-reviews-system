@extends('layout')
@section('title', 'All Reviews')
@section('content')

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

  @if($settings->review_helpful)
  <script type="text/javascript" src="{{ url('assets/js/helpful.js') }}"></script>
  @endif

  @if($settings->review_favorite)
  <script type="text/javascript" src="{{ url('assets/js/favorite.js') }}"></script>
  @endif

  @if($settings->review_report)
  <script type="text/javascript" src="{{ url('assets/js/report_review.js') }}"></script>
  @include('reviews/report_modal')
  @endif 

  <script src="{{ url('assets/js/read_more.js') }}"></script>

  <script type="text/javascript" src="{{ url('assets/js/username_hover.js') }}"></script>


  <div>
    {!! $widgets['reviews-top'] !!} 
  </div>

  <div class="col-md-8 col-lg-8">
   <div class="row">
     <form  method="GET" action="{{ url('reviews?') }}">
       <div class="form-group select-box col-sm-4 col-md-4 col-lg-4">
        <label class="text-muted">Category</label>
        {!! Form::select('category_id', $categories, Input::Get('category_id'), array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) !!}
      </div>
      <div class="form-group select-box col-sm-4 col-md-4 col-lg-4">
        <label class="text-muted">Brand</label>
        {!! Form::select('brand_id', $brands, Input::Get('brand_id'), array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) !!}
      </div>
      <div class="form-group col-sm-4 col-md-4 col-lg-4">
       <label class="text-muted">Review text</label>
       <div class="input-group">

        <input type="text" name="search_terms" class="form-control" value="{{ $search_terms }}">

        <span class="input-group-btn hidden-sm">
          <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </div>

    @if(Input::has('featured'))
    <input type="hidden" name="featured" value="1" />
    @endif
    @if(Input::has('user'))
    <input type="hidden" name="user" value="{{ Input::get('user') }}" />
    @endif  
  </form>
</div>

<div style="margin-bottom:15px">
  <ul class="nav nav-pills">
    <li @if(!Input::has('featured')) class="active" @endif  role="presentation" id="button_newest"><a href="{{ url('reviews?category_id=') }}{{Input::get('category_id')}}&brand_id={{Input::get('brand_id')}}&search_terms={{Input::get('search_terms')}}@if(Input::has('user'))&user={{Input::get('user')}}@endif">Newest</a></li>
    <li @if(Input::has('featured')) class="active" @endif role="presentation" id="button_featured"><a href="{{ url('reviews?featured=1&category_id=') }}{{Input::get('category_id')}}&brand_id={{Input::get('brand_id')}}&search_terms={{Input::get('search_terms')}}@if(Input::has('user'))&user={{Input::get('user')}}@endif">Featured</a></li>                
  </ul>
</div>

@if($reviews->isEmpty())
<div style="text-align:center">
  <h3>No reveiws found</h3>
</div>
@else

@foreach($reviews as $review)
<div class="review" style="margin-top:20px">

  <div class="item-name">    
    <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}?review={{$review->id}}">{{$review->product->category->name}} / {{$review->product->brand->name}} {{ $review->product->name }}</a> @if($review->featured_on != NULL) <span class="label white" style="background-color: silver" title="Featured review">featured</span>@endif @if($review->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
  </div>

  <div class="pull-right text-muted item-name">
   <small>
    <a href="{{ url('user/'.$review->user->id.'/'.$review->user->username) }}" @include('reviews/username_hover') ><b>{{ $review->user->username }}</b></a> on <span class="text-muted">{{ date($settings->date_format,strtotime($review->created_at)) }}</span>
  </small>  

</div>

<div>
 @include('reviews/rating')
</div>                       

@if($settings->review_helpful)
@if($review->helpful_yes <> 0 || $review->helpful_no <> 0)
<div class="text-muted">
  <small>{{ $review->helpful_yes }} of {{ $review->helpful_yes + $review->helpful_no }} people found this review helpful</small>
</div>
@endif
@endif

@if(!empty($review->title) && $settings->review_title)
<div style="margin-top:10px; text-align:justify; word-wrap:break-word;">
  <label>{{ $review->title }}</label>
</div>
@endif
@if(!empty($review->pros) && $settings->review_pros_cons)
<div style="margin-top:10px; text-align:justify; word-wrap:break-word;">
  <span class="green"><b>Pros:</b></span><span> {{ $review->pros }}</span>
</div>
@endif
@if(!empty($review->cons) && $settings->review_pros_cons)
<div style="margin-top:10px; text-align:justify; word-wrap:break-word;">
  <span class="red"><b>Cons:</b></span><span> {{ $review->cons }}</span>
</div>
@endif
<div style="margin-top:10px; word-wrap:break-word;">
  <div id="preview_{{$review->id}}">
    {!! nl2br(substr($review->text, 0, 300)) !!}@if(strlen($review->text)>200)... <a href="javascript:read_more({{$review->id}})">read more</a>@endif    
  </div>
  @if(strlen($review->text)>200)
  <div id="whole_{{$review->id}}" style="display:none; word-wrap:break-word;">
    {!! nl2br($review->text) !!}
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

@if(!$reviews->isEmpty() && Input::has('review'))
<div class="row">
  <a href="{{ url('product/'.$product->id.'/'.$review->product->slug) }}">Read other {{ count($reviews) - 1 }} reviews of {{$product->name}}</a>
</div>
@endif

@endforeach

<div>
  {!! $reviews->appends(array('category_id' => Input::Get('category_id'),'brand_id' => Input::Get('brand_id'),'search_terms' => Input::Get('search_terms')))->render() !!}
</div>
@endif

</div>

<div class="col-sm-4 col-md-4 col-lg-4">
  {!! $widgets['reviews-top-right'] !!}
</div>

<div class="clearfix"></div>

<div>
  {!! $widgets['reviews-bottom'] !!} 
</div>

<script type="text/javascript" src="{{ url('assets/js/login.js') }}"></script>

@include('login/modal')

@stop