(function($){

	/*
	
		They want to show some love
	
	*/

	$('a.wpcl_love_this').live('click', function(e){

		e.preventDefault();
		
		if($(this).hasClass('loved'))
			return;
		
		var self = $(this);
		var post_url = self.attr('href') + '/wp-content/plugins/wpc_love/inc/php/ajax.php';
		var post_id = self.attr('id').replace('wpcl_post_', '');
		
		$.ajax({
			type: "POST",
			url: post_url,
			data: {post_id: post_id},
			dataType: 'json',
			success: function(response){
			
				if(response.loved === 1){
				
					var love_count = $('#love_count_' + post_id).text();
					love_count = parseInt(love_count) + 1;
									
					$('#love_count_' + post_id).text(love_count);
					$('#loved_text_' + post_id).text('Loved!');
					self.addClass('loved');
				
				}
			
			}
		});
	
	});

})(this.jQuery);