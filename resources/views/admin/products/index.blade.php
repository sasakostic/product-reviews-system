@extends('admin/layout')
@section('title', 'Manage Products')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

<script type="text/javascript" src="{{ url('assets/js/username_hover.js') }}"></script>

<script type="text/javascript">
    $(function(){
        $('#advanced').click(function(){
            $('#advanced_div').toggle();
            //$('#simple_search').toggle();
            $('#advanced_sarch_terms').focus();
        });
    });//document ready
</script>

<div class="row page-header">

  <div class="col-sm-7 col-md-8 col-lg-8">
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Admin</a></li>
        <li class="active">Products @if($products->Total() > 0)  <small><span class="text-muted"> - {{ $products->Total() }} total</span></small>@endif @if(Input::has('name'))
            <small>
                <span class="text-muted">
                    - search results for "{{ Input::get('name') }}"
                </span>
            </small>
            @endif</li>        
        </ol>
    </div>
    
</div>

<div class="col-sm-5 col-md-4 col-lg-4 pull-right">
  <div id="simple_search">
      <form method="GET" action="{{ url('admin/products/search') }}">
        <div class="input-group">
            <input type="text" name="name" class="form-control" value="{{ Input::get('name') }}" placeholder="Search products">      
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                <a href="javascript:" class="btn btn-default" id="advanced">advanced</a>
            </span>
        </div>
    </form>
</div>
</div>

</div>

<div id="advanced_div" @if(!Input::has('category_id') && !Input::has('brand_id') && !Input::has('status') && !Input::has('id') && !Input::has('user')) style="display:none" @endif class="row">
   <form method="GET" action="{{ url('admin/products/search') }}">
    <div class="form-group col-md-2">
        <input type="text" name="name" id="advanced_sarch_terms" class="form-control" value="{{ Input::get('name') }}" placeholder="Product name">      
    </div>
    <div class="form-group col-md-2">
        <select name="category_id" class="form-control selectpicker" data-live-search="true">
            <option value="">-All categories-</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @if(Input::get('category_id') == $category->id) selected="seleted" @endif>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-2">
        <select name="brand_id" class="form-control selectpicker" data-live-search="true">
            <option value="">-All brands-</option>
            @foreach($brands as $brand)
            <option value="{{ $brand->id }}" @if(Input::get('brand_id') == $brand->id) selected="seleted" @endif >{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-2">
        <select name="status" class="form-control">
            <option value="">-Status-</option>
            <option value="1" @if(Input::get('status') == "1") selected="seleted" @endif>Published</option>
            <option value="0" @if(Input::get('status') == "0") selected="seleted" @endif >Unpublished</option>
            <option value="discontinued" @if(Input::get('status') == "discontinued") selected="seleted" @endif >Discontinued</option>
        </select>
    </div>
    <div class="form-group col-md-1">
        <input type="text" name="id" id="id" class="form-control" value="{{ Input::get('id') }}" placeholder="ID">      
    </div>
    <div class="form-group col-md-1">
        <input type="text" name="user" class="form-control" value="{{ Input::get('user') }}" placeholder="User">
    </div>      
    <div class="form-group col-md-2">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>                  
</form>
</div>

<div class="form-group">  
    <div class="pull-right">
        <a href="{{ url('admin/products/create') }}" class="btn btn-default btn-xs">New product</a>                                   
    </div>                    

</div>

@if($products->isEmpty())

<div style="text-align:center">
    <h3 class="text-muted">No products</h3>
</div>

@else

@include('admin/products/table')

<div>
    {!! $products->appends(array('name' => Input::get('name'), 'category_id' => Input::get('category_id'), 'brand_id' => Input::get('brand_id'), 'published' => Input::get('published'),'reported' => Input::get('reported'), 'user' => Input::get('user')))->render() !!}
</div>

<div class="btn-group">
  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ $settings->admin_products_pagination }} per page <span class="caret"></span>
</button>
<ul class="dropdown-menu">
    <li><a href="{{ url('admin/products/update-pagination/7') }}">7</a></li>
    <li><a href="{{ url('admin/products/update-pagination/20') }}">20</a></li>
    <li><a href="{{ url('admin/products/update-pagination/30') }}">30</a></li>
    <li><a href="{{ url('admin/products/update-pagination/50') }}">50</a></li>
    <li><a href="{{ url('admin/products/update-pagination/100') }}">100</a></li>    
</ul>
</div>

</div>

@endif

@stop