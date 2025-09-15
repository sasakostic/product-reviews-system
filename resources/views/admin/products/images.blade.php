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

<table class="table table-striped">
    <thead>
        <tr>
            <th style="vertical-align:middle">
                <div class="checkbox">
                <input type="checkbox" name="select_all_images" class="styled" value="" />
                   <label></label>
               </div>
           </th>
           <th style="vertical-align:middle">Image</th>
           <th style="vertical-align:middle"><span class="hidden-xs">Default</span></th>
           <th style="vertical-align:middle"><span class="hidden-xs">Description</span></th>
           <th class="hidden-xs" style="text-align:center;vertical-align:middle">User</th>
           <th style="text-align:rightstyle;vertical-align:middle"></th>
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
        <td class="col-xs-4 col-sm-1 col-md-1 col-lg-1" style="min-width:{{ $settings->product_sm_thumb_w }}px">
            <a class="swipebox" href="{{ url('images') }}/{{ $image->product->id }}/{{ $image->file_name}}" title="{{$image->description}} @if($image->user_id != 1) by {{$image->user->username}} @endif">
                <img class="img-responsive" src="{{ url('images/'.$image->product->id.'/sm_'.$image->file_name) }}"></a>
            </td>
            <td style="vertical-align:middle">
                <div class="radio">
                    <input type="radio" name="default_image" value="{{ $image->id }}" @if($product->image_id == $image->id) checked="checked" @endif/>
                    <label></label>
                </div>
            </td>
            <td class="col-xs-4 col-sm-9 col-md-9 col-lg-9 item-name">{{ $image->description }}</td>
            <td class="hidden-xs col-sm-1 col-md-1 col-lg-1" align="center">
                <a href="{{ url('admin/user/'.$image->user_id.'/details') }}">{{ $image->user->username }}</a>
            </td>
            <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1" align="right">
                <a href="{{ url('admin/images') }}/{{ $image->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver" ></span></a>                
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="6">
                <button type="submit" name="submit_button" id="delete_images" value="delete_images" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected images');" disabled="true">Delete selected</button>
            </td>
        </tr>
    </tbody>
</table>