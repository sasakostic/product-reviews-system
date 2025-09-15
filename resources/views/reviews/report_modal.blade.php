<script type="text/javascript">
  $(function(){

    $('#reasons').change(function(){ 
      if($(this).val() != 0) {
       $('#report_review_button').show(); 
       $('#comment_div').show();
       $('#comment').focus(); 
     } else {
       $('#report_review_button').hide();
       $('#comment_div').hide();
     }
   });

    $('#report_review_modal').on('hidden.bs.modal', function () {
      $('#comment').val('');
      $('#reasons').val(0);
      $('#reasons').prop('disabled', false);

    });

    $('#report_review_modal').on('shown.bs.modal', function () {
     $('#reasons').focus();
   });

});//document ready  
</script>
<div id="report_review_modal" class="modal fade">
  <div class="modal-dialog modal-smaller">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 id="title" class="modal-title text-danger"><strong><div id="report_review_title">Report review</div></strong></h4>
      </div>
      <div class="modal-body">
        <div id="report_review_modal_info" class="text-success">
        </div>
        <div class="form-group">
          <select name="reasons" id="reasons" class="form-control" required>
            <option value="0">Please select a reason</option>
            @foreach($review_reporting_reasons as $reason)
            <option value="{{ $reason->id }}">{{ $reason->text }}</option>            
            @endforeach            
          </select>
        </div>
        <div class="form-group" id="comment_div" style="display:none">
        	<label>Comment</label> <span class="text-muted"></span>
        	<textarea class="form-control" id="comment" rows="3" maxlength="255" autofocus></textarea>          
        </div>
      </div>
      <div class="modal-footer" id="report_review_footer">
        <button id="report_review_button" class="btn btn-danger btn-sm" onclick="javascript:report_r()" style="display:none">Submit</button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->