<script type="text/javascript">
    $(function(){

        $(window).on('load', function() {
         if($(':checkbox[name="brands[]"]:checked').length > 0) $('#delete_brands').prop('disabled', false); 
     });
                
        $(':checkbox[name="brands[]"]').change(function(){
            if($(':checkbox[name="brands[]"]:checked').length > 0) $('#delete_brands').prop('disabled', false); 
            else $('#delete_brands').prop('disabled', true);
            if($(this).prop("checked")) $('#brand_row'+$(this).val()).addClass('active'); else $('#brand_row'+$(this).val()).removeClass('active');
        });

        $(':checkbox[name="select_all_brands"]').change(function(){
            $(".brands_checkbox").prop('checked', $(this).prop("checked"));
            $("#delete_brands").prop('disabled', !$(this).prop("checked"));
            if($(this).prop("checked")) $('.brand_row').addClass('active'); else $('.brand_row').removeClass('active');
        });

    });//document ready
</script>

<form action="{{ url('admin/brands/multiple-delete') }}" method="POST">

    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align:middle">
                    <div class="checkbox">
                        <input type="checkbox" name="select_all_brands" class="styled" value="" />
                        <label></label>
                    </div> 
                </th>
                <th style="vertical-align:middle">Name</th>
                <th class="hidden-xs" style="vertical-align:middle">Slug</th>
                <th class="hidden-xs" style="text-align:center;vertical-align:middle" >Products</th>
                <th class="hidden-xs" style="text-align:center; vertical-align:middle">Reviews</th>
                <th style="text-align:right; vertical-align:middle"></th>
            </tr>
        </thead>
        <tbody>

            @foreach($brands as $brand)
            <tr id="brand_row{{ $brand->id}}" class="brand_row">
                <td style="vertical-align:middle">
                    @if($brand->id <> 1)
                    <div class="checkbox">
                        <input type="checkbox" name="brands[]" class="styled brands_checkbox" value="{{ $brand->id }}" />
                        <label></label>
                    </div>
                    @endif
                </td>
                <td class="col-md-5 item-name"><a href="{{ url('products/search?brand='.$brand->slug.'&brand_id='.$brand->id) }}" target="_blank">{{ $brand->name }}</a></td>
                <td class="col-md-4 hidden-xs item-name">{{ $brand->slug }}</td>
                <td class="hidden-xs col-md-1" style="text-align:center">
                    @if($brand->products->count() > 0)
                    <a href="{{ url('admin/products/search?brand_id='.$brand->id) }}">{{ $brand->products->count() }}</a>
                    @else
                    <span class="text-muted">{{ $brand->products->count() }}</span>
                    @endif
                </td>
                <td class="col-md-1 hidden-xs" style="text-align:center">
                    @if($brand->getReviewsCount() > 0)
                    {{ $brand->getReviewsCount() }}
                    @else
                    <span class="text-muted">{{ $brand->getReviewsCount() }}</span>
                    @endif
                </td>
                <td class="col-md-1" align="right">
                    <a href="{{ url('admin/brands') }}/{{ $brand->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>                    
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="10">
                 {{ csrf_field() }}
                 <button type="submit" name="submit_button" id="delete_brands" value="delete_brands" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected brands');" disabled="true">Delete selected</button>
             </td>
         </tr>

     </tbody>
 </table>

</form>