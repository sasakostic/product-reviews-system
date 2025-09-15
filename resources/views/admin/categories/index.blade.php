@extends('admin/layout')
@section('title', 'Manage Categories')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div class="row page-header">

    <div class="col-md-9 col-lg-9">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('admin') }}">Admin</a></li>
                <li class="active">
                    Categories
                    <small>
                     - {{ $categories->Total() }} total
                     @if(Input::has('search_terms'))
                     <span class="text-muted">
                        - search results for "{{ Input::get('search_terms') }}"
                    </span>

                    @endif
                </small>
            </li>        
        </ol>
    </div>
</div>

<div class="col-md-3 col-lg-3 pull-right">
    <form method="GET" action="{{ url('admin/categories/search') }}">
        <div class="input-group">
            <input type="text" name="search_terms" class="form-control" value="{{ Input::get('search_terms') }}" placeholder="Search categories" required>

            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
</div>

</div>

<div>
    <div class="form-group pull-right">
        <a href="{{ url('admin/categories/create') }}" class="btn btn-default btn-xs">New category</a>        
    </div>    
</div>

@if($categories->isEmpty())

<div style="text-align:center">
    <h3 class="text-muted">No categories</h3>
</div>

@else

@include('admin/categories/table')

<div>
    {!! $categories->appends(array('search_terms' => Input::get('search_terms')))->render() !!}
</div>

@endif

<div class="btn-group">
  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ $settings->admin_categories_pagination }} per page <span class="caret"></span>
</button>
<ul class="dropdown-menu">
    <li><a href="{{ url('admin/categories/update-pagination/7') }}">7</a></li>
    <li><a href="{{ url('admin/categories/update-pagination/20') }}">20</a></li>
    <li><a href="{{ url('admin/categories/update-pagination/30') }}">30</a></li>
    <li><a href="{{ url('admin/categories/update-pagination/50') }}">50</a></li>
    <li><a href="{{ url('admin/categories/update-pagination/100') }}">100</a></li>    
</ul>
</div>

@stop