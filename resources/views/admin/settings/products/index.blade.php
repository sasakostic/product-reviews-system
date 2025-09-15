@extends('admin/layout')
@section('title', 'Manage Products Settings')
@section('content')

@include('alerts')

<script src="{{ url('assets/libs/ckeditor/ckeditor.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

@include('admin/settings/menu')

<form action="{{ url('admin/settings/update-products-settings')}}" method="POST">


    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="users_add_products" id="users_add_product" class="styled" value="1" @if($settings->users_add_products == 1) checked="checked" @endif>
            <label for="users_add_product">
                Users can add products
            </label>
        </div>
    </div>


    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="users_add_product_images" id="users_add_product_images"  class="styled"  value="1" @if($settings->users_add_product_images == 1) checked="checked" @endif>
            <label for="users_add_product_images">
                Users can add product images          
            </label>  
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="users_list_product_images" id="users_list_product_images"  class="styled" value="1" @if($settings->users_list_product_images == 1) checked="checked" @endif @if($settings->users_add_product_images != 1) disabled @endif>
            <label for="users_list_product_images">
                Users can list product images they added
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="users_delete_product_images" id="users_delete_product_images"  class="styled" value="1" @if($settings->users_delete_product_images == 1) checked="checked" @endif @if($settings->users_add_product_images != 1 || $settings->users_list_product_images != 1) disabled @endif>
            <label for="users_delete_product_images">
                Users can delete product images they added
            </label>
        </div>
    </div>

    <div>
        <label>Maximum size of uploaded images in bytes</label>
    </div>

    <div class="row">        
        <div class="form-group col-md-2 col-sm-3 col-lg-2">
        <input type="text" name="max_image_size" id="max_image_size" class="form-control" value="{{ $max_image_size }}" required @if($settings->users_add_product_images != 1) disabled @endif>
        </div>        
    </div>

    <div class="form-group">
        <div class="checkbox">
            <input type="checkbox" name="users_report_products" id="users_report_products" class="styled" value="1" @if($settings->users_report_products == 1) checked="checked" @endif>
            <label for="users_report_products">
                Users can report products
            </label>
        </div>
    </div>

    <div id="reporting_reasons_div">
        <div>
            <label>Reporting reasons</label>
        </div>  

        @include('admin/settings/products/reasons')
        
    </div>

    <div>
        <label>Product thumbnail width</label>
    </div>    

    <div class="row">        
        <div class="form-group col-md-1 col-sm-2 col-lg-1">
            <input type="text" name="product_sm_thumb_w" class="form-control" value="{{ $settings->product_sm_thumb_w }}" required >
        </div>        
    </div>

    <div>
        <label>Product thumbnail height</label>
    </div>

    <div class="row">        
        <div class="form-group col-md-1 col-sm-2 col-lg-1">
            <input type="text" name="product_sm_thumb_h" class="form-control" value="{{ $settings->product_sm_thumb_h }}" required >
        </div>        
    </div>

    <div>
        <label>Main product image width</label>
    </div>

    <div class="row">        
        <div class="form-group col-md-1 col-sm-2 col-lg-1">
            <input type="text" name="product_main_thumb_w" class="form-control" value="{{ $settings->product_main_thumb_w }}" required >
        </div>        
    </div>

    <div>
        <label>Main product image height</label>
    </div>

    <div class="row">        
        <div class="form-group col-md-1 col-sm-2 col-lg-1">
            <input type="text" name="product_main_thumb_h" class="form-control" value="{{ $settings->product_main_thumb_h }}" required >
        </div>        
    </div>

    <div>
        <label>Product description preview length</label>
    </div>

    <div class="row">        
        <div class="form-group col-md-1 col-sm-2 col-lg-1">
            <input type="text" name="product_description_len" class="form-control" value="{{ $settings->product_description_len }}" required >
        </div>        
    </div>

    <div class="form-group">
        {{ csrf_field() }}
        <button type="submit" name="submit_button" class="btn btn-primary">Save settings</button>
    </div>        

</form>

<script type="text/javascript">
    $(function(){

        $('#users_add_product_images').change(function(){
            if($('#users_add_product_images').is(':checked')) {
                $('#users_list_product_images').prop('disabled', false);
                $('#users_delete_product_images').prop('disabled', false);
                $('#max_image_size').prop('disabled', false);
            } else {
                $('#users_list_product_images').prop('disabled', true);
                $('#users_delete_product_images').prop('disabled', true);
                $('#users_list_product_images').prop('checked', false);
                $('#users_delete_product_images').prop('checked', false);
                $('#max_image_size').prop('disabled', true);
            }             
            if($('#users_list_product_images').is(':checked')) {
                $('#users_delete_product_images').prop('disabled', false);
            } else {
                $('#users_delete_product_images').prop('disabled', true);
                $('#users_delete_product_images').prop('checked', false);
            }             
        });

        $('#users_list_product_images').change(function(){
            if($('#users_list_product_images').is(':checked')) {
                $('#users_delete_product_images').prop('disabled', false);
            } else {
                $('#users_delete_product_images').prop('disabled', true);
                $('#users_delete_product_images').prop('checked', false);
            }             
        });

    });//document ready
</script>


@stop