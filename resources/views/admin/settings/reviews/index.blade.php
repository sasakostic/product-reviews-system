@extends('admin/layout')
@section('title', 'Manage Reviews Settings')
@section('content')

@include('alerts')

<script src="{{ url('assets/libs/ckeditor/ckeditor.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

@include('admin/settings/menu')

<form action="{{ url('admin/settings/update-reviews-settings')}}" method="POST">


    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_title" id="review_title" class="styled"  value="1" @if($settings->review_title == 1) checked="checked" @endif> 
            <label for="review_title">
                Enable reviews title
            </label>
        </div>
    </div>
    
    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_pros_cons" id="review_pros_cons" class="styled" value="1" @if($settings->review_pros_cons == 1) checked="checked" @endif>
            <label for="review_pros_cons">
                Enable pros/cons for reviews
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_helpful" id="review_helpful" class="styled" value="1" @if($settings->review_helpful == 1) checked="checked" @endif>
            <label for="review_helpful">
                Enable marking reviews as helpful
            </label>
        </div>
    </div>
    
    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_favorite" id="review_favorite" class="styled" value="1" @if($settings->review_favorite == 1) checked="checked" @endif>
            <label for="review_favorite">
                Enable marking reviews as favorite
            </label>
        </div>
    </div>
    
    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_report" id="review_report" class="styled"  value="1" @if($settings->review_report == 1) checked="checked" @endif>
            <label for="review_report">
                Enable review reporting
            </label>
        </div>
    </div>

    <div id="reporting_reasons_div">
        <div>
            <label>Reporting reasons</label>
        </div>  

        @include('admin/settings/reviews/reasons')
        
    </div>

    <div>
        <label>Review lenght</label>
    </div>

    <div class="row">
        <div class="form-group col-md-1 col-sm-2 col-lg-1">
            <input type="text" name="review_len" class="form-control" value="{{ $settings->review_len }}">
        </div>        
    </div>

    <div>
        <label>Reviews preview length</label>
    </div>

    <div class="row">
        <div class="form-group col-md-1 col-sm-2 col-lg-1">
            <input type="text" name="review_preview_len" class="form-control" value="{{ $settings->review_preview_len }}">
        </div>        
    </div>

    <div>
        <label>Writting tips</label>
    </div>

    <div class="form-group">
        <textarea name="review_writing_tips" class="form-control ckeditor" rows="7">{{ $settings->review_writing_tips }}</textarea>
    </div>
    
    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_edit" id="review_edit" class="styled"  value="1" @if($settings->review_edit == 1) checked="checked" @endif>
            <label for="review_edit">
                Users can edit their reviews
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_delete" id="review_delete" class="styled" value="1" @if($settings->review_delete == 1) checked="checked" @endif>
            <label for="review_delete">
                Users can delete their reviews
            </label>
        </div>

    </div>

    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="review_moderation" id="review_moderation" class="styled" value="1" @if($settings->review_moderation == 1) checked="checked" @endif> 
            <label for="review_moderation">
                Require reviews to be approved after submission
            </label>
        </div>
    </div>

    <div>
        <label>Date format</label>
    </div>

    <div class="row">
        <div class="form-group col-sm-2 col-md-2 col-lg-2">
            <select name="date_format" class="form-control">
                <option value="M j, Y" @if($settings->date_format == "M j, Y")selected="selected"@endif>{{ date($settings->date_format, time() ) }}</option>
                <option value="j M, Y" @if($settings->date_format == "j M, Y")selected="selected"@endif>{{ date("j M, Y", time() ) }}</option>
                <option value="F j, Y g:i a" @if($settings->date_format == "F j, Y g:i a")selected="selected"@endif>{{ date("F j, Y g:i a", time() ) }}</option>

            </select>            
        </div>
    </div>

    
    <div class="form-group">
        {{ csrf_field() }}
        <button type="submit" name="submit_button" class="btn btn-primary">Save settings</button>
    </div>        
    
</form>

@stop