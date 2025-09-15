@extends('layout')
@section('title', 'Search results for' . ' ' . $search_terms)
@section('content')

@include('alerts')

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

<script type="text/javascript" src="{{ url('assets/js/login.js') }}"></script>

@include('login/modal')



<script src="{{ url('assets/js/read_more.js') }}"></script>

<script type="text/javascript" src="{{ url('assets/js/username_hover.js') }}"></script>

<div>
  {!! $widgets['search-results-top'] !!}
</div>

<div class="col-lg-8 col-md-8 col-sm-8 pull-left">

    @if($products->Total() == 0 && $reviews->Total() == 0 && $categories->Total() == 0 && $brands->Total() == 0 && $images->Total() == 0) 
    <div style="text-align:center">
        <h3 class="text-muted">Items not found</h3>
    </div>
    
    @else
    <h2>Results for "{{$search_terms}}"</h2>
    @endif
    
    <div>
        <ul class="nav nav-pills">
            @if($products->Total() <> 0 || $reviews->Total() <> 0 || $categories->Total() <> 0 || $brands->Total() <> 0 || $images->Total() <> 0)
            <li role="presentation" id="button_newest" @if(!Input::has('search_for')) class="active" @endif><a href="{{ url('search?search_terms=') }}{{Input::get('search_terms')}}">All</a></li>
            @endif

            @if($products->Total() > 0)
            <li role="presentation" id="button_products" @if(Input::get('search_for') == 'products') class="active" @endif><a href="{{ url('search?search_for=products&search_terms=') }}{{Input::get('search_terms')}}">Products({{$products->Total()}})</a></li>
            @endif 

            @if($reviews->Total() > 0)
            <li role="presentation" id="button_reviews" @if(Input::get('search_for') == 'reviews') class="active" @endif><a href="{{ url('search?search_for=reviews&search_terms=') }}{{Input::get('search_terms')}}">Reviews({{$reviews->Total()}})</a></li>
            @endif

            @if($categories->Total() > 0)
            <li role="presentation" id="button_categories" @if(Input::get('search_for') == 'categories') class="active" @endif><a href="{{ url('search?search_for=categories&search_terms=') }}{{Input::get('search_terms')}}">Categories({{$categories->Total()}})</a></li>
            @endif

            @if($brands->Total() > 0)
            <li role="presentation" id="button_brands" @if(Input::get('search_for') == 'brands') class="active" @endif><a href="{{ url('search?search_for=brands&search_terms=') }}{{Input::get('search_terms')}}">Brands({{$brands->Total()}})</a></li>
            @endif

            @if($images->Total() > 0)
            <li role="presentation" id="button_brands" @if(Input::get('search_for') == 'images') class="active" @endif><a href="{{ url('search?search_for=images&search_terms=') }}{{Input::get('search_terms')}}">Images({{$images->Total()}})</a></li>
            @endif
            
        </ul>
    </div>
    
    @if(!Input::has('search_for') || Input::get('search_for') == 'products')

    @if($products->Total() > 0)
    
    <div>
        <h4><i class="fa fa-list"></i> Products <small>{{ $products->Total() }} found</small></h4>
    </div>
    
    @foreach($products as $product)
    
    <div class="clearfix">
        <div class="pull-left">
            <a href="{{ url('product/'.$product->id.'/'.$product->slug) }}"><img src="@if($product->image_id != FALSE){{ url('images') }}/{{ $product->id }}/sm_{{ $product->image->file_name}}@else{{ url('images/no_image.png') }}@endif" class="img-home"></a>            
        </div>
        <div class="item-name">
            <a href="{{ url('product/'.$product->id.'/'.$product->slug) }}">{{$product->brand->name}} {{$product->name}}</a> @if($product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
            <div>
                @include('products/product_rating')
            </div>            
            <div>
                <a class="text-muted" href="{{ url('products?category='.$product->category->slug.'&category_id='.$product->category_id) }}&name={{Input::get('name')}}&order={{Input::get('order')}}">{{ $product->category->name }}</a>
            </div>
        </div>                        
    </div>
    @endforeach

    <div>
        {!! $products->appends(array('search_terms' => Input::Get('search_terms'),'search_for' => 'products',))->render() !!}
    </div>
    
    @endif

    @endif 

    @if(!Input::has('search_for') || Input::get('search_for') == 'reviews')
    @if($reviews->Total() > 0)
    
    <div>
        <h4><i class="fa fa-comment"></i> Reviews <small>{{ $reviews->Total() }} found</small></h4>
    </div>

    @foreach($reviews as $review)
    <div class="review" style="margin-top:20px">

        <div>
            <div class="item-name">
                <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug) }}?review={{$review->id}}">{{ $review->product->category->name }} / {{ $review->product->brand->name }} {{ $review->product->name }}</a> @if($review->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
            </div>

            <div class="pull-right text-muted item-name">
                <small>
                    <a href="{{ url('user/'.$review->user->id.'/'.$review->user->username) }}" @include('home/username_hover') ><b>{{ $review->user->username }}</b></a> on 
                    <a href="{{ url('product/'.$review->product->id.'/'.$review->product->slug.'?review='.$review->id) }}" class="text-muted">{{ date($settings->date_format,strtotime($review->created_at)) }}</a> </span>
                </small>                
            </div>

            <div>
                @include('reviews/rating')
            </div>                       
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
                <span class="text-muted" style="min-width:153px" id="helpful_review_info_{{ $review->id }}"></span>
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

      @endforeach

      <div>
        {!! $reviews->appends(array('search_terms' => Input::Get('search_terms'),'search_for' => 'reviews',))->render() !!}
    </div>
    @endif
    @endif

    @if(!Input::has('search_for') || Input::get('search_for') == 'categories')
    @if($categories->Total() > 0)
    
    <div>
        <h4><i class="fa fa-th"></i> Categories <small>{{ $categories->Total() }} found</small></h4>
    </div>

    @foreach($categories as $category)
    <div style="margin-bottom:15px">
        <div>
            <a href="{{ url('products?category_id='.$category->id) }}">{{ $category->name }}</a>
            @if($category->reviews > 0)
            <span class="text-muted"><small> {{ $category->reviews }} reviews </small></span>
            @endif
            @if($category->products > 0)
            <span class="text-muted"><small> {{ $category->products }} products </small></span>
            @endif
        </div>
    </div>
    @endforeach
    
    <div>
        {!! $categories->appends(array('search_terms' => Input::Get('search_terms'),'search_for' => 'categories',))->render() !!}
    </div>
    @endif

    @endif 

    @if(!Input::has('search_for') || Input::get('search_for') == 'brands')
    
    @if($brands->Total() > 0)
    
    <div>
        <h4><i class="fa fa-gift"></i> Brands <small>{{ $brands->Total() }} found</small></h4>
    </div>
    
    @foreach($brands as $brand)
    
    <div style="margin-bottom:15px">
        <div>
            <a href="{{ url('products?brand_id='.$brand->id) }}">{{ $brand->name }}</a>
            @if($brand->reviews > 0)
            <span class="text-muted"><small> {{ $brand->reviews }} reviews </small></span>
            @endif
            @if($brand->products > 0)
            <span class="text-muted"><small> {{ $brand->products }} products </small></span>
            @endif
        </div>
    </div>
    
    @endforeach
    
    <div>
        {!! $brands->appends(array('search_terms' => Input::Get('search_terms'),'search_for' => 'brands'))->render() !!}
    </div>
    
    @endif

    @endif

    @if(!Input::has('search_for') || Input::get('search_for') == 'images')

    @if($images->Total() > 0)
    
    <div>
        <h4><i class="fa fa-photo"></i> Images <small>{{ $images->Total() }} found</small></h4>
    </div>
    
    @foreach($images as $image)
    
    <div class="clearfix">
        <div class="pull-left">
            <a href="{{ url('product/'.$image->product->id.'/'.$image->product->slug) }}"><img src="@if($image->product->image_id != FALSE){{ url('images') }}/{{ $image->product->id }}/sm_{{ $image->file_name}}@else{{ url('images/no_image.png') }}@endif" class="img-home"></a>            
        </div>
        <div class="item-name">
            <a href="{{ url('product/'.$image->product->id.'/'.$image->product->slug) }}">{{$image->product->brand->name}} {{$image->product->name}}</a> @if($image->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
            <div>
                <a class="text-muted" href="{{ url('products?category='.$image->product->category->slug.'&category_id='.$image->product->category_id) }}&name={{Input::get('name')}}&order={{Input::get('order')}}">{{ $image->product->category->name }}</a>
            </div>
        </div>
        <div class="item-name">
            {{ $image->description }}
        </div>       
    </div>
    @endforeach

    <div>
        {!! $images->appends(array('search_terms' => Input::Get('search_terms'),'search_for' => 'images',))->render() !!}
    </div>
    
    @endif

    @endif 

</div>

<div class="visible-xs clearfix"></div>

<div class="col-sm-4 col-md-4 col-lg-4">
  {!! $widgets['search-results-top-right'] !!}
</div>

<div class="clearfix"></div>

<div>
    {!! $widgets['search-results-bottom'] !!} 
</div>

@stop