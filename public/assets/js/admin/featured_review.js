  function featured_review(id) {

    $.ajax({
      type: "POST",
      url: APP_URL + '/admin/reviews/toggle-featured',
      data: { 
        'next_action': 'featured_review', 
        'next_action_item': id, 
      },
      dataType: "JSON",
      beforeSend: function() {
        //$('#spinner_'+id).show();
      },
      success: function(data, textStatus, xhr) {

        if (!xhr.responseJSON) {
          notify("error", "Unknown error");;
          return;
        }
        
        switch(xhr.responseJSON.success)
        {
          case true:
          if (xhr.responseJSON.featured && !xhr.responseJSON.unfeatured) {
            $('#star_full_'+id).hide();
            $('#star_empty_'+id).hide();
            $('#star_full_'+id).show();
            return;
          }
          if (!xhr.responseJSON.featured && xhr.responseJSON.unfeatured) {
           $('#star_full_'+id).hide();
           $('#star_empty_'+id).hide();
           $('#star_empty_'+id).show();
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

  
