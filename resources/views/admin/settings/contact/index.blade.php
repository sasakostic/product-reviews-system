@extends('admin/layout')
@section('content')
@section('title', 'Manage Contact Settings')
@include('admin/settings/menu')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<form action="{{ url('admin/settings/update-contact-settings')}}" method="POST">

	<div class="form-group">
		<div class="checkbox">
			<input type="checkbox" name="recaptcha_contact" id="recaptcha_contact" class="styled" value="1" @if($settings->recaptcha_contact == 1) checked="checked" @endif>
			<label for="recaptcha_contact">
				Enable reCAPTCHA for contact page
			</label>
		</div>
	</div>

	<div class="row">
		<div id="recaptcha_public_key_row" @if($settings->recaptcha_contact == 0) style="display:none" @endif>

			<div class="form-group col-md-5">
				<label>reCAPTCHA public key</label>
				<input type="text" name="recaptcha_public_key" class="form-control" value="{{ $recaptcha_public_key }}" >
			</div>
		</div>        
	</div>

	<div class="row">
		<div id="recaptcha_private_key_row" @if($settings->recaptcha_contact == 0) style="display:none" @endif>
			<div class="form-group col-md-5">
				<label>reCAPTCHA  private key</label>
				<input type="text" name="recaptcha_private_key" class="form-control" value="{{ $recaptcha_private_key }}">
			</div>
		</div>
	</div>

	<div class="form-group">
		{{ csrf_field() }}
		<button type="submit" class="btn btn-primary">Save settings</button>
	</div>	
	
</form>

<script type="text/javascript">
	$(function(){
		
		$('#recaptcha_contact').change(function(){
			if($('#recaptcha_contact').is(':checked')) {
				$('#recaptcha_private_key_row').show();
				$('#recaptcha_public_key_row').show();
			} 
			if(!$('#recaptcha_contact').is(':checked')) {
				$('#recaptcha_private_key_row').hide();
				$('#recaptcha_public_key_row').hide();
			} 
		});

    });//document ready
</script>

@stop