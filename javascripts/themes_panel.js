jQuery(document).ready(function($){

	$('#colors').styleSwitcher({
		 cookieExpires: 60
	});

	$('.color-list li a, .bg-pattern li a, .bg-color li a, #layouts a').click(function(e){
		e.preventDefault();
		$(this).parent().parent().find('a').removeClass('active');
		$(this).addClass('active');
	})

	/* Change layouts on click and set cookie
	----------------------------------------------------------*/
	jQuery('#layouts a').click(function() {
	
		var layout_name = jQuery(this).attr('id');

		$.cookie('layout', layout_name, { expires: 0});
		jQuery('#page-wrap').removeClass().addClass(layout_name);

		return false;
	});	

	/* Change pattern on click and set cookie
	----------------------------------------------------------*/
	jQuery('#bg-pattern a, #bg-color a').click(function(){

		var pattern_name = jQuery(this).attr('title');
		
		$.cookie('pattern', pattern_name, { expires: 0, path: '/'});
		jQuery('body').removeClass().addClass(pattern_name);
		
		return false;
	});

	/* If cookie exists, apply classes from cookie
	----------------------------------------------------------*/
	if ($.cookie('pattern') != null)	{
		$.cookie('pattern',$.cookie('pattern'),{ expires: 0, path: '/'});
		jQuery('body').removeClass('').addClass($.cookie('pattern'));
	}
		
	if ($.cookie('layout') != null) {
		$.cookie('layout',$.cookie('layout'),{expires: 0});
		  jQuery('#page-wrap').removeClass('').addClass($.cookie('layout'));
	} else
	{
	  jQuery('#page-wrap').removeClass('').addClass('boxed');
	}

	/* Show or hide themes panel
	----------------------------------------------------------*/
	jQuery(function(){
		jQuery('#themes-panel').css('left', -jQuery('#themes-menu').outerWidth());
		
		jQuery('#toggle_button').click(function() {
			var themes_panel = jQuery(this).parent();
			
			themes_panel.animate({
			  left: parseInt(themes_panel.css('left'),10) == 0 ? -jQuery(this).prev().outerWidth() : 0
			});
			jQuery(this).toggleClass('left','right');
			return false;
		});
	});

});

	$.cookie = function(name, value, options) {
		if (typeof value != 'undefined') {
			options = options || {};
			if (value === null) {
				value = '';
				options.expires = -1;
			}
			var expires = '';
			if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
				var date;
				if (typeof options.expires == 'number') {
					date = new Date();
					date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
				} else {
					date = options.expires;
				}
				expires = '; expires=' + date.toUTCString();
			}
			var path = options.path ? '; path=' + (options.path) : '';
			var domain = options.domain ? '; domain=' + (options.domain) : '';
			var secure = options.secure ? '; secure' : '';
			document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
		} else {
			var cookieValue = null;
			if (document.cookie && document.cookie != '') {
				var cookies = document.cookie.split(';');
				for (var i = 0; i < cookies.length; i++) {
					var cookie = jQuery.trim(cookies[i]);
					if (cookie.substring(0, name.length + 1) == (name + '=')) {
						cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
						break;
					}
				}
			}
			return cookieValue;
		}
	};


