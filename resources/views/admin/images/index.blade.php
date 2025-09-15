@extends('admin/layout')
@section('title', 'Manage Images')
@section('content')

@include('alerts')

<script type="text/javascript" src="{{ url('assets/libs/swipebox/js/jquery.swipebox.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
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



<div class="row page-header">

    <div class="col-sm-7 col-md-9 col-lg-9">
      <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}">Admin</a></li>
            <li class="active">
                Images 
                <small>
                    @if($images->Total() > 0) - {{ $images->Total() }} total @endif
                    @if(Input::has('search_terms'))
                    <span class="text-muted">
                        - search results for "{{ Input::get('search_terms') }}"
                    </span>
                </small>
                @endif
            </li>        
        </ol>
    </div>
    
</div>

<div class="col-sm-5 col-md-3 col-lg-3 pull-right">
    <form method="GET" action="{{ url('admin/images') }}">
        <div class="input-group">
            <input type="text" name="search_terms" class="form-control" value="{{ Input::get('search_terms') }}" placeholder="Search images" required>
            
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
            </span>
            
        </div>
    </form>
</div>

</div>

@if($images->isEmpty())

<div style="text-align:center">
    <h3 class="text-muted">No images</h3>
</div>

@else

@include('admin/images/table')
<div>
    {!! $images->appends(array('search_terms' => Input::get('search_terms')))->render() !!}
</div>

<div class="btn-group">
  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ $settings->admin_images_pagination }} per page <span class="caret"></span>
</button>
<ul class="dropdown-menu">
    <li><a href="{{ url('admin/images/update-pagination/7') }}">7</a></li>
    <li><a href="{{ url('admin/images/update-pagination/20') }}">20</a></li>
    <li><a href="{{ url('admin/images/update-pagination/30') }}">30</a></li>
    <li><a href="{{ url('admin/images/update-pagination/50') }}">50</a></li>
    <li><a href="{{ url('admin/images/update-pagination/100') }}">100</a></li>    
</ul>
</div>
@endif



@stop