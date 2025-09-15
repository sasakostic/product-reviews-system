  function check_login(next_action, next_action_item, helpful_item = null) {

    $.ajax({
      type: "POST",
      url: APP_URL + '/login/ajax-check',
      data: {
        'next_action': next_action, 
        'next_action_item': next_action_item, 
        'helpful_item': helpful_item
      },
      dataType: 'JSON',
      success: function(data, textStatus, xhr) { 

        if (!xhr.responseJSON) {
          notify("error", "Unknown error");;
          return;
        }

        if (xhr.responseJSON.logged_in) { 
          perform_next_action(xhr.responseJSON.next_action, xhr.responseJSON.next_action_item, xhr.responseJSON.helpful_item);
        }

      },

      error: function(xhr, textStatus, errorThrown) { 

        if (!xhr.responseJSON) {
          notify("error", "Unknown error");;
          return;
        }

        if (!xhr.responseJSON.logged_in) { 
          $('#login_modal').modal({keyboard: true}, 'show');
          return;
        }        
      }

    });

  }

  $(function() {

    $("#login_modal").on("show.bs.modal", function() {
      $('#login_modal_form').show();
    });

    $('#login_modal').on('shown.bs.modal', function() {
      $('#username_email').focus();
    })

    $("#report_review_modal").on("show.bs.modal", function() {
      $('.report_info').html('');
      $('#reason').focus();
    });

    $("#login_modal").on("hidden.bs.modal", function() {
    //$('#helpful_review_buttons_'+next_action_item).show();
    //$('#helpful_review_info_'+next_action_item).html('');
  });

    $('#sign_in_button').click(function() {
      var username_email = $('#username_email').val();
      var password = $('#password').val();
      var remember = $('#remember').val();

      $('#login_modal_form').hide(0, function() {
        $('#login_modal_info').html('Submitting...');
      });


      $.ajax({
        type: "POST",
        url: APP_URL + '/login/ajax-login',
        data: { 
          username_email : username_email, 
          password : password, 
          remember: remember
        },
        dataType: "JSON",
        success: function(data, textStatus, xhr) {

          if (!xhr.responseJSON) {
            notify("error", "Unknown error");;
            return;
          }
          if (xhr.responseJSON.logged_in) {

            $('#login_modal').modal('hide');
            $('#login_modal_info').html('');
            $('#header_account_menu').show();
            $('#header_login_menu').hide();            

            if (xhr.responseJSON.is_admin) {
              $('#login_modal').modal('hide');
              $('#login_modal_info').html('');
              $('#header_account_menu').show();
              $('#header_admin_menu').show();
              $('#header_login_menu').hide();              
            } 
            perform_next_action(xhr.responseJSON.next_action, xhr.responseJSON.next_action_item, xhr.responseJSON.helpful_item);
            return;            

          } else {
            $('#login_modal_info').html('<span class="red">Can\'t log in</span>');
            $('#login_modal').modal({keyboard: true}, 'show');
            $('#username_email').focus();
            return;
          }       

        },
        error: function(xhr, textStatus, errorThrown) { 

          if (!xhr.responseJSON) {
            notify("error", "Unknown error");;
            return;
          }
          
          var response = $.parseJSON(xhr.responseText);
          if (!response.logged_in) {
            $('#login_modal_info').html('<span class="orange">Wrong login info</span>');
            $('#login_modal').modal({keyboard: true}, 'show');
            $('#username_email').focus();
            return;
          }         
        }
      });

    });

    perform_next_action = function(next_action, next_action_item, helpful_item = null){

      switch(next_action) {

        case 'report_product': 
        $('#report_product_modal').modal({keyboard: true}, 'show');
        $('#report_product_modal_info').html('');
        $('#comment_product').val('');
        $('#close_report_product_button').hide();      
        return;
        break;

        case 'report_review': 
        $('#report_review_modal').modal({keyboard: true}, 'show');
        $('#report_review_modal_info').html('');
        $('#close_report_review_button').hide();   
        return;
        break;

        case 'helpful_review': 
        helpful_review(next_action_item, helpful_item);
        return;
        break;

        case 'favorite_review': 
        favorite_review(next_action_item);
        return;
        break;
        
        case 'favorite_product': 
        favorite_product(next_action_item);
        return;
        break;

        case 'favorite_user': 
        favorite_user(next_action_item);
        return;
        break;

        case 'unflag_product': 
        unflag_product(next_action_item);
        return;
        break;

        case 'unflag_review': 
        unflag_review(next_action_item);
        return;
        break;

        case 'publish_review': 
        publish_review(next_action_item);
        return;
        break;

        case 'featured_review': 
        featured_review(next_action_item);        
        return;
        break;

      }

    }

}); //document ready