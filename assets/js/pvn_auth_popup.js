jQuery(document).ready(function ($) {
	if(pvnap.user_loggein == '1'){
		if(jQuery(pvnap.login_handler).is('a')){
			jQuery(pvnap.login_handler).html(pvnap.logout_text).addClass('pvnap_logout');
		} else {
			jQuery(pvnap.login_handler+' a').html(pvnap.logout_text).addClass('pvnap_logout');
		}
		if(jQuery(pvnap.register_handler).length){
			jQuery(pvnap.register_handler).remove();
		} 
		jQuery('.pvnap_logout').click(function(e){
			
			//jQuery('body').prepend('<div class="pvnap_overlay"></div>');
			pvnap_overlay();
			jQuery('#pvnap_logout_popup').fadeIn(500);
			e.preventDefault();
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: pvnap.ajaxurl,
				data: {action:'pvnaplogout'},
				success: function (data) {
					if (data.logout == true) {
						window.location.reload();
					}
				}
			});
			e.preventDefault();
		});
	} else {
		// Display form from link inside a popup
		jQuery('#pvnap_pop_login, #pvnap_pop_signup').live('click', function (e) {
			formToFadeOut = jQuery('form#pvnap_register');
			formtoFadeIn = jQuery('form#pvnap_login');
			if (jQuery(this).attr('id') == 'pvnap_pop_signup') {
				formToFadeOut = jQuery('form#pvnap_login');
				formtoFadeIn = jQuery('form#pvnap_register');
			}
			formToFadeOut.fadeOut(500, function () {
				formtoFadeIn.fadeIn();
			})
			return false;
		});
		
		// Display lost password form 
		jQuery('#pvnap_pop_forgot').click(function(){
			formToFadeOut = jQuery('form#pvnap_login');
			formtoFadeIn = jQuery('form#pvnap_forgot_password');
			formToFadeOut.fadeOut(500, function () {
				formtoFadeIn.fadeIn();
			})
			return false;
		});

		// Close popup
		jQuery(document).on('click', '.close', function () {
			jQuery('form#pvnap_login, form#pvnap_register, form#pvnap_forgot_password').fadeOut(500, function () {
				//jQuery('.pvnap_overlay').remove();
				pvnap_overlay('hide');
			});
			return false;
		});

		// Show the login/signup popup on click
		jQuery(pvnap.login_handler).on('click', function (e) {
			//jQuery('body').prepend('<div class="pvnap_overlay"></div>');
			pvnap_overlay();
			jQuery('form#pvnap_login').fadeIn(500);
			e.preventDefault();
		});
		
		 jQuery(pvnap.register_handler).on('click', function (e) {
			//jQuery('body').prepend('<div class="pvnap_overlay"></div>');
			pvnap_overlay();
			jQuery('form#pvnap_register').fadeIn(500);
			e.preventDefault();
		});
		


		// Perform AJAX login/register on form submit
		jQuery('form#pvnap_login, form#pvnap_register').on('submit', function (e) {
			if (!jQuery(this).valid()) return false;
			jQuery('p.status', this).show().text(pvnap.loadingmessage);
			
			var form_data = {};
			form_data = jQuery(this).serialize();
			ctrl = jQuery(this);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: pvnap.ajaxurl,
				data: form_data,
				success: function (data) {
					if((jQuery(ctrl).attr ('id') == 'register') && (data.loggedin == false)) grecaptcha.reset();
					jQuery('p.status', ctrl).text(data.message);
					if (data.loggedin == true) {
						if(data.redirect == 'current'){
							window.location.reload();
						} else {
							window.location = data.redirect;
						}
					}
				}
			});
			e.preventDefault();
		});

		// Perform AJAX forget password on form submit
		jQuery('form#pvnap_forgot_password').on('submit', function(e){
			if (!jQuery(this).valid()) return false;
			jQuery('p.status', this).show().text(pvnap.loadingmessage);
			ctrl = jQuery(this);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: pvnap.ajaxurl,
				data: { 
					'action': 'ajaxforgotpassword', 
					'user_login': jQuery('#user_login').val(), 
					'security': jQuery('#forgotsecurity').val(), 
				},
				success: function(data){					
					jQuery('p.status',ctrl).text(data.message);				
				}
			});
			e.preventDefault();
			return false;
		});
	}
	// Client side form validation
    if (jQuery("#pvnap_register").length) 
		jQuery("#pvnap_register").validate();
    else if (jQuery("#pvnap_login").length) 
		jQuery("#pvnap_login").validate();
	if(jQuery('#pvnap_forgot_password').length)
		jQuery('#pvnap_forgot_password').validate();
});
function pvnap_overlay(act){
	if( pvnap.hide_overlay != 'yes'){
		if(jQuery('.pvnap_overlay').length == 0 ){
			jQuery('body').prepend('<div class="pvnap_overlay"></div>');
		}
		if(act == 'hide'){
			jQuery('.pvnap_overlay').hide();
		} else {
			jQuery('.pvnap_overlay').show();
		}
	} else {
		jQuery('.pvnap_overlay').remove();
	}
}