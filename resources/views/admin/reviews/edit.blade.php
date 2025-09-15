@extends('admin/layout')
@section('title', 'Edit Review')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<script type="text/javascript" src="{{ url('assets/js/admin/.js') }}"></script>

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Admin</a></li>
    <li><a href="{{ url('admin/reviews') }}">Reviews</a></li>
    <li>
      <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug.'?review='.$review->id) }}" target="_blank">{{ $review->id }}</a>
  </li>
  <li class="active">edit</li>        
</ol>
</div>

<div class="table-responsive">
    <form action="{{ url('admin/reviews/'.$review->id) }}" method="POST" role="form">

        @if($review->reported == 1)
        <a href="javascript:unflag_review({{ $review->id }})" class="btn close" id="cross_{{$review->id}}">&times;</a>
        <div id="reported_{{ $review->id }}" class="alert alert-warning alert-block item-name">

            @foreach($review->reports->take(100) as $report)
            <div class="text-muted" style="word-wrap: break-word;">
                <b>Reported by <a href="{{ url('admin/user/'.$report->user_id.'/details') }}">{{ $report->user->username }}</a> </b>
                <br />
                @if($report->reason <> ''){!! nl2br($report->reason) !!} @endif
                <br />
                <small>{{ $report->created_at }} </small>
                
                <br /><br />                    
            </div>
            @endforeach
            
        </div>


        @endif
        
        <div>
            <h5>Review title</h5>
            <input type="text" name="title" class="form-control" value="{{ $review->title }}"/>
        </div>
        
        <di>
            <h5><span class="green">Pros</span></h5>
            <input type="text" name="pros" class="form-control" value="{{ $review->pros }}"/>
        </div>
        
        <div>
            <h5><span class="red">Cons</span></h5>
            <input type="text" name="cons" class="form-control" value="{{ $review->cons }}"/>
        </div>
        
        <div class="form-group @if ($errors->has('text')) has-error @endif">
            <h5>Review text</h5>
            <textarea name="text" rows="10" placeholder="Review text" class="form-control" required autofocus>{!! $review->text !!}</textarea>
            @if ($errors->has('text')) @foreach($errors->get('text') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
        </div>
        
        <div class="form-group"><strong>Product:</strong> <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}" target="_blank">{{ $review->product->name }}</a></td></div>
        <div class="form-group"><strong>Written by:</strong> <a href="{{ url('user/'.$review->user->id.'/'.$review->user->username) }}" target="_blank">{{ $review->user->username }}</a></div>
        
        <div class="form-group">
            Rating @include('admin/reviews/rating')
        </div>
        
        <div class="form-group">
            <label>Favorited</label>
            {{ $review->favorites->count() }} times
        </div>
        
        <div class="form-group">
            <div class="checkbox">
            <input type="checkbox" name="featured" id="featured" class="styled" value="1" @if($review->featured_on != NULL) checked="checked" @endif />
                <label for="featured">Featured</label> <small> <span class="text-muted"></span></small>
            </div>
        </div>

        <div class="form-group">

            <div class="radio radio-inline">
                <input type="radio" name="active" id="active" value="1"  @if($review->active == 1) checked="checked" @endif /> 
                <label for="active">Published</label>
            </div>

            <div class="radio radio-inline">
                <input type="radio" name="active" id="inactive" value="0" @if($review->active == 0) checked="checked" @endif /> 
                <label for="inactive">Unpublished</label>
            </div>
        </div>

        <div class="text-muted form-group">
            <small>
            Created: {{ $review->created_at }} | Updated: {{ $review->updated_at }}
            </small>
        </div>

        <div class="form-group">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="{{ url('admin/reviews/delete/'.$review->id.'/0') }}" onClick="return confirm('Confirm deletion')" class="btn btn-default pull-right" >Delete</a>
        </div>

    </form>
</div>
@stop