@extends('layout')
@section('title', 'My Images')
@section('content')

@include('alerts')

<script type="text/javascript" src="{{ url('assets/libs/swipebox/lib/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/libs/swipebox/js/jquery.swipebox.js') }}"></script>

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

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

@if($settings->users_delete_product_images)
<script type="text/javascript">
    $(function(){

        $(window).on('load', function() {
           if($(':checkbox[name="images[]"]:checked').length > 0) $('#delete_images').prop('disabled', false); 
       });
        
        $(':checkbox[name="images[]"]').change(function(){
            if($(':checkbox[name="images[]"]:checked').length > 0) $('#delete_images').prop('disabled', false); 
            else $('#delete_images').prop('disabled', true);
            if($(this).prop("checked")) $('#image_row'+$(this).val()).addClass('active'); else $('#image_row'+$(this).val()).removeClass('active');
        });

        $(':checkbox[name="select_all_images"]').change(function(){
            $(".images_checkbox").prop('checked', $(this).prop("checked"));
            $("#delete_images").prop('disabled', !$(this).prop("checked"));
            if($(this).prop("checked")) $('.image_row').addClass('active'); else $('.image_row').removeClass('active');
        });

    });//document ready
</script>

@endif

<div class="col-lg-2 col-md-2 col-sm-2">
    @include('account/sidebar')
</div>

<div class="col-lg-10 col-md-10 col-sm-10">

        <div class="row">
          <ol class="breadcrumb">
          <li><a href="{{ url('account') }}">Account</a></li>
              <li class="active">images</li>        
          </ol>
      </div>
    
    @if($images->isEmpty())
    
    <div style="text-align:center">
        <h3 class="text-muted">No Images</h3>
    </div>
    
    @else

    <form action="{{ url('account/images/multiple-delete') }}" method="POST">
        <table class="table table-striped">
            <thead>
                <tr>
                    @if($settings->users_delete_product_images)
                    <th style="vertical-align:middle">
                        <div class="checkbox">
                            <input type="checkbox" name="select_all_images" class="styled" value="" />
                            <label></label>
                        </div>
                    </th>
                    @endif
                    <th class="hidden-xs"  style="vertical-align:middle">Image</th>
                    <th class="hidden-xs"  style="vertical-align:middle">Description</th>
                    <th style="vertical-align:middle">Product</th>                
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($images as $image)
                <tr id="image_row{{$image->id}}" class="image_row">
                    @if($settings->users_delete_product_images)
                    <td style="vertical-align:middle">
                       <div class="checkbox">
                           <input type="checkbox" name="images[]" class="styled images_checkbox" value="{{ $image->id }}" />
                           <label></label>
                       </div>
                   </td>
                   @endif
                   <td class="hidden-xs col-sm-3 col-md-2 col-lg-2">
                    <a class="swipebox" href="{{ url('images') }}/{{ $image->product->id }}/{{ $image->file_name}}" title="{{$image->description}} @if($image->user_id != 1) by {{$image->user->username}} @endif">
                        <img class="img-home" src="{{ url('images/'.$image->product->id.'/sm_'.$image->file_name) }}"></a>
                    </td>

                    <td class="hidden-xs col-sm-6 col-md-6 col-lg-6 item-name" >{{ $image->description }}</td>
                    <td class="col-xs-11 col-sm-4 col-md-3 col-lg-3 item-name"> 
                        <div class="visible-xs">
                            <a class="swipebox" href="{{ url('images') }}/{{ $image->product->id }}/{{ $image->file_name}}" title="{{$image->description}} @if($image->user_id != 1) by {{$image->user->username}} @endif">
                                <img class="img-responsive" src="{{ url('images/'.$image->product->id.'/sm_'.$image->file_name) }}"></a>
                            </div>
                            <div class="visible-xs">
                                {{ $image->description }}
                            </div>
                            <div>
                                <a href="{{ url('product/'.$image->product->id.'/'.$image->product->slug) }}" target="_blank">{{ $image->product->category->name }} / {{ $image->product->brand->name }} {{ $image->product->name }}</a> @if($image->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
                            </div>
                            <div class="visible-xs pull-right" style="vertical-align:middle">
                                <a href="{{ url('account/images') }}/{{ $image->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>
                            </td>
                            <td class="hidden-xs col-sm-1 col-lg-1" align="right" style="vertical-align:middle">
                                <a href="{{ url('account/images') }}/{{ $image->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>                               
                            </td>                
                        </tr>
                        @endforeach
                        @if($settings->users_delete_product_images)
                        <tr>
                            <td colspan="6">
                                {{ csrf_field() }}
                                <button type="submit" name="submit_button" id="delete_images" value="delete_images" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected images');" disabled="true">Delete selected</button>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>    
            <div>
                {!! $images->render() !!}
            </div>

            @endif

        </div>

        @stop