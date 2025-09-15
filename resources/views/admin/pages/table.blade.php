<script type="text/javascript">
  $(function(){

    $(window).on('load', function() {
      if($(':checkbox[name="pages[]"]:checked').length > 0) $('#delete_pages').prop('disabled', false); 
    });


    $(':checkbox[name="pages[]"]').change(function(){
      if($(':checkbox[name="pages[]"]:checked').length > 0) $('#delete_pages').prop('disabled', false); 
      else $('#delete_pages').prop('disabled', true);
      if($(this).prop("checked")) $('#page_row'+$(this).val()).addClass('active'); else $('#page_row'+$(this).val()).removeClass('active');
    });

    $(':checkbox[name="select_all_pages"]').change(function(){
      $(".pages_checkbox").prop('checked', $(this).prop("checked"));
      $("#delete_pages").prop('disabled', !$(this).prop("checked"));
      if($(this).prop("checked")) $('.page_row').addClass('active'); else $('.page_row').removeClass('active');
    });

    });//document ready
</script>

<form action="{{ url('admin/pages/multiple-delete') }}" method="POST">           

  <table class="table table-striped">
    <thead>
      <tr>
        <th style="vertical-align:middle">
          <div class="checkbox">
            <input type="checkbox" name="select_all_pages" class="styled" value="" />
            <label></label>
          </div> 
        </th>
        <th style="vertical-align:middle">Title</th>
        <th style="vertical-align:middle">Slug</th>
        <th style="text-align:right; vertical-align:middle"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($pages as $page)
      <tr id="page_row{{ $page->id}}" class="page_row">
        <td style="vertical-align:middle">
          <div class="checkbox">
            <input type="checkbox" name="pages[]" class="styled pages_checkbox" value="{{ $page->id }}" />
            <label></label>
          </div>
        </td>
        <td class="item-name col-md-6"><a href="{{ url('page') }}/{{ $page->slug }}" target="_blank">{{ $page->title }}</a></td>
        <td class="item-name col-md-4">{{ $page->slug }}</td>
        <td class="col-md-2 col-xs-3" align="right">
          <a href="{{ url('admin/pages') }}/{{ $page->id }}/edit" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit silver"></span></a>          
        </td>
      </tr>
      @endforeach
      <tr>
        <td colspan="4">
         {{ csrf_field() }}
         <button type="submit" name="submit_button" id="delete_pages" value="delete_pages" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected pages');" disabled="true">Delete selected</button>
       </td>
     </tr>
   </tbody>
 </table>

</form>