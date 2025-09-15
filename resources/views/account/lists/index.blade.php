@extends('layout')
@section('title', 'Manage Product Lists')
@section('content')

@include('alerts')

<link href="{{ url('assets/libs/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

<div class="col-lg-2 col-md-2 col-sm-2">
    @include('account/sidebar')
</div>
<div class="col-lg-10 col-md-10 col-sm-10">

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('account') }}">Account</a></li>
            <li class="active">Product lists</li>
        </ol>
    </div>

    @if($product_lists->isEmpty())

    <div style="text-align:center">
        <h3 class="text-muted">No lists</h3>
    </div>

    <div class="form-group pull-right">
            <a href="{{ url('account/lists/create') }}" class="btn btn-default btn-xs">New list</a>        
        </div> 

    @else

    <script type="text/javascript">
        $(function(){

            $(window).on('load', function() {
                if($(':checkbox[name="lists[]"]:checked').length > 0) $('#delete_lists').prop('disabled', false);             
            });


            $(':checkbox[name="lists[]"]').change(function(){
                if($(':checkbox[name="lists[]"]:checked').length > 0) $('#delete_lists').prop('disabled', false); 
                else $('#delete_lists').prop('disabled', true);
                if($(this).prop("checked")) $('#list_row'+$(this).val()).addClass('active'); else $('#list_row'+$(this).val()).removeClass('active');
            });

            $(':checkbox[name="select_all_lists"]').change(function(){
                $(".lists_checkbox").prop('checked', $(this).prop("checked"));
                $("#delete_lists").prop('disabled', !$(this).prop("checked"));
                if($(this).prop("checked")) $('.list_row').addClass('active'); else $('.list_row').removeClass('active');
            });

    });//document ready
</script>

<form action="{{ url('account/lists/multiple-delete') }}" method="POST">

    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align:middle">
                    <div class="checkbox">
                        <input type="checkbox" name="select_all_lists" class="styled" value="" />
                        <label></label>
                    </div> 
                </th>
                <th style="vertical-align:middle">Name</th>
                <th class="hidden-xs" style="vertical-align:middle">Slug</th>
                <th style="text-align:right; vertical-align:middle"></th>
                <th style="text-align:right; vertical-align:middle"></th>
            </tr>
        </thead>
        <tbody>

            @foreach($product_lists as $list)
            <tr id="list_row{{ $list->id }}" class="list_row">
               <td style="vertical-align:middle">
                <div class="checkbox">
                    <input type="checkbox" name="lists[]" class="styled lists_checkbox" value="{{ $list->id }}" />
                    <label></label>
                </div>                
            </td>
            <td class="col-md-5 item-name"><a href="{{ url('products/search?list='.$list->slug.'&list_id='.$list->id) }}" target="_blank">{{ $list->name }}</a> @if($list->featured == 1) <span class="badge badge-info">featured</span> @endif @if($list->public == 0) <span class="text-muted">(private)</span> @endif</td>
            <td class="col-md-4 hidden-xs item-name">{{ $list->slug }}</td>            
        </td>
        <td class="col-md-1 hidden-xs" style="text-align:center">

        </td>
        <td class="col-md-1" align="right">
            <a href="{{ url('account/lists') }}/{{ $list->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>            
        </td>
    </tr>
    
    @endforeach
    <tr>
        <td colspan="10">
         {{ csrf_field() }}
         <div class="pull-left">
             <button type="submit" name="submit_button" id="delete_lists" value="delete_lists" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected lists');" disabled="true">Delete selected</button>
         </div>

         <div class="form-group pull-right">
            <a href="{{ url('account/lists/create') }}" class="btn btn-default btn-xs">New list</a>        
        </div>    
        
    </td>
</tr>
</tbody>
</table>

</form>

<div>
    {!! $product_lists->appends(array('search_terms' => Input::get('search_terms')))->render() !!}
</div>

@endif

</div>

</div>
@stop