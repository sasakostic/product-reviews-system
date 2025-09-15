function report_review(id) {

  $('#report_review_title').html('Report review');
  $('#reasons').prop('disabled', false);
  $('#report_review_button').prop('disabled', false);
  $('#report_review_button').hide();
  $('#reasons').show();
  $('#report_review_footer').show();
  $('#comment').prop('disabled', false);
  $('#report_info_' + id).html('');

  check_login('report_review', id);
  
}

function report_r() {
  var reason_id = $('#reasons').val();
  $.ajax({
    type: "POST",
    url: APP_URL+"/reviews/report",
    data: {
      reason : $('#reasons option[value='+reason_id+']').text(), 
      comment: encodeURI($('#comment').val())
    },
    dataType: "JSON",
    beforeSend: function() {
      $('#reasons').prop('disabled', true);
      $('#comment').prop('disabled', true);
      $('#report_review_button').prop('disabled', true);        
    },
    success: function(data, textStatus, xhr) {

      if (!xhr.responseJSON) {
        notify("error", "Unknown error");;
        return;
      }
      
      $('#reasons').hide();
      $('#comment_div').hide();
      $('#report_review_footer').hide();
      $('#report_review_modal_info').html(xhr.responseJSON.message);
      $('#report_review_title').html('Review reported');
      $('#report_icon_'+xhr.responseJSON.next_action_item).hide();
      $('#report_info_' + xhr.responseJSON.next_action_item).html('<span class="glyphicon glyphicon-ok"></span>');
      setTimeout(function(){ $('#report_review_modal').modal('hide') }, 1500);
    },
    error: function(xhr, textStatus, errorThrown) { 

      if (!xhr.responseJSON) {
        notify("error", "Unknown error");;
        return;
      }
      
      $('#report_product_modal_info').html(xhr.responseJSON.message);   
      
    }
  });
}
