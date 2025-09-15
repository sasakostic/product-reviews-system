<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ url('images/favicon.ico') }}">

	<title>Error</title>

	<!-- Bootstrap core CSS -->
  <link href="{{ url('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
  <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ url('assets/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

    </head>

    <body>

     <div class="navbar navbar-top" role="navigation">
      <div>
       <div class="navbar-header">

        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('images/logo.png') }}" style="width:150px;height:40px; margin-top:-10px;"></a>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>            
       </button>
     </div>
     <div class="collapse navbar-collapse">

      <ul class="nav navbar-nav">
        <li  id="menu_home">
          <a href="{{ url('/') }}">Home</a>
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
   <a href="{{ url('write_review') }}" class="btn btn-success btn-sm navbar-btn pull-right">
     Write review
   </a>

 </div><!--/.nav-collapse -->
</div>
</div>

<div class="container" style="text-align: center">
  @section('content')

  @show      
  <div>
    <a href="javascript:history.go(-1);">Back</a>
  </div>
</div><!-- /.container -->

<script src="{{ url('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
