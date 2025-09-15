<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="@if(isset($meta_description)){{$meta_description}}@endif">
	<link rel="shortcut icon" href="{{ url('images') }}/{{ $settings->favicon }}">
	<meta name="csrf-token" content="{{{ csrf_token() }}}" />

	<title>{{ $settings->site_name }} - @yield('title')</title>

	<script type="text/javascript" src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>
  <script type="text/javascript">
    var APP_URL = "{!! url('/') !!}";
  </script>

  <!-- Bootstrap core CSS -->
  <link href="{{ url('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
  <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ url('assets/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      {!! $settings->header_code !!}
      
    </head>

    <body>

     <div class="navbar navbar-top navbar-inverse" role="navigation">
      <div>
       <div class="navbar-header">

        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('images') }}/{{ $settings->logo }}" style="width:150px;height:40px; margin-top:-10px;"></a>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>            
       </button>
     </div>
     <div class="collapse navbar-collapse">

      <ul class="nav navbar-nav">
       <li class="{{ ($menu_highlight == 'products') ? 'active' : '' }}">
        <a href="{{ url('/products') }}">Products</a>
      </li>
      <li class="{{ ($menu_highlight == 'reviews') ? 'active' : '' }}">
        <a href="{{ url('/reviews') }}">Reviews</a>
      </li>
      <li class="{{ ($menu_highlight == 'categories') ? 'active' : '' }}">
        <a href="{{ url('/categories') }}">Categories</a>
      </li>
      <li class="{{ ($menu_highlight == 'brands') ? 'active' : '' }}">
        <a href="{{ url('/brands') }}">Brands</a>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right" style="@if (Auth::Guest())display:none @endif">
     <li id="menu_account" class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <b class="caret"></b></a>
      <ul class="dropdown-menu">
       <li><a href="{{ url('/account') }}"><i class="fa fa-user"></i> Account</a></li>
       <li><a href="{{ url('/account/favorites') }}"><i class="fa fa-star"></i> Favorites</a></li>
       <li><a href="{{ url('/account/reviews') }}"><i class="fa fa-comment"></i> Reviews</a></li>
       @if($settings->users_list_product_images)
       <li><a href="{{ url('account/images') }}"><i class="fa fa-photo"></i> Images</a></li>
       @endif
       <li class="divider"></li>
       <li id="header_admin_menu" style="@if(!Auth::Guest() && Auth::user()->admin == 1)
        @else display:none
        @endif"><a href="{{ url('/admin') }}">Admin</a></li>
        <li class="divider" style="@if(!Auth::Guest() && Auth::user()->admin == 1)
         @else display:none
         @endif"></li>
         <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i> Log out</a></li>
       </ul>
     </li>
   </ul>
   <ul id="header_login_menu" style="@if (!Auth::Guest())display:none @endif" class="nav navbar-nav navbar-right">
     <li id="menu_register" class="hidden-sm">
      <a href="{{ url('register') }}">Join</a>
    </li>
    <li id="menu_login">
      <a href="{{ url('login') }}">Login</a>
    </li>                          
  </ul>
  <form class="navbar-form navbar-right" method="GET" action="{{ url('search?') }}">
   <div class="input-group">
    <input type="text" name="search_terms" class="form-control" value="@if(isset($search_terms)){{ $search_terms }}@endif" placeholder="Search" required>

    <span class="input-group-btn">
     <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
   </span>
 </div>
</form>
<a href="{{ url('products/find') }}" class="btn btn-success btn-sm navbar-btn pull-right">
 Write review
</a>

</div><!--/.nav-collapse -->
</div>
</div>

<div class="container">
  @section('content')

  @show      
</div><!-- /.container -->

<div class="clearfix"></div>
<div class="container footer" align="center">

  <div class="clearfix text-muted">
   @if($settings->facebook <> '')<a href="{{ $settings->facebook }}" target="_blank"><img src="{{ url('images/facebook.png')}}"></a>@endif
   @if($settings->twitter <> '')<a href="http://twitter.com/{{ $settings->twitter }}" target="_blank"><img src="{{ url('images/twitter.png')}}"></a>@endif
   @if($settings->youtube <> '')<a href="{{ $settings->youtube }}" target="_blank"><img src="{{ url('images/youtube.png')}}"></a>@endif
 </div>
 <div class="clearfix">
   @if(isset($pages))
   @foreach($pages as $page)
   <span class="item-name"><a href="{{ url('page/'.$page->slug) }}">{{$page->title}}</a> &nbsp;</span>
   @endforeach
   @endif
   <a href="{{ url('contact') }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-comment"> Contact Us</span></a>
   </div  
 </div>

 <script type="text/javascript">
   $(function(){
    $.ajaxSetup({
     headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    });//document ready
  </script>

  <script src="{{ url('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
  <div class="clearfix text-muted">
   {!! $settings->footer_code !!}
 </div>
</body>
</html>
