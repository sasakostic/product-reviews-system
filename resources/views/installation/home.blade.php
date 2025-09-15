<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="{{ url('images/favicon.ico') }}">
  <title>Product Reviews Installation</title>
  <script src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>
  <link href="{{ url('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> 
</head>
<body>
  <div class="navbar navbar-inverse navbar-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <span class="navbar-brand">Product Reviews Installation</span>
      </div>
      <div class="collapse navbar-collapse">        
      </div><!--/.nav-collapse -->
    </div>
  </div>
  <div class="container">
    @section('installation_step')

    @show
  </div><!-- /.container -->
  <script src="{{ url('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>