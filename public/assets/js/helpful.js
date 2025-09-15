  function helpful_review(id, helpful) {

    $.ajax({
      type: "POST",
      url: APP_URL + '/reviews/helpful',
      data: { 
        'next_action': 'helpful_review', 
        'next_action_item': id,  
        'helpful_item': helpful
      },
      dataType: "JSON",
      beforeSend: function() { 
        $('#helpful_review_buttons_' + id).hide();
        $('#helpful_review_info_' + id).html('Saving your feedback...');
      },
      success: function(data, textStatus, xhr) {

        if (!xhr.responseJSON) {
          notify("error", "Unknown error");;
          return;
        }


        $('#helpful_review_buttons_' + id).hide();

        switch(xhr.responseJSON.success)
        {
          case true:
          $('#helpful_review_info_' + id).html(xhr.responseJSON.message);        
          break;
          case false:
          $('#helpful_review_info_' + id).html('<span class="text-danger">' + xhr.responseJSON.message + '<span>');        
          break;          
        }

      },

      
      error: function(xhr, textStatus, errorThrown) { 

        if (!xhr.responseJSON) {
          notify("error", "Unknown error");;
          return;
        }
        
        if (!xhr.responseJSON.logged_in) { 
          $('#login_modal').modal({keyboard: true}, 'show');
          $('#helpful_review_info_' + id).html(xhr.responseJSON.message);
          return;
        }        
      }

      

    });
  }

