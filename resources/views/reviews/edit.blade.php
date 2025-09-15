@extends('layout')
@section('title', 'Edit Review')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<style type="text/css">
  .text_count_red{
    color:red;
}
</style>
<script type="text/javascript">
    $(function(){
        var max_review_len = {{ $settings->review_len }};
        var varning_review_len = 50;
        
        var remaining = max_review_len - $("#text").val().length;
        if(remaining < varning_review_len) $("#text_count").addClass('text_count_red'); else $("#text_count").removeClass('text_count_red');
        $("#text_count").text((max_review_len - $("#text").val().length));


        $("#text").keyup(function(){
          var remaining = max_review_len - $(this).val().length;
          if(remaining < varning_review_len) $("#text_count").addClass('text_count_red'); else $("#text_count").removeClass('text_count_red');
          $("#text_count").text((remaining));
      });
        
    });//document ready
</script>

<div class="col-lg-2 col-md-2 col-sm-2">
    @include('account/sidebar')
</div>
<div class="col-lg-10 col-md-10 col-sm-10">
     <div class="row">
          <ol class="breadcrumb">
          <li><a href="{{ url('account') }}">Account</a></li>
          <li><a href="{{ url('account/reviews') }}">Reviews</a></li>
          <li><a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}?review={{ $review->id }}" target="_blank">{{ $review->id }}</a></li>
              <li class="active">edit @if($review->active == 0) <span class="text-warning">(unapproved)</span>@endif</li>        
          </ol>
      </div>

    <div class="col-sm-8 col-md-8 col-lg-8 row">

        <form action="{{ url('reviews') }}/{{ $review->id }}" method="POST" role="form">

            <div>

                <div class="form-group">
                    <label>Overall Rating</label>
                    <div class="radio radio-inline">
                        <input name="rating" type="radio" id="1" class="star" value="1" @if($review->rating == 1) checked="checked" @endif required />
                        <label for="1">1</label>
                    </div>
                    <div class="radio radio-inline">
                        <input name="rating" type="radio" id="2" class="star" value="2" @if($review->rating == 2) checked="checked" @endif required />
                        <label for="2">2</label>
                    </div>
                    <div class="radio radio-inline">
                        <input name="rating" type="radio" id="3" class="star" value="3" required @if($review->rating == 3) checked="checked" @endif />
                        <label for="3">3</label>
                    </div>
                    <div class="radio radio-inline">
                        <input name="rating" type="radio" id="4" class="star" value="4" required @if($review->rating == 4) checked="checked" @endif />
                        <label for="4">4</label>
                    </div>
                    <div class="radio radio-inline">
                        <input name="rating" type="radio" id="5" class="star" value="5" required @if($review->rating == 5) checked="checked" @endif />
                        <label for="5">5</label>
                    </div>
                </div>

            </div>

            @if($settings->review_title == 1)
            <div class="form-group">
                <label>Review title</label>
                <input type="text" name="title" class="form-control" value="{{ $review->title }}"/>
            </div>
            @endif

            @if($settings->review_pros_cons == 1)
            <div class="form-group">
                <label class="green">Pros</label>
                <input type="text" name="pros" class="form-control" value="{{ $review->pros }}"/>
            </div>

            <div class="form-group">
                <label class="red">Cons</label>
                <input type="text" name="cons" class="form-control" value="{{ $review->cons }}"/>
            </div>
            @endif

            <div class="form-group">
                <label>Your review</label>
                <textarea  name="text" id="text" class="form-control" rows="12" required maxlength="{{ $settings->review_len }}">{!! $review->text !!}</textarea>
            </div>

            <div class="form-group"><span id="text_count"></span> characters remaining</div>

            <div class="form-group">
                {{ csrf_field() }}
                <button type="submit" name="write_review" class="btn btn-primary">Update Review</button>
            </div>

        </form>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        @if($settings->review_writing_tips <> '')
        {!! $settings->review_writing_tips !!}
        @endif
    </div>
</div>
@stop