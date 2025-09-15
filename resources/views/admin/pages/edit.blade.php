@extends('admin/layout')
@section('title', 'Edit Page')
@section('content')

@include('alerts')

<script src="{{ url('assets/libs/ckeditor/ckeditor.js') }}"></script>

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin/pages') }}">Pages</a></li>
    <li><a href="{{ url('page') }}/{{ $page->slug }}" target="_blank">{{ $page->title }}</a></li>
    <li class="active">edit</li>        
</ol>
</div>

<div class="form-group">    
    <a href="{{ url('admin/pages/create') }}" class="btn btn-default btn-xs pull-right">New page</a>  
</div>

<form action="{{ url('admin/pages/'.$page->id) }}" method="POST" role="form">

    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $page->title }}" required autofocus>
    </div>
    
    <div class="form-group">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ $page->slug }}" autofocus>
    </div>
    
    <div class="form-group">
        <label>Content</label>
        <textarea name="content" class="form-control ckeditor" rows="10">{!! nl2br($page->content) !!}</textarea>
    </div>
    
    <div class="form-group">
        <div class="text-muted form-group"><small>Created: {{ $page->created_at }}</small></div>
        <div class="text-muted form-group"><small>Updated: {{ $page->updated_at }}</small></div>
    </div>
    
    <div class="form-group">

        <div class="pull-left">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" name="update" value="update" class="btn btn-primary">Update</button>
            <button type="submit" name="update" value="update_and_new" class="btn btn-default">Update & New</button>
        </div>
        
        <div class="pull-right">
            <a href="{{ url('admin/pages/delete/'.$page->id.'/0') }}" onClick="return confirm('Confirm deletion')" class="btn btn-default">Delete</a>
        </div>
    </div>
    
</form>
@stop