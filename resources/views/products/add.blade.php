@extends('layout')
@section('title', 'Add New Product')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
<script src="{{ url('assets/libs/bootstrap-select/js/bootstrap-select.min.js') }}"></script>


<div>
    <h3>Add New Product</h3>
</div>

<form  method="POST" action="{{ url('products') }}">

    <div class="row">
        <div class="select-box form-group col-sm-4 col-md-4 col-lg-4">
            {!! Form::select('category_id', $categories, Input::Get('category_id'), array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) !!}
        </div>
    </div>
    
    <div class="row">    
        <div class="select-box form-group col-sm-4 col-md-4 col-lg-4">
            {!! Form::select('brand_id', $brands, Input::Get('brand_id'), array('class'=>'form-control selectpicker', 'data-live-search'=>'true')) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-4 col-md-4 col-lg-4 @if ($errors->has('name')) has-error @endif">
            <input type="text" name="name" class="form-control" required value="{{ Input::get('name') }}{{Input::old('name')}}"  placeholder="Product name" title="Product name">
            @if ($errors->has('name')) @foreach($errors->get('name') as $error) <p class="help-block">{{ $error }}</p> @endforeach @endif
        </div>
    </div>
    
    <div class="form-group">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Add product</button>
    </div>

</form>


@stop