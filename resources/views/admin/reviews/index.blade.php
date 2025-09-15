@extends('admin/layout')
@section('title', 'Manage Reviews')
@section('content')

@include('alerts')

<script type="text/javascript" src="{{ url('assets/js/username_hover.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div class="row page-header">

  <div class="col-sm-7 col-md-9 col-lg-9">
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Admin</a></li>
        <li class="active">Reviews @if($reviews->Total() > 0) <small> - {{ $reviews->Total() }} total {{$filter}} @endif
         @if(Input::has('search_terms'))
         <span class="text-muted">
          - search results for "{{ Input::get('search_terms') }}"
        </span>
        @endif </small></li>        
      </ol>
    </div>
    
  </div>

  <div class="col-sm-5 col-md-3 col-lg-3 pull-right">
    <form method="GET" action="{{ url('admin/reviews') }}">
      <div class="input-group">
        @if(Input::has('published')) 
        <input type="hidden" name="published" value="{{ Input::get('published') }}" />
        @endif
        @if(Input::has('reported')) 
        <input type="hidden" name="reported" value="{{ Input::get('reported') }}" />
        @endif
        @if(Input::has('featured')) 
        <input type="hidden" name="featured" value="{{ Input::get('featured') }}" />
        @endif
        <input type="text" name="search_terms" class="form-control" value="{{ Input::get('search_terms') }}" placeholder="Search reviews" required>

        <span class="input-group-btn">
          <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
  </div>

</div>

<div style="padding:8px">
  <ul class="nav nav-pills">
    <li style="vertical-align:middle">
      <div class="checkbox">
       <input type="checkbox" name="select_all_reviews" class="styled" value="" />
       <label></label>
     </div>
   </li>
   <li role="presentation" id="button_newest"><a href="{{ url('admin/reviews?search_terms=') }}{{Input::get('search_terms')}}">Newest</a></li>
   <li role="presentation" id="button_reported"><a href="{{ url('admin/reviews/reported') }}"><i class="fa fa-flag"></i> Reported @if($reported_count>0)({{ $reported_count }})@endif</a></li>
   <li role="presentation" id="button_unpublished"><a href="{{ url('admin/reviews/unpublished') }}"><i class="fa fa-remove"></i> Unpublished @if($unpublished_count>0)({{ $unpublished_count }})@endif</a></li>   
   <li role="presentation" id="button_featured"><a href="{{ url('admin/reviews/featured') }}"><i class="fa fa-star"></i> Featured @if($featured_count>0)({{ $featured_count }})@endif</a></li>      
 </ul>
</div>

@if($reviews->isEmpty())

<div style="text-align:center">
  <h3 class="text-muted">No reviews</h3>
</div>

@else

@include('admin/reviews/table')

<div>
  {!! $reviews->appends(array('search_terms' => Input::get('search_terms'), 'reported' => Input::get('reported'), 'published' => Input::get('published'), 'user_id' => Input::get('user_id')))->render() !!}
</div>

@endif

<div class="btn-group">
  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ $settings->admin_reviews_pagination }} per page <span class="caret"></span>
  </button>
<ul class="dropdown-menu">
    <li><a href="{{ url('admin/reviews/update-pagination/7') }}">7</a></li>
    <li><a href="{{ url('admin/reviews/update-pagination/20') }}">20</a></li>
    <li><a href="{{ url('admin/reviews/update-pagination/30') }}">30</a></li>
    <li><a href="{{ url('admin/reviews/update-pagination/50') }}">50</a></li>
    <li><a href="{{ url('admin/reviews/update-pagination/100') }}">100</a></li>    
</ul>
</div>

<script type="text/javascript">
  $(function(){
    $('#{{ $button_highlight }}').addClass('active');
    });//document ready
  </script>

  @stop