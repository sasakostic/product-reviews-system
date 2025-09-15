function favorite_review(id) {

	$.ajax({
		type: "POST",
		url: APP_URL + '/reviews/toggle-favorited',
		data: {
			'next_action': 'favorite_review', 
			'next_action_item': id, 
		},
		dataType: 'JSON',
		beforeSend: function() {
			$('#favorited_icon_'+id).toggle();
			$('#unfavorited_icon_'+id).toggle();        
		},
		success: function(data, textStatus, xhr) {

			if (!xhr.responseJSON) {
				notify("error", "Unknown error");
				return;
			}

			switch(xhr.responseJSON.success)
			{
				case true:
				if (xhr.responseJSON.favorited && !xhr.responseJSON.unfavorited) {
					$('#favorited_icon_'+id).hide();
					$('#unfavorited_icon_'+id).show();
					return;
				}
				if (!xhr.responseJSON.favorited && xhr.responseJSON.unfavorited) {
					$('#unfavorited_icon_'+id).hide();
					$('#favorited_icon_'+id).show();
					return;
				}
				break;
				
				case false:
				if (xhr.responseJSON.favorited) {
					$('#favorited_icon_'+id).toggle();
					$('#unfavorited_icon_'+id).toggle();        
					notify('error', xhr.responseJSON.message);
					return;
				}
				break;          
			}					

		},

		error: function(xhr, textStatus, errorThrown) { 
			
			if (!xhr.responseJSON) {
				notify("error", "Unknown error");
				return;
			}

			$('#favorited_icon_'+id).toggle();
			$('#unfavorited_icon_'+id).toggle();        

			if (!xhr.responseJSON.logged_in) { 
				$('#login_modal').modal({keyboard: true}, 'show');
				return;
			}        
		}		

	});
}

function favorite_product(id) {

	$.ajax({
		type: "POST",
		url: APP_URL + '/products/toggle-favorited',
		data: {
			'next_action': 'favorite_product', 
			'next_action_item': id, 
		},
		dataType: 'JSON',
		beforeSend: function() {
			$('#favorite_product_icon_'+id).toggleClass('fa-star');
			$('#favorite_product_icon_'+id).toggleClass('fa-star-o');
		},
		success: function(data, textStatus, xhr) {
			
			if (!xhr.responseJSON) {
				notify("error", "Unknown error");
				return;
			}

			switch(xhr.responseJSON.success)
			{
				case true:
				if (xhr.responseJSON.favorited && !xhr.responseJSON.unfavorited) {
					$('#favorite_product_icon_'+id).removeClass('fa-star');
					$('#favorite_product_icon_'+id).removeClass('fa-star-0');
					$('#favorite_product_icon_'+id).addClass('fa-star');	
					return;
				}
				if (!xhr.responseJSON.favorited && xhr.responseJSON.unfavorited) {
					$('#favorite_product_icon_'+id).removeClass('fa-star');
					$('#favorite_product_icon_'+id).removeClass('fa-star-0');
					$('#favorite_product_icon_'+id).addClass('fa-star-o');	
					return;
				}
				break;
				
				case false:
				if (xhr.responseJSON.favorited) {
					$('#favorite_product_icon_'+id).toggleClass('fa-star');
					$('#favorite_product_icon_'+id).toggleClass('fa-star-o');	     
					notify('error', xhr.responseJSON.message);
					return;
				}
				break;          
			}					

		},

		error: function(xhr, textStatus, errorThrown) { 
			
			if (!xhr.responseJSON) {
				notify("error", "Unknown error");
				return;
			}

			$('#favorite_product_icon_'+id).toggleClass('fa-star');
			$('#favorite_product_icon_'+id).toggleClass('fa-star-o');	

			if (!xhr.responseJSON.logged_in) { 
				$('#login_modal').modal({keyboard: true}, 'show');
				return;
			}        
		}		

	});
}

function favorite_user(id) {

	$.ajax({
		type: "POST",
		url: APP_URL + '/users/toggle-favorited',
		data: {
			'next_action': 'favorite_user', 
			'next_action_item': id, 
		},
		dataType: 'JSON',
		beforeSend: function() {
			$('#favorite_user_icon_'+id).toggleClass('fa-star');
			$('#favorite_user_icon_'+id).toggleClass('fa-star-o');     
		},
		success: function(data, textStatus, xhr) {

			if (!xhr.responseJSON) {
				notify("error", "Unknown error");
				return;
			}
			
			switch(xhr.responseJSON.success)
			{
				case true:
				if (xhr.responseJSON.favorited && !xhr.responseJSON.unfavorited) {
					$('#favorite_user_icon_'+id).removeClass('fa-star');
					$('#favorite_user_icon_'+id).removeClass('fa-star-0');
					$('#favorite_user_icon_'+id).addClass('fa-star');	
					return;
				}
				if (!xhr.responseJSON.favorited && xhr.responseJSON.unfavorited) {
					$('#favorite_user_icon_'+id).removeClass('fa-star');
					$('#favorite_user_icon_'+id).removeClass('fa-star-0');
					$('#favorite_user_icon_'+id).addClass('fa-star-o');	
					return;
				}
				break;
				
				case false:
				if (xhr.responseJSON.favorited) {
					$('#favorite_user_icon_'+id).toggleClass('fa-star');
					$('#favorite_user_icon_'+id).toggleClass('fa-star-o');	     
					notify('error', xhr.responseJSON.message);
					return;
				}
				break;          
			}					

		},

		error: function(xhr, textStatus, errorThrown) { 
			
			if (!xhr.responseJSON) {
				notify("error", "Unknown error");
				return;
			}

			$('#favorite_user_icon_'+id).toggleClass('fa-star');
			$('#favorite_user_icon_'+id).toggleClass('fa-star-o');	

			if (!xhr.responseJSON.logged_in) { 
				$('#login_modal').modal({keyboard: true}, 'show');
				return;
			}        
		}		

	});
}