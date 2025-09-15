@extends('layout')
@section('title', 'Account')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
        if($('#country').val() == 'US') $('#states').show(); 

        $('#country').change(function(){
            if($(this).val() == 'US') {
                $('#states').show(); 
                $('#states').focus(); 
            } else $('#states').hide();
        });
        $('#country').click(function(){
            if($(this).val() == 'US') $('#states').show(); else $('#states').hide();
        });
    });//document ready
</script>

<div class="col-lg-2 col-md-2 col-sm-2">
    @include('account/sidebar')
</div>
<div class="col-lg-10 col-md-10 col-sm-10">
    <form method="POST" action="{{ url('account/update') }}" role="form" class="form-signin">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('account') }}">Account</a></li>
                <li class="active">edit</li>
            </ol>
        </div>


        @if(Auth::user()->active == 0)
        <div class="form-group">
            Account is currently inactive until e-mail gets confirmed. If you haven't received confirmation e-mail you can <a href="{{ url('account/resend-confirmation') }}"><b>resend it</b></a>
        </div>
        @endif

        <div class="form-group">
            <a href="{{ url('user/'.Auth::user()->id.'/'.Auth::user()->username)}}" target="_blank">My public profile</a>    
        </div>

        <div class="row">            
            <div class="form-group col-sm-3 col-md-3 col-lg-3">
                <label>First name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $user->profile->first_name }}">
            </div>            
        </div>

        <div class="row">
            <div class="form-group col-sm-3 col-md-3 col-lg-3">    
                <label>Last name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $user->profile->last_name }}">
            </div>        
        </div>

        <div class="row">
            <div class="form-group col-sm-2 col-md-2 col-lg-2">    
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value=""></option>
                    <option value="m" @if($user->profile->gender == 'm') selected="selected" @endif >Male</option>
                    <option value="f" @if($user->profile->gender == 'f') selected="selected" @endif >Female</option>
                </select>                
            </div>            
        </div>

        <div>
            <label>Birth date</label>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 col-md-2 col-lg-2">
                {!! Form::select('month', $months, $user->profile->month, array('class'=>'form-control', 'id' => 'month')) !!}
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                {!! Form::select('day', $days, $user->profile->day, array('class'=>'form-control', 'id' => 'day')) !!}
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <input type="text" name="year" class="form-control" maxlength="4" value="{{ $user->profile->year }}">
            </div>            
        </div>

        <div class="row">
           <div class="form-group col-sm-8 col-md-8 col-lg-8">  
            <label>About</label>
            <textarea name="about" rows="6" class="form-control">{{ $user->profile->about }}</textarea>
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-sm-3 col-md-3 col-lg-3">
            <label>Web site</label>
            <input type="text" name="website" class="form-control" value="{{ $user->profile->website }}">
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-sm-3 col-md-3 col-lg-3">
            <label>Facebook</label>
            <input type="text" name="facebook" class="form-control" value="{{ $user->profile->facebook }}">
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-sm-3 col-md-3 col-lg-3">
            <label>Twitter username</label>
            <input type="text" name="twitter" class="form-control" value="{{ $user->profile->twitter }}">
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-sm-3 col-md-3 col-lg-3">
            <label>Youtube link</label>
            <input type="text" name="youtube" class="form-control" value="{{ $user->profile->youtube }}">
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-sm-3 col-md-3 col-lg-3">
            <label>Instagram username</label>
            <input type="text" name="instagram" class="form-control" value="{{ $user->profile->instagram }}">
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-sm-3 col-md-3 col-lg-3">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ $user->profile->city }}">            
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-sm-3 col-md-3 col-lg-3">
            <div class="select-box">
                <label>Country</label>
                {!! Form::select('country', $countries, $user->profile->country, array('class'=>'form-control selectpicker', 'data-live-search'=>'true', 'id' => 'country')) !!}
            </div>
            <div id="states" style="display:none">
                <label>State</label>                
                {!! Form::select('state', $states, $user->profile->state, array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) !!}
            </div>
        </div>        
    </div>

    <div class="form-group">
        <label>E-mail:</label>
        {{ Auth::user()->email }} <a href="{{ url('account/edit-email')}}">change</a>
    </div>

    <div class="form-group">
        <a href="{{ url('account/edit-password')}}">Change password</a>
    </div>

    <div class="form-group">
        {{ csrf_field() }}
        <button class="btn btn-primary" type="submit">Update</button>
    </div>

</form>
</div>
@stop