<script type="text/javascript">
  $(function(){

    $('#reasons_product').change(function(){ 
      if($(this).val() != 0) {
       $('#report_product_button').show(); 
       $('#comment_product_div').show();
       $('#comment_product').focus(); 
     } else {
       $('#report_product_button').hide();
       $('#comment_product_div').hide();
     }
   });

    $('#report_product_modal').on('hidden.bs.modal', function () {
      $('#comment_product').val('');
      $('#reasons_product').val(0);
      $('#reasons_product').prop('disabled', false);

    });

    $('#report_product_modal').on('shown.bs.modal', function () {
     $('#reasons_product').focus();
   });

});//document ready  
</script>
<div id="report_product_modal" class="modal fade">
  <div class="modal-dialog modal-smaller">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title text-danger"><strong><div id="report_product_modal_title">Report product</div></strong></h4>
      </div>
      <div class="modal-body">
        <div id="report_product_modal_info" class="text-success"></div>
        <div class="form-group">
          <select name="reasons_product" id="reasons_product" class="form-control" required>
            <option value="0">Please select a reason</option>
            @foreach($product_reporting_reasons as $reason)
            <option value="{{ $reason->id }}" @if( $reason->id == 1 && $product->discontinued == 1) disabled @endif>{{ $reason->text }}</option>            
            @endforeach
          </select>
        </div>
        <div class="form-group" id="comment_product_div" style="display:none">
        	<label>Comment</label> <span class="text-muted"></span>
        	<textarea class="form-control" name="comment_product" id="comment_product" rows="3" maxlength="255" autofocus></textarea>          
        </div>
      </div>
      <div class="modal-footer" id="report_product_footer">
        <a href="#" data-dismiss="modal" id="close_report_product_button" style="display:none">Close</a>
         <button id="report_product_button" class="btn btn-danger btn-sm" onclick="javascript:report_p()" style="display:none">Submit</button>  
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->