@extends('layout')
@section('title', 'My Favorites')
@section('content')

<script src="{{ url('assets/js/read_more.js') }}"></script>
@if($settings->review_helpful)
<script type="text/javascript" src="{{ url('assets/js/helpful.js') }}"></script>
@endif
@if($settings->review_favorite)
<script type="text/javascript" src="{{ url('assets/js/favorite.js') }}"></script>
@endif
<script type="text/javascript" src="{{ url('assets/js/login.js') }}"></script>

@include('login/modal')

<script type="text/javascript" src="{{ url('assets/js/username_hover.js') }}"></script>

<div class="col-lg-2 col-md-2 col-sm-2">
    @include('account/sidebar')
</div>

<div class="col-lg-10 col-md-10 col-sm-10">
  <div class="row">
      <ol class="breadcrumb">
          <li><a href="{{ url('account') }}">Account</a></li>
          <li class="active">favorites</li>        
      </ol>
  </div>

  <div>
    <ul class="nav nav-pills">
        @if($favorited_products->Total() <> 0 || $favorited_reviews->Total() <> 0 || $favorited_users->Total() <> 0)
        <li role="presentation" id="button_newest" @if(!Input::has('search_for')) class="active" @endif><a href="{{ url('account/favorites') }}{{Input::get('search_terms')}}">All</a></li>
        @endif

        @if($favorited_reviews->Total() > 0)
        <li role="presentation" id="button_reviews" @if(Input::get('search_for') == 'reviews') class="active" @endif><a href="{{ url('account/favorites?search_for=reviews') }}">Reviews({{$favorited_reviews->Total()}})</a></li>
        @endif

        @if($favorited_products->Total() > 0)
        <li role="presentation" id="button_products" @if(Input::get('search_for') == 'products') class="active" @endif><a href="{{ url('account/favorites?search_for=products') }}">Products({{$favorited_products->Total()}})</a></li>
        @endif 

        @if($favorited_users->Total() > 0)
        <li role="presentation" id="button_categories" @if(Input::get('search_for') == 'users') class="active" @endif><a href="{{ url('account/favorites?search_for=users') }}">Users({{$favorited_users->Total()}})</a></li>
        @endif            

    </ul>
</div>


@if(!Input::has('search_for') || Input::get('search_for') == 'reviews')

@if($favorited_reviews->Total() > 0)

<div>
    <h4>Reviews</h4>
</div>

<table class="table">

    @foreach($favorited_reviews as $favorited_review)
    <tr>
        <td>
            <div>

                <div>
                    <a href="{{ url('product/'.$favorited_review->review->product->id.'/'.$favorited_review->review->product->slug.'?review='.$favorited_review->review->id) }}" target="_blank">{{ $favorited_review->review->product->category->name }} / {{ $favorited_review->review->product->brand->name }} {{ $favorited_review->review->product->name }}</a> @if($favorited_review->review->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
                </div>

                <div class="pull-right text-muted item-name">
                    <span class="text-muted">
                        <small>
                            <a href="{{ url('user/'.$favorited_review->review->user->id.'/'.$favorited_review->review->user->username) }}" @include('account/favs_username_hover') ><b>{{ $favorited_review->review->user->username }}</b></a> on 
                            <span class="text-muted">
                                {{ date($settings->date_format, strtotime($favorited_review->review->created_at)) }}
                            </span>
                        </small>
                    </span>            
                </div>

                <div>
                    @include('account/review_rating')
                </div>

                @if($settings->review_helpful)

                @if($favorited_review->review->helpful_yes <> 0 || $favorited_review->review->helpful_no <> 0)
                <div class="text-muted">
                    <small>{{ $favorited_review->review->helpful_yes }} of {{ $favorited_review->review->helpful_yes + $favorited_review->review->helpful_no }} people found this review helpful</small>
                </div>

                @endif

                @endif

                @if(!empty($favorited_review->review->title) && $settings->review_title)

                <div class="my-favorites">
                    <label>{{ $favorited_review->review->title }}</label>
                </div>

                @endif

                @if(!empty($favorited_review->review->pros) && $settings->review_pros_cons)

                <div class="my-favorites">
                    <span class="green"><b>Pros:</b></span><span> {{ $favorited_review->review->pros }}</span>
                </div>

                @endif

                @if(!empty($favorited_review->review->cons) && $settings->review_pros_cons)

                <div class="my-favorites">
                    <span class="red"><b>Cons:</b></span><span> {{ $favorited_review->review->cons }}</span>
                </div>

                @endif

                <div class="my-favorites-preview">
                    <div id="preview_{{$favorited_review->review->id}}">
                        {!! nl2br(substr($favorited_review->review->text, 0, 200)) !!}@if(strlen($favorited_review->review->text)>200)... <a href="javascript:read_more({{$favorited_review->review->id}})">read more</a>@endif
                    </div>
                    @if(strlen($favorited_review->review->text)>200)
                    <div id="whole_{{$favorited_review->review->id}}" style="display:none; word-wrap:break-word;">
                        {!! nl2br($favorited_review->review->text) !!}
                    </div>
                    @endif
                </div>

                <div>
                    <span class="text-muted">
                        <small>
                            favorited on: {{ $favorited_review->created_at }} | favorited {{ $favorited_review->review->favorites->count() }}times
                        </small>
                    </span>

                    @if($settings->review_favorite)
                    <span id="favorited_review_{{ $favorited_review->review->id }}" class="pull-right">
                        <a href="javascript:favorite_review({{ $favorited_review->review->id }})" >
                            <i id="unfavorited_icon_{{ $favorited_review->review->id }}" class="fa fa-star silver"></i>
                            <i style="display:none" id="favorited_icon_{{ $favorited_review->review->id }}" class="fa fa-star-o silver"></i></a>
                        </span>

                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </table>


        <div>
            {!! $favorited_reviews->appends(array('search_for' => 'reviews',))->render() !!}
        </div>

        @endif

        @endif

        @if(!Input::has('search_for') || Input::get('search_for') == 'products')

        @if($favorited_products->Total() > 0)

        <div>
            <h4>Products</h4>
        </div>

        <table class="table">
            <thead>
                <th>Image</th>
                <th>Product</th>
                <th>Favorited</th>
                <th></th>
            </thead>
            @foreach($favorited_products as $product)
            <tr>
                <td>
                    <a href="{{ url('product/'.$product->product->id.'/'.$product->product->slug) }}"><img src="@if($product->product->image_id != FALSE){{ url('images/'.$product->product->id.'/sm_'.$product->product->image->file_name) }}@else{{ url('images/no_image.png') }}@endif" class="img-home"></a>                    
                </td>
                <td class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <a href="{{ url('product/'.$product->product->id.'/'.$product->product->slug) }}" target="_blank">{{$product->product->category->name}} / {{$product->product->brand->name}} {{$product->product->name}}</a> @if($product->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
                </td>
                <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-muted"><small>{{ date($settings->date_format, strtotime($product->created_at)) }}</small></td>
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1" align="right">
                    <a href="javascript:favorite_product({{ $product->product->id }})" id="favorite_product_{{ $product->product->id }}"><i id="favorite_product_icon_{{ $product->product->id }}" class="fa fa-star silver"></i></a>  
                </td>
            </tr>
            @endforeach
        </table>

        <div>
            {!! $favorited_products->appends(array('search_for' => 'products',))->render() !!}
        </div>

        @endif
        @endif


        @if(!Input::has('search_for') || Input::get('search_for') == 'users')
        @if($favorited_users->Total() > 0)

        <div>
            <h4>Users</h4>
        </div>

        <table class="table">
            <thead>
                <th>User</th>
                <th>Favorited</th>
                <th></th>
            </thead>
            @foreach($favorited_users as $favorited_user)
            <tr>
                <td class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ url('user/'.$favorited_user->favorited_user_id) }}/{{ $favorited_user->favorited_user->usernam }}" target="_blank"> {{ $favorited_user->favorited_user->username }}</a>
                </td>
                <td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-muted">
                    <small>{{ date($settings->date_format, strtotime($favorited_user->created_at)) }}</small>
                </td>
                <td class="col-lg-1 col-md-1 col-sm-1 col-xs-1" align="right">
                    <a href="javascript:favorite_user({{ $favorited_user->favorited_user_id }})" id="favorite_user_{{ $favorited_user->favorited_user_id }}"><i id="favorite_user_icon_{{ $favorited_user->favorited_user_id }}" class="fa fa-star silver"></i></a>
                </td>
            </tr>
            @endforeach
        </table>

        <div>
            {!! $favorited_users->appends(array('search_for' => 'users',))->render() !!}
        </div>

        @endif

        @if($favorited_products->Total() == 0 && $favorited_reviews->Total() == 0 && $favorited_users->Total() == 0)

        <div style="text-align:center">
            <h3 class="text-muted">No favorites found</h3>
        </div>

        @endif
        @endif

    </div>
    @stop