<script type="text/javascript">
    $(function(){

        $(window).on('load', function() {
            if($(':checkbox[name="categories[]"]:checked').length > 0) $('#delete_categories').prop('disabled', false);             
        });
        

        $(':checkbox[name="categories[]"]').change(function(){
            if($(':checkbox[name="categories[]"]:checked').length > 0) $('#delete_categories').prop('disabled', false); 
            else $('#delete_categories').prop('disabled', true);
            if($(this).prop("checked")) $('#category_row'+$(this).val()).addClass('active'); else $('#category_row'+$(this).val()).removeClass('active');
        });

        $(':checkbox[name="select_all_categories"]').change(function(){
            $(".categories_checkbox").prop('checked', $(this).prop("checked"));
            $("#delete_categories").prop('disabled', !$(this).prop("checked"));
            if($(this).prop("checked")) $('.category_row').addClass('active'); else $('.category_row').removeClass('active');
        });

    });//document ready
</script>

<form action="{{ url('admin/categories/multiple-delete') }}" method="POST">

    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align:middle">
                    <div class="checkbox">
                        <input type="checkbox" name="select_all_categories" class="styled" value="" />
                        <label></label>
                    </div> 
                </th>
                <th style="vertical-align:middle">Name</th>
                <th class="hidden-xs" style="vertical-align:middle">Slug</th>
                <th class="hidden-xs" style="text-align:center; vertical-align:middle">Products</th>
                <th class="hidden-xs" style="text-align:center; vertical-align:middle">Reviews</th>
                <th style="text-align:right; vertical-align:middle"></th>
            </tr>
        </thead>
        <tbody>

            @foreach($categories as $category)
            <tr id="category_row{{ $category->id }}" class="category_row">
             <td style="vertical-align:middle">
                @if($category->id <> 1)
                <div class="checkbox">
                    <input type="checkbox" name="categories[]" class="styled categories_checkbox" value="{{ $category->id }}" />
                    <label></label>
                </div>
                @endif
            </td>
            <td class="col-md-5 item-name"><a href="{{ url('products/search?category='.$category->slug.'&category_id='.$category->id) }}" target="_blank">{{ $category->name }}</a> @if($category->featured == 1) <span class="badge badge-info">featured</span> @endif</td>
            <td class="col-md-4 hidden-xs item-name">{{ $category->slug }}</td>
            <td class="hidden-xs col-md-1"style="text-align:center">
                @if($category->products->count() > 0)
                <a href="{{ url('admin/products/search?category_id='.$category->id) }}">{{ $category->products->count() }}</a>
                @else
                <span class="text-muted">{{ $category->products->count() }}</span>
                @endif
            </td>
        </td>
        <td class="col-md-1 hidden-xs" style="text-align:center">
            @if($category->getReviewsCount() > 0)
            {{ $category->getReviewsCount() }}
            @else
            <span class="text-muted">{{ $category->getReviewsCount() }}</span>
            @endif
        </td>
        <td class="col-md-1" align="right">
            <a href="{{ url('admin/categories') }}/{{ $category->id }}/edit" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-edit silver"></span></a>            
        </td>
    </tr>
    
    @endforeach
    <tr>
        <td colspan="10">
           {{ csrf_field() }}
           <button type="submit" name="submit_button" id="delete_categories" value="delete_categories" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected categories');" disabled="true">Delete selected</button>
       </td>
   </tr>
</tbody>
</table>

</form>