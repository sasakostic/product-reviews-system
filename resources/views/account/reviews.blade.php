@extends('layout')
@section('title', 'My Reviews')
@section('content')

@include('alerts')

<script src="{{ url('assets/js/read_more.js') }}"></script>

<div class="col-lg-2 col-md-2 col-sm-2">
    @include('account/sidebar')
</div>

<div class="col-lg-10 col-md-10 col-sm-10">

    <div class="row">
      <ol class="breadcrumb">
          <li><a href="{{ url('account') }}">Account</a></li>
          <li class="active">reviews</li>        
      </ol>
  </div>

  @if($reviews->Total() == 0)
  <div style="text-align:center">
    <h3 class="text-muted">You have no reviews</h3>
</div>
@else

<div>
    <h4>{{ $reviews->Total() }} reviews</h4>
</div>
<table class="table">

    @foreach($reviews as $review)
    <tr>
        <td>
            <div style="margin-bottom: 50px">
                <div>
                    <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug.'?review='.$review->id) }}" target="_blank">{{ $review->product->category->name }} / {{ $review->product->brand->name }} {{ $review->product->name }}</a> @if($review->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
                </div>
                <div class="pull-right text-muted item-name">
                    <span class="text-muted">
                        <small>
                            <span class="text-muted">{{ date($settings->date_format,strtotime($review->created_at)) }}</span>
                        </small>
                    </span>

                </div>

                <div>
                    @include('reviews/rating')
                </div>

                @if($review->helpful_yes <> 0 || $review->helpful_no <> 0)

                <div class="text-muted">
                    <small>{{ $review->helpful_yes }} of {{ $review->helpful_yes + $review->helpful_no }} people found this review helpful</small>
                </div>
                @endif

                @if(!empty($review->title))

                <div class="my-reviews">
                    <label>{{ $review->title }}</label>
                </div>
                @endif

                @if($review->active == 0) <span class="text-warning">(unapproved)</span>@endif

                @if(!empty($review->pros))
                <div class="my-reviews">
                    <span class="green"><b>Pros:</b></span><span> {{ $review->pros }}</span>
                </div>
                @endif

                @if(!empty($review->cons))
                <div class="my-reviews">
                    <span class="red"><b>Cons:</b></span><span> {{ $review->cons }}</span>
                </div>
                @endif

                <div style="padding:0px; margin-bottom:5px; margin-top:5px; word-wrap:break-word;">
                    <div id="preview_{{$review->id}}">
                        {!! nl2br(substr($review->text, 0, 100)) !!}@if(strlen($review->text)>100)... <a href="javascript:read_more({{$review->id}})">read more</a>@endif
                    </div>
                    @if(strlen($review->text)>100)
                    <div id="whole_{{$review->id}}" style="display:none; word-wrap:break-word;">
                        {!! nl2br($review->text) !!}
                    </div>
                    @endif
                </div>

                <div>

                    <span class="text-muted pull-left">
                        <small>favorited {{ $review->favorites->count() }} times</small>
                    </span>

                    @if($settings->review_edit)
                    <span style="margin-left:5px">
                        <a href="{{ url('reviews') }}/{{ $review->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>
                    </span>
                    @endif

                    @if($settings->review_delete)
                    <span class="pull-right" style="text-align:right">
                        <a href="{{ url('reviews/delete/'.$review->id) }}" class="btn btn-default btn-xs" onClick="return confirm('Confirm deletion')" title="Delete"><span class="glyphicon glyphicon-trash silver"></span></a>
                    </span>
                    @endif

                </div>

            </div>
        </td>
    </tr>
    @endforeach
    

</table>
<div>
    {!! $reviews->render() !!}
</div>
@endif

</div>
@stop