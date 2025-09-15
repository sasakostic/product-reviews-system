@extends('admin/layout')
@section('title', 'Search results for' . $search_terms)
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<script type="text/javascript" src="{{ url('assets/libs/swipebox/js/jquery.swipebox.js') }}"></script>

<link href="{{ url('assets/libs/swipebox/css/swipebox.css') }}" rel="stylesheet">

<script type="text/javascript" src="{{ url('assets/js/username_hover.js') }}"></script>

<script type="text/javascript">
    ;( function( $ ) {
        $( '.swipebox' ).swipebox( {
useCSS : true, // false will force the use of jQuery for animations
useSVG : true, // false to force the use of png for buttons
initialIndexOnArray : 0, // which image index to init when a array is passed
hideCloseButtonOnMobile : false, // true will hide the close button on mobile devices
hideBarsDelay : 0, // delay before hiding bars on desktop
videoMaxWidth : 1140, // videos max width
beforeOpen: function() {}, // called before opening
afterOpen: null, // called after opening
afterClose: function() {}, // called after closing
loopAtEnd: false // true will return to the first image after the last image is reached
} );
    } )( jQuery );
</script>


<div class="page-header">
	<h3>
        <i class="fa fa-search"></i> 
        <small>
        Search results for "{{$search_terms}}" - {{ $users->Total() }} total
            @if(Input::has('search_terms'))
            <span class="text-muted">
                - search results for "{{ Input::get('search_terms') }}"
            </span>
            @endif
        </small>
    </h3>
</div>

<div style="margin-bottom:15px">
    <ul class="nav nav-pills">
        @if($products->Total() <> 0 || $reviews->Total() <> 0 || $categories->Total() <> 0 || $brands->Total() <> 0)
        <li role="presentation" id="button_newest" @if(!Input::has('search_for')) class="active" @endif><a href="{{ url('admin/search?search_terms_all=') }}{{Input::get('search_terms_all')}}">All</a></li>
        @endif

        @if($products->Total() > 0)
        <li role="presentation" id="button_products" @if(Input::get('search_for') == 'products') class="active" @endif><a href="{{ url('admin/search?search_for=products&search_terms_all=') }}{{Input::get('search_terms_all')}}">Products({{$products->Total()}})</a></li>
        @endif 

        @if($reviews->Total() > 0)
        <li role="presentation" id="button_reviews" @if(Input::get('search_for') == 'reviews') class="active" @endif><a href="{{ url('admin/search?search_for=reviews&search_terms_all=') }}{{Input::get('search_terms_all')}}">Reviews({{$reviews->Total()}})</a></li>
        @endif

        @if($categories->Total() > 0)
        <li role="presentation" id="button_categories" @if(Input::get('search_for') == 'categories') class="active" @endif><a href="{{ url('admin/search?search_for=categories&search_terms_all=') }}{{Input::get('search_terms_all')}}">Categories({{$categories->Total()}})</a></li>
        @endif

        @if($brands->Total() > 0)
        <li role="presentation" id="button_brands" @if(Input::get('search_for') == 'brands') class="active" @endif><a href="{{ url('admin/search?search_for=brands&search_terms_all=') }}{{Input::get('search_terms_all')}}">Brands({{$brands->Total()}})</a></li>
        @endif

        @if($users->Total() > 0)
        <li role="presentation" id="button_users" @if(Input::get('search_for') == 'users') class="active" @endif><a href="{{ url('admin/search?search_for=users&search_terms_all=') }}{{Input::get('search_terms_all')}}">Users({{$users->Total()}})</a></li>
        @endif

    </ul>
</div>

@if(!Input::has('search_for') || Input::get('search_for') == 'products')

@if(!$products->isEmpty())
<div>

	<h3><i class="fa fa-list"></i> Products <small> {{ $products->Total() }} found</small></h3> 
	@include('admin/products/table')
	{!! $products->appends(array('search_terms_all' => Input::Get('search_terms_all'),'search_for' => 'products',))->render() !!}

</div>
@endif

@endif

@if(!Input::has('search_for') || Input::get('search_for') == 'reviews')

@if(!$reviews->isEmpty())
<div>
	<h3><i class="fa fa-comment"></i> Reviews <small> {{ $reviews->Total() }} found</small></h3>
    <div style="padding:8px;">
        <div class="checkbox">
           <input type="checkbox" name="select_all_reviews" id="select_all_reviews" class="styled" value="" />
           <label for="select_all_reviews">Select all</label>
       </div>
   </div>
   @include('admin/reviews/table')
   {!! $reviews->appends(array('search_terms_all' => Input::Get('search_terms_all'),'search_for' => 'reviews',))->render() !!}
</div>
@endif

@endif

@if(!Input::has('search_for') || Input::get('search_for') == 'images')
@if(!$images->isEmpty())

<div>
	<h3><i class="fa fa-photo"></i> Images <small> {{ $images->Total() }} found</small></h3>
	@include('admin/images/table')
	{!! $images->appends(array('search_terms_all' => Input::Get('search_terms_all'),'search_for' => 'images',))->render() !!}
</div>

@endif

@endif

@if(!Input::has('search_for') || Input::get('search_for') == 'categories')

@if(!$categories->isEmpty())

<h3><i class="fa fa-th"></i> Categories <small> {{ $categories->Total() }} found</small></h3>

@include('admin/categories/table')

<div>
	{!! $categories->appends(array('search_terms_all' => Input::Get('search_terms_all'),'search_for' => 'categories',))->render() !!}
</div>

@endif

@endif

@if(!Input::has('search_for') || Input::get('search_for') == 'brands')

@if(!$brands->isEmpty())

<h3><i class="fa fa-gift"></i> Brands <small> {{ $brands->Total() }} found</small></h3>

@include('admin/brands/table')

<div>
	{!! $brands->appends(array('search_terms_all' => Input::Get('search_terms_all'),'search_for' => 'brands',))->render() !!}
</div>

@endif

@endif

@if(!Input::has('search_for') || Input::get('search_for') == 'users')

@if(!$users->isEmpty())

<h3><i class="fa fa-users"></i> Users <small> {{ $users->Total() }} found</small></h3>

@include('admin/users/table')

<div>
	{!! $users->appends(array('search_terms_all' => Input::Get('search_terms_all'),'search_for' => 'users',))->render() !!}
</div>

@endif

@endif

@if($products->isEmpty() && $reviews->isEmpty() && $categories->isEmpty() && $brands->isEmpty() && $users->isEmpty())
<div style="text-align: center">
	<h3 class="text-muted">Items not found</h3>
</div>

@endif

@stop