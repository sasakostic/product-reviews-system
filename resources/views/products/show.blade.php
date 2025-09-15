@extends('layout')
@section('title', $product->category->name . '-' .$product->brand->name . '-' . $product->name)
@section('content')

<script type="text/javascript" src="{{ url('assets/js/login.js') }}"></script>

@include('alerts')

<script type="text/javascript">
    $(function(){
        read_more_description = function(id){
          $('#description_preview').hide();
          $('#description_whole').show();
          }
    });//document ready
</script>

<script src="{{ url('assets/libs/swipebox/js/jquery.swipebox.js') }}"/></script>
<link href="{{ url('assets/libs/swipebox/css/swipebox.css') }}" rel="stylesheet">

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

<script type="text/javascript">
    $(function(){
        reveal_images = function(){
            $('.other_images').fadeToggle();
        }
            });//document ready
        </script>

        @if($settings->users_add_product_images)
        <script type="text/javascript">
            $(function(){
                add_images = function(){
                    $('#add_images_modal').modal({keyboard: true}, 'show');
                }
    });//document ready
</script>
@endif

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

@if($settings->users_report_products)
<script type="text/javascript" src="{{ url('assets/js/report_product.js') }}"></script>
@include('products/report_modal')
@endif

<style type="text/css">
    .carousel-inner>.item>img {
        margin: 0 auto;
    }
</style>

@include('login/modal')

<div>
    {!! $widgets['product-details-top'] !!}
</div>

<div>
    <ol class="breadcrumb">
        <li><a href="{{ url('products') }}">Products</a></li>
        <li><a href="{{ url('products?category='.$product->category->slug.'&category_id='.$product->category_id) }}">{{ $product->category->name }}</a></li>
        <li><a href="{{ url('products?category='.$product->category->slug.'&brand='.$product->brand->slug.'&category_id='.$product->category_id.'&brand_id='.$product->brand_id) }}">{{ $product->brand->name }}</a></li>        
    </ol>
</div>

<div class="col-lg-8 col-md-8 col-sm-8">

    <div class="item-name">
        <h2>
            <div class="row">
                <div class="pull-left">
                    {{ $product->brand->name }} {{ $product->name }} 
                </div>            
                <div class="pull-right">
                    <a href="javascript:favorite_product({{ $product->id }})" id="favorite_product_{{ $product->id }}" title="Favorite product"><i id="favorite_product_icon_{{ $product->id }}" class="fa @if($is_favorited == 1) fa-star @else fa-star-o @endif silver"></i></a>
                </div>
            </div>
        </h2>
    </div>
    @if($product->discontinued == 1)
    <div class="label label-warning pull-right">
        Discontinued
    </div>
    @endif
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">

            @if($images->isEmpty())
            <div style="width:{{$settings->product_main_thumb_w}}px; height:{{$settings->product_main_thumb_h}}px">

            </div>
            @endif

            <div>

                <div>
                    @if($product->image_id != NULL)
                    <a class="swipebox" href="{{ url('images')}}/{{ $product->id }}/{{ $product->image->file_name }}" title="{{$product->image->description}} @if($product->image->user_id != 1) by {{$product->image->user->username}} @endif">
                        <img class="img-responsive" src="{{ url('images') }}/{{ $product->id }}/mn_{{ $product->image->file_name }}" />
                        @endif
                    </a>
                </div>

                <div class="row">
                    @if(count($images) > 1)
                    <span class="col-xs-5 col-sm-5 col-md-5 col-lg-5"><a href="javascript:reveal_images()" class="silver">+{{count($images) - 1}} images</a></span>
                    @endif
                    @if($settings->users_add_product_images)
                    <span class="col-xs-7 col-sm-7 col-md-7 col-lg-7"><a href="javascript:add_images()" class="silver">add images</a></span>
                    @endif
                </div>

            </div>

        </div>
        <div class="col-md-12 col-lg-12 col-sm-12 other_images" style="display:none">

            @foreach($images as $image)
            @if($image->id != $product->image_id)
            <span>
                <a class="swipebox" href="{{ url('images')}}/{{ $product->id }}/{{ $image->file_name}}" title="{{$image->description}}"" ><img src="{{ url('images/'.$product->id.'/sm_'.$image->file_name) }}" style="margin:5px"></a>
            </span>
            @endif
            @endforeach

        </div>   

        <div class="col-sm-6 col-md-6 col-lg-6">

            <div>
                @include('products/rating')
            </div>

            @if($user_reviewed_product == 1)

            @if($settings->review_edit)
            <div>
                <a href="{{ url('reviews') }}/{{ $review_id }}/edit" class="text-muted">Update review</a>
            </div>  
            @endif

            @else
            <div>
                <a href="{{ url('product-'.$product->id.'/write_review') }}" class="btn btn-primary">Write a Review</a>
            </div>
            @endif
            
            <small>
                @if($settings->users_report_products)

                <span id="report_product_info" class="text-muted" style="margin-right: 15px">                
                    <a href="javascript:report_product({{ $product->id }})" class="text-muted">report</a>
                </span>

                @endif
                @if($can_edit) <a href="{{ url('admin/products') }}/{{ $product->id }}/edit" class="text-muted">edit</a> @endif
            </small>
        </div>
        
    </div>

    @if(!empty($product->description) )
    <div style="word-wrap:break-word;">
        <div>
            <label>Description</label>
        </div>
        <div id="description_preview">
            {!! nl2br(substr($product->description, 0, $settings->product_description_len) ) !!}
            @if(strlen($product->description)>$settings->product_description_len)... <a href="javascript:read_more_description()">read more</a>@endif
        </div>

        <div id="description_whole" style="display:none">
            {!! nl2br($product->description ) !!}
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-11 col-xs-11">
         <p>

            <div style="">
                <a href="{{ url('product/'.$product->id.'/'.$product->slug.'?rating=5#rating') }}" rel="nofollow"><div class="progress-label">5 stars</div>
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{ $product->five_stars_percent }}%"></div>
                  </div></a>
              </div>

              <a href="{{ url('product/'.$product->id.'/'.$product->slug.'?rating=4#rating') }}" rel="nofollow">
                  <div class="progress-label">4 stars</div>
                  <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: {{ $product->four_stars_percent }}%;"></div>
                  </div>
              </a>

              <a href="{{ url('product/'.$product->id.'/'.$product->slug.'?rating=3#rating') }}" rel="nofollow">
                  <div class="progress-label">3 stars</div>
                  <div class="progress">

                      <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: {{ $product->three_stars_percent }}%;"></div>
                  </div>
              </a>

              <a href="{{ url('product/'.$product->id.'/'.$product->slug.'?rating=2#rating') }}" rel="nofollow">
                  <div class="progress-label">2 stars</div>
                  <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: {{ $product->two_stars_percent }}%;"></div>
                  </div>
              </a>

              <a href="{{ url('product/'.$product->id.'/'.$product->slug.'?rating=1#rating') }}" rel="nofollow">
                  <div class="progress-label">1 star&nbsp;</div>
                  <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: {{ $product->one_star_percent }}%;"></div>
                  </div>
              </a>

          </p>   
      </div>
  </div>
  @if(Input::has('rating'))
  <div id="rating">
      <p>
        <div>Displaying reviews with <span class="label label-default">{{ Input::get('rating') }} stars <a href="{{ url('product') }}/{{ $product->id}}/{{ $product->slug }}" style="color:white">&times;</a></span></div>
    </p>
</div>
@endif

@if($reviews->isEmpty())

<div style="text-align:center">
    <h4 class="text-muted">
        @if(Input::has('review'))
        Review not found
        @else
        No reviews
        @endif
    </h4>
</div>

@else


<div>
    @if($product->reviews->count() > 1)
    @if(!Input::has('review'))
    <div style="margin-top:20px">
        <ul class="nav nav-tabs">
            <li role="presentation" @if($sort_by == 'newest') class="active" @endif id="newest"><a href="{{ url('product/'.$product->id.'/'.$product->slug) }}#newest" rel="nofollow">Newest</a></li>

            @if($settings->review_helpful)
            <li role="presentation" @if($sort_by == 'helpful') class="active" @endif id="most_helpful"><a href="{{ url('product/'.$product->id.'/'.$product->slug.'?sort_by=helpful') }}#most_helpful" rel="nofollow">Most helpful</a></li>
            @endif

            <li role="presentation" @if($sort_by == 'rating') class="active" @endif id="top_rated"><a href="{{ url('product/'.$product->id.'/'.$product->slug.'?sort_by=rating') }}#top_rated" rel="nofollow">Top rated</a></li>
        </ul>
    </div>
    @endif
    @endif
    @include('products/reviews')
</div>

<div>
    {!! $reviews->appends(array('sort_by' => Input::Get('sort_by')))->render() !!}
</div>

@endif

</div>

<div class="visible-xs clearfix"></div>

<div class="col-sm-4 col-md-4 col-lg-4" style="margin-top:25px;">
    @if(!empty($product->affiliate_code))
    <h3>Where to buy</h3>
    {!! $product->affiliate_code !!}
    @endif
    <div>
        {!! $widgets['product-details-top-right'] !!}
    </div>

    @if(!$top_in_category->isEmpty() && $product->category_id <> 1)
    <div style="margin-top:20px">
        <div class="item-name"><h4>Top Rated in <a href="{{ url('products?order=rating&category=')}}{{$product->category->slug}}&category_id={{$product->category->id}}&brand_id=&name=">{{$product->category->name}}</a></h4></div>
        @foreach($top_in_category as $top_product)
        <div class="clearfix">
            <div class="pull-left" style="margin-right:10px;margin-bottom:10px">
                <a href="{{ url('product/'.$top_product->id.'/'.$top_product->slug) }}">
                 <a href="{{ url('product/'.$top_product->id.'/'.$top_product->slug) }}"><img src="@if($top_product->image_id != NULL){{ url('images/'.$top_product->id.'/sm_'.$top_product->image->file_name) }}@else{{ url('images/no_image.png') }}@endif" ></a>                 
             </a>
         </div>
         <div class="text-muted pull-rigth">
            <div class="item-name">
                <a href="{{ url('product/'.$top_product->id.'/'.$top_product->slug) }}">{{ $top_product->brand->name }} {{ $top_product->name }}</a>
            </div>
            <div>
                @include('products/top_product_rating')
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@if(!$top_of_brand->isEmpty() && $product->brand_id <> 1)
<div>
    <div class="item-name">
        <h4>Top Rated <a href="{{ url('products?order=rating&brand=')}}{{$product->brand->slug}}&brand_id={{$product->brand->id}}&category_id=&name=">{{$product->brand->name}}</a> Products</h4>
    </div>
    @foreach($top_of_brand as $top_product)
    <div class="clearfix">
        <div class="pull-left" style="margin-right:10px;margin-bottom:10px">
            <a href="{{ url('product/'.$top_product->id.'/'.$top_product->slug) }}">
                <a href="{{ url('product/'.$top_product->id.'/'.$top_product->slug) }}"><img src="@if($top_product->image_id != FALSE){{ url('images/'.$top_product->id.'/sm_'.$top_product->image->file_name) }}@else{{ url('images/no_image.png') }}@endif" ></a>
            </div>
            <div class="text-muted pull-rigth">
                <div class="item-name">
                    <a href="{{ url('product/'.$top_product->id.'/'.$top_product->slug) }}">{{ $top_product->name }}</a>
                </div>
                <div>
                    @include('products/top_product_rating')
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

<div class="clearfix"></div>
<div>
    {!! $widgets['product-details-bottom'] !!}
</div>

@if($settings->users_add_product_images)

<div id="add_images_modal" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add product image</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form action="{{ url('account/images') }}" method="POST" enctype='multipart/form-data'>
                        <input type="file" name="images[]" required/>
                    </div>
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                    <div class="form-group">
                        <input type="text" name="description" class="form-control" placeholder="Image description (optional)"/>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endif      

@stop