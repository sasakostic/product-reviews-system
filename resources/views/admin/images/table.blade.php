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

<form action="{{ url('admin/images/multiple-delete') }}" method="POST">

    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align:middle">
                    <div class="checkbox">
                        <input type="checkbox" name="select_all_images" class="styled" value="" />
                        <label></label>
                    </div>
                </th>
                <th style="vertical-align:middle">Images</th>
                <th class="hidden-xs" style="vertical-align:middle">Description</th>
                <th style="vertical-align:middle">Product</th>
                <th class="hidden-xs" style="text-align:center; vertical-align:middle">User</th>
                <th style="text-align:right; vertical-align:middle"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $image)
            <tr id="image_row{{$image->id}}" class="image_row">
                <td style="vertical-align:middle">
                   <div class="checkbox">
                       <input type="checkbox" name="images[]" class="styled images_checkbox" value="{{ $image->id }}" />
                       <label></label>
                   </div>
               </td>
               <td class="col-xs-6 col-md-1 col-lg-1">
                <a class="swipebox" href="{{ url('images') }}/{{ $image->product->id }}/{{ $image->file_name}}" title="{{$image->description}} @if($image->user_id != 1) by {{$image->user->username}} @endif">
                    <img class="img-responsive" src="{{ url('images/'.$image->product->id.'/sm_'.$image->file_name) }}"></a>
                </td>

                <td class="hidden-xs col-md-6 col-lg-6 item-name">{{ $image->description }}</td>
                <td class="col-xs-2  col-md-3 col-lg-3 item-name"> 
                <a href="{{ url('product/'.$image->product->id.'/'.$image->product->slug) }}" target="_blank">{{ $image->product->brand->name }} {{ $image->product->name }}</a> @if($image->product->discontinued == 1)<span class="text-muted">(discontinued)</span>@endif
                </td>
                <td class="hidden-xs col-sm-1 col-md-1 col-lg-1 item-name" align="center">
                    <a href="{{ url('user/'.$image->user_id.'/'.$image->user->username) }}" @include('admin/images/username_hover')>{{ $image->user->username }}</a>
                </td>
                <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2" align="right" style="vertical-align:middle">
                    <a href="{{ url('admin/images/'.$image->id . '/edit') }}" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>                    
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6">
                    {{ csrf_field() }}
                    <button type="submit" name="submit_button" id="delete_images" value="delete_images" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected images');" disabled="true">Delete selected</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>    