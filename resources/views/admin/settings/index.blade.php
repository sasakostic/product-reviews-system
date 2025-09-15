@extends('admin/layout')
@section('title', 'Manage Settings')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div>
    @include('admin/settings/menu')
</div>

<form action="{{ url('admin/settings/update-settings') }}" method="POST" enctype='multipart/form-data' 
role="form">

<div>
    <label>Site name</label>
</div>

<div class="row">
    <div class="fogm-group col-lg-6 col-md-6 col-sm-6">
        <input type="text" name="site_name" class="form-control" value="{{$settings->site_name}}" />
    </div>
</div>

<div>
    <label>Meta description</label>
</div>

<div class="row">
    <div class="fogm-group col-lg-8 col-md-8 col-sm-8">
        <textarea name="meta_description" class="form-control" rows="2">{{$settings->meta_description}}</textarea>
    </div>
</div>

<div>
    <label>Header html/js code</label>
</div>

<div class="row">
    <div class="form-group col-lg-8 col-md-8">
        <textarea name="header_code" class="form-control" rows="2">{{ $settings->header_code }}</textarea>        
    </div>
</div>

<div>
    <label>Footer html/js code</label>
</div>

<div class="row">
    <div class="fogm-group col-lg-8 col-md-8 col-sm-8">
        <textarea name="footer_code" class="form-control" rows="2">{{$settings->footer_code}}</textarea>
    </div>
</div>

<div>
    <h3>Logo & favicon</h3>
</div>

<div class="form-group">
    <label>Logo
        <div style="cursor:pointer; background-color:#f8f8f8">
            <img src="{{ url('images') }}/{{ $settings->logo }}" style="width:200px; height:90px">
        </div>
        <input type="file" name="logo" style="cursor:pointer" /></label>
    </div>


    
    <div class="form-group">
        <label>Favicon
            <div style="cursor:pointer; background-color:#f8f8f8">
                <img src="{{ url('images') }}/{{ $settings->favicon }}" />
            </div>
            <input type="file" name="favicon" style="cursor:pointer"/></label>
        </div>

        <div>
            <h3>Social media</h3>
        </div>


        <div class="row">

            <div class="fogm-group col-lg-4 col-md-4 col-sm-4">
                <label>Facebook link</label>
                <input type="text" name="facebook" class="form-control" value="{{$settings->facebook}}" />
            </div>

            <div class="fogm-group col-lg-2 col-md-2 col-sm-2">
                <label>Twitter username</label>
                <input type="text" name="twitter" class="form-control" value="{{$settings->twitter}}" />
            </div>

            <div class="fogm-group col-lg-4 col-md-4 col-sm-4">
                <label>Youtube link</label>
                <input type="text" name="youtube" class="form-control" value="{{$settings->youtube}}" />
            </div>

        </div>    

        <div>
            <h3>Pagination</h3>
        </div>

        <div>
            <label>Front-end items per page</label>
        </div>

        <div class="row">
            <div class="col-md-1 form-group">
                <input type="text" name="front_end_pagination" class="form-control" value="{{ $settings->front_end_pagination }}" required>
            </div>
        </div> 

        <div class="form-group">
            {{ csrf_field() }}
            <button type="submit" name="save_new_user" class="btn btn-primary">Save settings</button>
        </div>

    </form>
    
    @stop