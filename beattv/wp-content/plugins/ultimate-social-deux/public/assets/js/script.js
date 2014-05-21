 (function () {

	function us_mail_send() {

		var your_name = jQuery('.us_mail_your_name').val(),
			your_email = jQuery('.us_mail_your_email').val(),
			recipient_email = jQuery('.us_mail_recipient_email').val(),
			message = jQuery('.us_mail_message').val(),
			captcha = jQuery('.us_mail_captcha').val();

		jQuery.ajax({
			type: 'POST',
			url: us_script.ajaxurl,
			data: {
				action: 'us_send_mail',
				your_name: your_name,
				your_email: your_email,
				recipient_email: recipient_email,
				message: message,
				captcha: captcha
			},

			success: function(response){

				var responseElement = jQuery('.us_mail_response');
				var us_mail_form = jQuery('.us_mail_form_holder');

				responseElement
					.hide()
					.removeClass('alert alert-danger alert-success');

				if (response === "ok") {
					responseElement
						.fadeIn()
						.html(us_script.success)
						.addClass('alert alert-success');

					us_mail_form
						.html('');

					setTimeout(function() {
						jQuery('.us_modal');
							jQuery.magnificPopup.instance.close();
					}, 2000);
				} else {
					responseElement
						.fadeIn()
						.html(response)
						.addClass('alert alert-danger');
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown){
				console.log(errorThrown);
			}

		});

	}

	jQuery(document).ready(function() {

		jQuery('.us_mail_send').on('click', function(){
			us_mail_send();
		});

		jQuery('.us_mail').magnificPopup({
			type:'inline',
			midClick: true,
			removalDelay: 300,
			mainClass: 'us_mail_fade us_wrapper'
		});


		jQuery('.us_facebook').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.facebook_color }, 400 );
		});
		jQuery('.us_twitter').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.twitter_color }, 400 );
		});
		jQuery('.us_googleplus').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.googleplus_color }, 400 );
		});
		jQuery('.us_pinterest').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.pinterest_color }, 400 );
		});
		jQuery('.us_linkedin').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.linkedin_color }, 400 );
		});
		jQuery('.us_stumble').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.stumble_color }, 400 );
		});
		jQuery('.us_delicious').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.delicious_color }, 400 );
		});
		jQuery('.us_buffer').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.buffer_color }, 400 );
		});
		jQuery('.us_mail').hover( function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.hover_color }, 400 );
		}, function(){
		    jQuery(this).stop(true, false).animate({backgroundColor: us_script.mail_color }, 400 );
		});
		jQuery('.us_total').ultimate_social_deux({
			share: {
				twitter: true,
				facebook: true,
				googlePlus: true,
				pinterest: true,
				delicious: true,
				buffer: true,
				linkedin: true,
				stumble: true
			},
			enableHover: false,
			template: '<div class="us_box"><div class="us_share">' + us_script.total_shares_text + '</div><div class="us_count" href="#">{total}</div></div>',
			urlCurl: us_script.sharrre_url
		});
		jQuery('.us_twitter').ultimate_social_deux({
			share: {
				twitter: true
			},
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-twitter"></i></div><div class="us_count" href="#">{total}</div></a>',
			buttons: {
				twitter: {
					via: us_script.tweet_via
				}
			},
			click: function(api, options){
				api.simulateClick();
				api.openPopup('twitter');
				return false;
			}
		});
		jQuery('.us_facebook').ultimate_social_deux({
			share: {
				facebook: true
			},
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-facebook"></i></div><div class="us_count" href="#">{total}</div></a>',
			click: function(api, options){
				api.simulateClick();
				api.openPopup('facebook');
				return false;
			}
		});
		jQuery('.us_googleplus').ultimate_social_deux({
			share: {
				googlePlus: true
			},
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-gplus"></i></div><div class="us_count" href="#">{total}</div></a>',
			urlCurl: us_script.sharrre_url,
			click: function(api, options){
				api.simulateClick();
				api.openPopup('googlePlus');
				return false;
			}
		});
		jQuery('.us_pinterest').ultimate_social_deux({
			share: {
				pinterest: true
			},
			buttons: {
				pinterest: {
				    url: jQuery('.us_pinterest').attr("data-url"),
				    media: jQuery('.us_pinterest').attr("data-media"),
				    description: jQuery('.us_pinterest').attr("data-text")
				}
			},
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-pinterest"></i></div><div class="us_count" href="#">{total}</div></a>',
			urlCurl: us_script.sharrre_url,
			click: function(api, options){
				api.simulateClick();
				api.openPopup('pinterest');
				return false;
			}
		});
		jQuery('.us_linkedin').ultimate_social_deux({
			share: {
				linkedin: true
			},
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-linkedin"></i></div><div class="us_count" href="#">{total}</div></a>',
			click: function(api, options){
				api.simulateClick();
				api.openPopup('linkedin');
				return false;
			}
		});
		jQuery('.us_stumble').ultimate_social_deux({
			share: {
				stumbleupon: true
			},
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-stumbleupon"></i></div><div class="us_count" href="#">{total}</div></a>',
			urlCurl: us_script.sharrre_url,
			click: function(api, options){
				api.simulateClick();
				api.openPopup('stumbleupon');
				return false;
			}
		});
		jQuery('.us_delicious').ultimate_social_deux({
			share: {
				delicious: true
			},
			urlCurl: us_script.sharrre_url,
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-delicious"></i></div><div class="us_count" href="#">{total}</div></a>',
			click: function(api, options){
				api.simulateClick();
				api.openPopup('delicious');
				return false;
			}
		});
		jQuery('.us_buffer').ultimate_social_deux({
			share: {
				buffer: true
			},
			enableHover: false,
			template: '<a class="us_box" href="#"><div class="us_share"><i class="us-icon-buffer"></i></div><div class="us_count" href="#">{total}</div></a>',
			click: function(api, options){
				api.simulateClick();
				api.openPopup('buffer');
				return false;
			}
		});
	});

}(jQuery));