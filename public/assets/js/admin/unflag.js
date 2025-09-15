  function unflag_product(id) {

    $.ajax({
      type: "POST",
      url: APP_URL + '/admin/products/unflag',
      data: { 
        'next_action': 'unflag_product', 
        'next_action_item': id, 
      },
      dataType: "JSON",
      beforeSend: function(){
       $('#cross_'+id).fadeTo("fast", 0);
       $('#reported_'+id).fadeTo("fast", 0.30);
       $('#product_row'+id).removeClass('warning');
     },
     success: function(data, textStatus, xhr) {

      if (!xhr.responseJSON) {
        notify("error", "Unknown error");;
        return;
      }

      switch(xhr.responseJSON.success)
      {
        case true:
        if(xhr.responseJSON.unflagged)          
          break;

        case false:
        notify('error', xhr.responseJSON.message);
        break;          
      }

    },
    error: function(xhr, textStatus, errorThrown) { 

      if (!xhr.responseJSON) {
        notify("error", "Unknown error");;
        return;
      }

      if (!xhr.responseJSON.success && !xhr.responseJSON.logged_in) { 
        $('#cross_'+id).fadeTo("fast", 1);
        $('#product_row'+id).addClass('text-muted');      
        $('#reported_'+id).fadeTo("fast", 1);
        $('#product_row'+id).addClass('warning');
        $('#login_modal').modal({keyboard: true}, 'show');
        return;
      }        
    }  
  });
  }

  function unflag_review(id) {

    $.ajax({
      type: "POST",
      url: APP_URL + '/admin/reviews/unflag',
      data: { 
        'next_action': 'unflag_review', 
        'next_action_item': id, 
      },
      dataType: "JSON",
      beforeSend: function(){
       $('#cross_'+id).fadeTo("fast", 0);
       $('#reported_'+id).fadeTo("fast", 0.30);
     },
     success: function(data, textStatus, xhr) {

      if (!xhr.responseJSON) {
        notify("error", "Unknown error");;
        return;
      }

      switch(xhr.responseJSON.success)
      {
        case true:
        if(xhr.responseJSON.unflagged)          
          break;

        case false:
        notify('error', xhr.responseJSON.message);
        break;          
      }
    },
    error: function(xhr, textStatus, errorThrown) { 

      if (!xhr.responseJSON) {
        notify("error", "Unknown errorx");;
        return;
      }
      
      if (!xhr.responseJSON.success && !xhr.responseJSON.logged_in) { 
        $('#cross_'+id).fadeTo("fast", 1);
        $('#review_row_'+id).addClass('text-muted');      
        $('#reported_'+id).fadeTo("fast", 1);
        $('#review_row_'+id).addClass('warning');
        $('#login_modal').modal({keyboard: true}, 'show');
        return;
      }        
    }  
  });
  }