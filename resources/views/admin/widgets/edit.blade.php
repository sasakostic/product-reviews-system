@extends('admin/layout')
@section('title', 'Edit Widget')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div class="row">
  <ol class="breadcrumb">
      <li><a href="{{ url('admin') }}">Admin</a></li>
      <li><a href="{{ url('admin/widgets') }}">Widgets</a></li>
      <li>
          <a href="{{ url('admin/widgets') }}/{{ $widget->id }}" target="_blank">{{ $widget->slug }}</a>
      </li>
      <li class="active">edit</li>        
  </ol>
</div>

<form action="{{ url('admin/widgets') }}/{{ $widget->id }}" method="POST" role="form">

    <div class="form-group">
        <label>HTML/JS code:</label>
        <textarea name="code" class="form-control" rows="10" autofocus>{{ $widget->code }}</textarea>
    </div>

    <div class="text-muted form-group">
        <small>
            Created: {{ date($settings->date_format,strtotime($widget->created_at)) }} | updated: {{ date($settings->date_format,strtotime($widget->updated_at)) }}
        </small>
    </div>

    <div class="pull-left">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" name="save_new_ad" class="btn btn-primary">Save</button>    
    </div>    
    <div class="pull-right">
        <a href="{{ url('admin/widgets') }}/{{ $widget->id }}" target="_blank" title="View">Preview</a>
    </div>

</form>

@stop