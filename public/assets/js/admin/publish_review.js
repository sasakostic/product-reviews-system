  function publish_review(id) {

    $.ajax({
      type: "POST",
      url: APP_URL + '/admin/reviews/toggle-published',
      data: { 
        'next_action': 'publish_review', 
        'next_action_item': id, 
      },
      dataType: "JSON",
      beforeSend: function() {
        $('#spinner_'+id).show();
      },
      success: function(data, textStatus, xhr) {

        if (!xhr.responseJSON) {
          notify("error", "Unknown error");;
          return;
        }
        
        switch(xhr.responseJSON.success)
        {
          case true:
          if (xhr.responseJSON.published && !xhr.responseJSON.unpublished) {
            $('#unpublish_btn_'+id).hide();
            $('#publish_btn_'+id).show();
            $('#spinner_'+id).hide();
            $('#review_row'+id).removeClass('danger');  
            return;
          }
          if (!xhr.responseJSON.published && xhr.responseJSON.unpublished) {
           $('#unpublish_btn_'+id).show();
           $('#publish_btn_'+id).hide();
           $('#spinner_'+id).hide();
           $('#review_row'+id).addClass('danger');
           return;
         }
         break;

         case false:
         notify('error', xhr.responseJSON.message);
         return;
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
        return;
      }        
    }
  });
  }

  
