@extends('admin/layout')
@section('title', 'Edit Product')
@section('content')

@include('alerts')

<script type="text/javascript" src="{{ url('assets/js/admin/unflag.js') }}"></script>

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<script src="{{ url('assets/libs/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript" src="{{ url('assets/libs/swipebox/lib/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/libs/swipebox/js/jquery.swipebox.js') }}"></script>

<link href="{{ url('assets/libs/swipebox/css/swipebox.css') }}" rel="stylesheet">

<script type="text/javascript">
  ;( function( $ ) {
    $( '.swipebox' ).swipebox( {
useCSS : true, // false will force the use of jQuery for animations
useSVG : true, // false to force the use of png for buttons
initialIndexOnArray : 0, // which image index to init when a array is passed
hideCloseButtonOnMobile : false, // true will hide the close button on mobile devices
hideBarsDelay : 0, // delay before hiding bars on desktop
videoMaxWidth : 1140, // videos max width
beforeOpen: function() {}, // called before opening
afterOpen: null, // called after opening
afterClose: function() {}, // called after closing
loopAtEnd: false // true will return to the first image after the last image is reached
} );
  } )( jQuery );
</script>

<div class="row">
  <ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Admin</a></li>
    <li><a href="{{ url('admin/products') }}">Products</a></li>
    <li>
      <a href="{{ url('product/'.$product->id.'/'.$product->slug) }}" target="_blank">{{ $product->name }}</a>
    </li>
    <li class="active">edit</li>        
  </ol>
</div>

@if($product->reported == 1)
<tr>
  <td colspan="10">       
   <a href="javascript:unflag_product({{ $product->id }})" class="btn close" id="cross_{{$product->id}}">&times;</a>
   <div id="reported_{{ $product->id }}" class="alert alert-warning alert-block item-name" style="margin-top:-8px">

    @foreach($product->reports->take(100) as $report)
    <div class="text-muted" style="word-wrap: break-word;">
      <b>Reported by <a href="{{ url('admin/user/'.$report->user_id.'/details') }}">{{ $report->user->username }}</a> </b>
      <br />
      @if($report->reason <> ''){!! nl2br($report->reason) !!} @endif
      <br />
      <small>{{ $report->created_at }} </small>

      <br /><br />                    
    </div>
    @endforeach        
  </div>
</td>
</tr>
@endif

<form action="{{ url('admin/products') }}/{{ $product->id }}" method="POST" enctype='multipart/form-data' role="form">

  <div class="row">
    <div class="form-group col-md-6  @if ($errors->has('name')) has-error @endif">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ $product->name }}" required autofocus>
      @if ($errors->has('name')) @foreach($errors->get('name') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
    </div>
    <div class="select-box form-group col-md-3">
      <label>Category</label>
      {!! Form::select('category_id', $categories, $product->category_id, array('class'=>'form-control selectpicker', 'data-live-search'=>'true', 'id' => 'country')) !!}
    </div>
    <div class="select-box form-group col-md-3">
      <label>Brand</label>
      {!! Form::select('brand_id', $brands, $product->brand_id, array('class'=>'form-control selectpicker', 'data-live-search'=>'true', 'id' => 'country')) !!}
    </div>
  </div>

  <div class="row">
    <div class="form-group col-md-6">
      <label>Slug <span class="text-muted"><small>(automatically generated if left blank)</small></span></label>
      <input type="text" name="slug" class="form-control" value="{{ $product->slug }}">
    </div>
  </div>

  <div class="form-group">
    @if(!$product->reviews->isEmpty())
    @include('admin/products/rating')        
    @endif
  </div>

  <div>
    @if($images->isEmpty())
    No images found
    @else
    <div>
      <label>{{ count($images) }} Images</label>
    </div>
    @include('admin/products/images')
    @endif
  </div>

  <div class="form-group">
    <label>Add more images<input type="file" name="images[]" multiple /></label>
  </div>
  <div>
    <div class="form-group">
      <label>Description</label>
      <textarea name="description" class="form-control ckeditor" rows="7">{{ $product->description }}</textarea>
    </div>
  </div>

  <div class="form-group">
    <label>Affiliate code (html/js)</label>
    <textarea name="affiliate_code" class="form-control" rows="4">{{ $product->affiliate_code }}</textarea>
  </div>
  <div class="form-group">
    <div class="radio radio-inline">
      <input type="radio" name="active" id="active" value="1" @if($product->active == 1) checked="checked" @endif >
      <label for="active">
        Published
      </label>
    </div>
    <div class="radio radio-inline">
      <input type="radio" name="active" id="inactive" value="0" @if($product->active == 0) checked="checked" @endif >
      <label for="inactive">
        Unpublished
      </label>
    </div>
  </div>
  <div class="form-group">
    <div class="checkbox">
     <input type="checkbox" name="discontinued" id="discontinued" class="styled" value="1" @if($product->discontinued == 1) checked="checked" @endif />
     <label for="discontinued">Discontinued</label>
   </div>
 </div>
 <div class="text-muted form-group"><small>Created: {{ date($settings->date_format,strtotime($product->created_at)) }} | Updated: {{ date($settings->date_format,strtotime($product->updated_at)) }}</small></div>

 <div class="form-group">
  {{ csrf_field() }}
  <input type="hidden" name="_method" value="PUT">
  <div class="pull-left">
    <button type="submit" name="update" value="update" class="btn btn-primary">Update</button>
    <button type="submit" name="update" value="update_and_new" class="btn btn-default">Update & New</button>
    <a href="{{ url('admin/products/create') }}" class="btn btn-default">New</a>  
  </div>

  <div class="pull-right">
    <a href="{{ url('admin/products/delete/'.$product->id.'/0') }}" onClick="return confirm('Confirm deletion')"  class="btn btn-default" >Delete</a>
  </div>
</div>

</form>
@stop