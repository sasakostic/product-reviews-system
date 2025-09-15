@extends('installation.home')
@section('installation_step')

@include('alerts')

<script type="text/javascript">
  $(function(){
    $('#show_hide').click(function(){
      if($('#password').prop('type') == 'text') {
        $('#password').prop('type', 'password');
        $('#show_hide').text('show');
      } else {
        $('#password').prop('type', 'text');
        $('#show_hide').text('hide');
      }
    });
    
    disable_button = function(){
      $('#install_button').prop('disabled', true);
      $('#install_button').text('Installing...');
      }

  });//document ready
</script>

<div>
  <form name="installation_form" onsubmit="disable_button();" method="POST" action="{{ URL::to('install/setup') }}">
    <div>

      <h3 class="page-header">Required information</h3>
      
      <div class="row">
        <div class="form-group col-lg-3 col-md-3 col-sm-5  @if ($errors->has('site_title')) has-error @endif">
          <label>Site title</label>
          <input type="text" name="site_title" class="form-control" value="{{ Input::old('site_title') }}" required autofocus>
          @if ($errors->has('site_title')) @foreach($errors->get('site_title') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
        </div>
      </div>

      <div class="row">
        <div class="form-group col-lg-3 col-md-3 col-sm-5  @if ($errors->has('username')) has-error @endif">
          <label>Admin username</label>
          <input type="text" name="username" class="form-control" value="{{ Input::old('username') }}" required autofocus>
          @if ($errors->has('username')) @foreach($errors->get('username') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
        </div>
      </div>
      
      <div class="row">
        <div class="form-group col-lg-3 col-md-3 col-sm-5 @if ($errors->has('password')) has-error @endif">
          <label>Admin password</label> <a href="javascript:" id="show_hide">show</a>
          <input type="password" name="password" id="password" class="form-control" value="{{ Input::old('password') }}" required>
          @if ($errors->has('password')) @foreach($errors->get('password') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
        </div>
      </div>
      
      <div class="row">
        <div class="form-group col-lg-3 col-md-3 col-sm-5 @if ($errors->has('email')) has-error @endif">
          <label>E-mail</label>
          <input type="email" name="email" class="form-control" value="{{ Input::old('email') }}" required>
          @if ($errors->has('email')) @foreach($errors->get('email') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
        </div>
      </div>
    </div>
    
    <div class="form-group">
      <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
      <button type="submit" name="install_button" id="install_button" class="btn btn-primary">Install application</button>
    </div>

  </form>
</div>
@stop