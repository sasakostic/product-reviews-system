<script type="text/javascript">
    $(function(){

        $(window).on('load', function() {
           if($(':checkbox[name="review_reporting_reasons[]"]:checked').length > 0) $('#delete_review_reporting_reasons').prop('disabled', false); 
       });
        
        $(':checkbox[name="review_reporting_reasons[]"]').change(function(){
            if($(':checkbox[name="review_reporting_reasons[]"]:checked').length > 0) $('#delete_review_reporting_reasons').prop('disabled', false); 
            else $('#delete_review_reporting_reasons').prop('disabled', true);
            if($(this).prop("checked")) $('#reason_row'+$(this).val()).addClass('active'); else $('#reason_row'+$(this).val()).removeClass('active');
        });

        $(':checkbox[name="select_all_reasons"]').change(function(){
            $(".reasons_checkbox").prop('checked', $(this).prop("checked"));
            $("#delete_review_reporting_reasons").prop('disabled', !$(this).prop("checked"));
            if($(this).prop("checked")) $('.reason_row').addClass('active'); else $('.reason_row').removeClass('active');
        });
        $('#new_review_reason').click(function(){
            var new_reason = jQuery('<div class="form-group"><input type="text" name="new_review_reporting_reason[]" id="new_review_reporting_reason" class="form-control" /></div>');
            jQuery('#new_review_reasons').append(new_reason);    
            $('#new_review_reasons input:text:first').focus();   
            $('#save_reasons').show();
            $('#cancel_reasons').show();
            $('#new_review_reason').text('+');             
        });
         $('#cancel_reasons').click(function(){
            $('#new_review_reasons').html('');
            $('#save_reasons').hide();
            $('#cancel_reasons').hide();
            $('#new_review_reason').text('Add reason');
        });
    });//document ready
</script>

@if(!$review_reporting_reasons->isEmpty())
<table class="table table-striped">
    <thead>
        <tr>
            <th style="vertical-align:middle">
                <div class="checkbox">
                    <input type="checkbox" name="select_all_reasons" class="styled" value="" />
                    <label></label>
                </div>
            </th>
            <th style="vertical-align:middle" class="col-sm-12">Reason</th>
        </tr>
    </thead>
    <tbody>
        @foreach($review_reporting_reasons as $reason)
        <tr>
            <td style="vertical-align:middle">
               <div class="checkbox">
                   <input type="checkbox" name="review_reporting_reasons[]" class="styled reasons_checkbox" value="{{ $reason->id }}" />
                   <label></label>
               </div>             
           </td>
           <td>{{ $reason->text }}</td>
       </tr>
       @endforeach


   </tbody>
</table>
<div class="form-group">
<button type="submit" name="submit_button" id="delete_review_reporting_reasons" value="delete_review_reporting_reasons" class="btn btn-devault btn-xs" onclick="return confirm('Confirm deletion of selected reasons');" disabled="true">Delete selected</button>
</div>
@endif
<div id="new_review_reasons">

</div>
<div class="form-group">
    {{ csrf_field() }}
    <button type="submit" name="submit_button" class="btn btn-default btn-xs" id="save_reasons" style="display:none">Save</button>
    <button type="button" class="btn btn-default btn-xs" id="new_review_reason" title="Add more">Add reason</button>
    <a href="javascript:" class="pull-right" id="cancel_reasons" style="display: none">Cancel</a>
</div>
