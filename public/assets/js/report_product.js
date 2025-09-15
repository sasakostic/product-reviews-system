  function report_product(id) {
    $('#report_product_modal_title').html('Report product');
    $('#report_product_footer').show();
    $('#report_product_button').prop('disabled', false);
    $('#report_product_button').hide();      
    
    check_login('report_product', id);

  }

  function report_p() {
    var reason_id_product = $('#reasons_product').val();

    $.ajax({
      type: "POST",
      url: APP_URL + "/products/report",
      dataType: 'JSON',
      data: {
        reason: $('#reasons_product option[value='+reason_id_product+']').text(), 
        comment: encodeURI($('#comment_product').val())
      },
      beforeSend: function() {
        $('#reasons_product').prop('disabled', true);
        $('#comment_product').prop('disabled', true);
        $('#report_product_button').prop('disabled', true);
      },
      success: function(data, textStatus, xhr) { 

        if (!xhr.responseJSON) {
          notify("error", "Unknown error");;
          return;
        }

        if(xhr.responseJSON.reported){
          $('#comment_product_div').hide();
          $('#reasons_product').hide();
          $('#report_product_modal_title').html(xhr.responseJSON.message);
          $('#report_product_footer').hide();
          $('#report_product_info').html('reported');
          $('#report_product_modal_info').html('Product reported');
          $('#report_product_icon_'+xhr.responseJSON.next_action_item).hide();
          setTimeout(function(){ $('#report_product_modal').modal('hide') }, 1500);
        }
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