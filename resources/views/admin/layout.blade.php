<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{{ csrf_token() }}}" />
  <link rel="shortcut icon" href="{{ url('images') }}/{{ $settings->favicon }}">

  <title>@yield('title') - {{ $settings->site_name }}</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ url('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
  <link href="{{ url('assets/libs/bootstrap/css/bootstrap-admin-custom.css') }}" rel="stylesheet"> 
  <link href="{{ url('assets/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="{{ url('assets/css/admin/dashboard.css') }}" rel="stylesheet">
  <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">

  <script type="text/javascript" src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>

  <script type="text/javascript">
    $(function(){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
      });
      
    });//document ready
  </script>
  <script type="text/javascript">
    var APP_URL = "{!! url('/') !!}";
  </script>

  <!--[if lt IE 9]><script src="../../js/ie8-responsive-file-warning.js"></script><![endif]-->
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    {!! $settings->header_code !!}
  </head>
  <body>
    <div class="navbar navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url('/admin') }}">Admin Panel</a>        
          <a href="{{ url('/') }}" class="navbar-brand nav-btn btn btn-default btn-xs" target="_blank">View site</a>        
        </div>
        <div class="navbar-collapse collapse">
          <div class="visible-xs" >
            <form method="GET" action="{{ url('admin/search') }}">
              <div class="input-group">
                <input type="text" name="search_terms_all" class="form-control" value="{{ Input::get('search_terms_all') }}" placeholder="Search..." required>

                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </form>
          </div>
          <ul class="nav navbar-nav visible-xs">
            <li><a href="{{ url('/admin') }}">Overview</a></li>
            <li><a href="{{ url('/admin/products') }}">Products</a></li>
            <li><a href="{{ url('/admin/reviews') }}">Reviews</a></li>
            <li><a href="{{ url('/admin/images') }}">Images</a></li>
            <li><a href="{{ url('/admin/categories') }}">Categories</a></li>
            <li><a href="{{ url('/admin/brands') }}">Brands</a></li>                
            <li><a href="{{ url('/admin/users') }}">Users</a></li>                
            <li class="divider"></li>                
            <li><a href="{{ url('/admin/users') }}">Widgets</a></li>                
            <li><a href="{{ url('/admin/users') }}">Pages</a></li>                
            <li><a href="{{ url('/admin/users') }}">Settings</a></li>                
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="{{ url('account') }}"><span class="fa fa-user"></span> Account</a></li>
                <li class="divider"></li>
                <li><a href="{{ url('logout') }}">Log out</a></li>
              </ul>
            </li>
          </ul>                 
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div>
        <div class="col-sm-3 col-md-2 col-xs-3 sidebar">
          <ul class="nav nav-sidebar">
            <li>
              <div class="form-group" style="padding:15px">
                <form method="GET" action="{{ url('admin/search') }}">
                  <div class="input-group">
                    <input type="text" name="search_terms_all" class="form-control" value="{{ Input::get('search_terms_all') }}" placeholder="Search..." required>
                    
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                  </div>
                </form>
              </div>
            </li>
            <li class="{{ ($sidebar_highlight == '') ? 'active' : '' }}">
              <a href="{{ url('/admin') }}"><i class="fa fa-home"></i> Overview</a>
            </li>
            <li class="{{ ($sidebar_highlight == 'products') ? 'active' : '' }}">
              <a href="{{ url('/admin/products') }}"><i class="fa fa-list"></i> Products</a>
            </li>
            <li class="{{ ($sidebar_highlight == 'reviews') ? 'active' : '' }}">
              <a href="{{ url('/admin/reviews') }}"><i class="fa fa-comment"></i> Reviews</a>
            </li>
            <li class="{{ ($sidebar_highlight == 'images') ? 'active' : '' }}">
              <a href="{{ url('/admin/images') }}"><i class="fa fa-photo"></i>  Images</a>
            </li>
            <li class="{{ ($sidebar_highlight == 'categories') ? 'active' : '' }}">
              <a href="{{ url('/admin/categories') }}"><i class="fa fa-th"></i> Categories</a>
            </li>
            <li class="{{ ($sidebar_highlight == 'brands') ? 'active' : '' }}">
              <a href="{{ url('/admin/brands') }}"><i class="fa fa-gift"></i> Brands</a>
            </li>
            <li class="{{ ($sidebar_highlight == 'users') ? 'active' : '' }}">
              <a href="{{ url('/admin/users') }}"><i class="fa fa-users"></i> Users</a>
            </li> 
          </ul>
          <div class="sidebar-footer">
            <a href="{{ url('admin/widgets') }}" title="Widgets">
              <span class="fa fa-cogs"></span>
            </a>
            <a href="{{ url('admin/pages') }}" title="Pages">
              <span class="fa fa-file-text"></span>
            </a>
            <a href="{{ url('admin/settings') }}" title="Settings">
              <span class="fa fa-cog"></span>
            </a>              
          </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
         @section('content')


         @show
       </div>
     </div>
   </div>

   <script src="{{ url('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
   
 </body>
 </html>