<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="@if(isset($meta_description)){{$meta_description}}@endif">
<link rel="shortcut icon" href="{{ url('images') }}/{{ $settings->favicon }}">
<meta name="csrf-token" content="{{{ csrf_token() }}}" />

<title>Dev</title>

<script type="text/javascript" src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>

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

  <div class="navbar navbar-inverse navbar-top" role="navigation">
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
            
        </div><!--/.nav-collapse -->
    </div>
</div>

  <div class="container">
    @section('content')

    @show      
  </div><!-- /.container -->

  <div class="clearfix"></div>
<div class="container footer" align="center">  

  <script type="text/javascript">
    $(function(){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });//document ready
  </script>

  <script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>
