jQuery(document).ready(function($) {

	// ------------------------------------------------------------------------------ //
	// DDsmooth Drop-Down Menu //
	// ------------------------------------------------------------------------------ //

	(function() {

		ddsmoothmenu.init({
			mainmenuid: "navigation", //menu DIV id
			orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
			classname: 'ddsmoothmenu', //class added to menu's outer DIV
			contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		});

	})();


	// ------------------------------------------------------------------------------ //
	// Responsive Menu //
	// ------------------------------------------------------------------------------ //

	(function() {

		function initMenu () {
			$("#main-menu").tinyNav({
				active: 'selected', // String: Set the "active" class
				header: 'Navigate to...' // String: Specify text for "header" and show header instead of the active item
			});
		}

		initMenu();

	})();


	// ------------------------------------------------------------------------------ //
	// Content Slider Navigation Effect //
	// ------------------------------------------------------------------------------ //

	(function() {

		$('#content-slider-nav a:eq(0)').addClass('active');
		$('#content-slider-nav .tab-slider-inner-wrapper').append('<div id="active-indicator">&nbsp;</div>');
		
		$('#content-slider-nav a').click(function(event){
			event.preventDefault();
			if( !$(this).hasClass('active') ){
				$('#content-slider-nav a').removeClass('active');
				$(this).addClass('active');
				
				var linkPos = $(this).position();
				
				$('#active-indicator').animate({
					left: linkPos.left - 16
				});
			}
		});

	})();


	// ------------------------------------------------------------------------------ //
	// Equalize the Heights of Elements. //
	// ------------------------------------------------------------------------------ //

	(function() {

		$.fn.equalHeights = function(minHeight, maxHeight) {
			tallest = (minHeight) ? minHeight : 0;
			this.each(function() {
				if($(this).height() > tallest) {
					tallest = $(this).height();
				}
			});
			if((maxHeight) && tallest > maxHeight) tallest = maxHeight;
			return this.each(function() {
				$(this).css({'height': tallest});
			});
		}

		// Set Custom Blocks Max Height //
		//---------------------------------------------------------------- //
		var port_item_holder = $('.custom-blocks .block .equal-box');
		port_item_holder.equalHeights();

		$(window).resize(function(){
			port_item_holder.css('height','auto');
			port_item_holder.equalHeights();
		});


		// Set Icon Box Max Height //
		//---------------------------------------------------------------- //
		var ib_container = $('.icon-box.framed-box');
		ib_container.equalHeights();

		$(window).resize(function(){
			ib_container.css('height','auto');
			ib_container.equalHeights();
		});

	})();


	// ------------------------------------------------------------------------------ //
	// Team Member Hover Effect //
	// ------------------------------------------------------------------------------ //

	(function() {

		function memberHover() {
			$(".member-profile").hover(function () {
				$('.info', this).css({display: "none"}).slideDown('slow');
			}, function () {
				$('.info', this).css({display: "none"});
			});
			return false;
		}
		
		memberHover();

	})();


	// ------------------------------------------------------------------------------ //
	// Icon Box Hover Effect //
	// ------------------------------------------------------------------------------ //

	(function() {
		
		var $container = $('.ib-container'),
			$articles = $('.ib-container .icon-box'),
			timeout;
		
		$articles.on( 'mouseenter', function( event ) {
			var $article = $(this);
			clearTimeout( timeout );
			timeout = setTimeout( function() {
				if( $article.hasClass('active') ) return false;
				
				$articles.not( $article.removeClass('blur').addClass('active') )
						 .removeClass('active')
						 .addClass('blur');
			}, 65 );
		});
		
		$container.on( 'mouseleave', function( event ) {
			clearTimeout( timeout );
			$articles.removeClass('active blur');
		});
	
	})();


	// ------------------------------------------------------------------------------ //
	// FitVids //
	// ------------------------------------------------------------------------------ //

	(function() {

		$(".container").fitVids();

	})();


	// ------------------------------------------------------------------------------ //
	// Alert Boxes //
	// ------------------------------------------------------------------------------ //

	(function() {

		function initMessageBoxes() {
			$('.message-box .close').live('click', function() {
				$(this).parent().parent().fadeTo(400, 0.001).slideUp();
			});
		}

		initMessageBoxes();

	})();


	// ------------------------------------------------------------------------------ //
	// Set minimum height to the content so footer will stay at the bottom of the window //
	// ------------------------------------------------------------------------------ //

	(function() {

		function minHeight() {

			$('#content').css('min-height',
				$(window).outerHeight(true)	- ( $('body').outerHeight(true)	- $('body').height() ) - $('#header').outerHeight(true)
				- ( $('#content').outerHeight(true) - $('#content').height() ) - $('#footer').outerHeight(true) - $('#footer-bottom').outerHeight(true)
			);
		
		}

		minHeight();

		// Window resize
		$(window).on('resize', function() {

			var timer = window.setTimeout( function() {
				window.clearTimeout( timer );
				minHeight();
			}, 30 );

		});

	})();

	// ------------------------------------------------------------------------------ //
	// HTML5 Placeholder //
	// ------------------------------------------------------------------------------ //

	(function() {

		if(!Modernizr.input.placeholder){

			$('[placeholder]').focus(function() {
			  var input = $(this);
			  if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			  }
			}).blur(function() {
			  var input = $(this);
			  if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			  }
			}).blur();
			$('[placeholder]').parents('form').submit(function() {
			  $(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
				  input.val('');
				}
			  })
			});
			
		}

	})();
	

	// ------------------------------------------------------------------------------ //
	// Animated Scroll To Top //
	// ------------------------------------------------------------------------------ //

	(function() {

		// hide #scroll-top first
		$("#scroll-top").hide();

		// fade in #scroll-top
		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$('#scroll-top').fadeIn();
			} else {
				$('#scroll-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#scroll-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
		
		// Divider Top
		$(".divider a.top").click(function() {
			$('html, body').animate({scrollTop:0}, 'slow'); 
			return false;
		});

	})();


	// ------------------------------------------------------------------------------ //
	// Twitter Plugin Settings //
	// ------------------------------------------------------------------------------ //

	(function() {

		var $twitter_name = 'envato';
		
		//Content Twitter Count 1
		$("#content .section-wrap .twitter-wrap, #footer .twitter-wrap").tweet({
			username : $twitter_name,
			count : 1,
			template : "{join}{text}{time}",
			loading_text: "Loading tweets..."
		}).bind("loaded",function(){$(this).find("a").attr("target","_blank");});

		//Sidebar Twitter Count 2
		$("#sidebar .twitter-wrap").tweet({
			username : $twitter_name,
			count : 2,
			template : "{join}{text}{time}",
			loading_text: "Loading tweets..."
		}).bind("loaded",function(){$(this).find("a").attr("target","_blank");});

	})();


	// ------------------------------------------------------------------------------ //
	// Flickr Plugin Settings //
	// ------------------------------------------------------------------------------ //

	(function() {

		$('.flickr-wrap').jflickrfeed({
			limit: 6,
			qstrings: {
				id: '35220169@N04'
				},
			itemTemplate: '<li><a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
		});

	})();

	
	// ------------------------------------------------------------------------------ //
	// Google Map Plugin Settings //
	// ------------------------------------------------------------------------------ //

	(function() {

		$('.google-map').gMap({
			markers: [
				{
				address : 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
				html: '_address',
				title: "envato"
				}
			],
			address: 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
			zoom: 16,
			scrollwheel: false
		});

	})();


	// ------------------------------------------------------------------------------ //
	// Portfolio Hover Effect //
	// ------------------------------------------------------------------------------ //
 
	function portfolioHover() {

		$('.portfolio-item').hover(function(){
			$(".portfolio-icons", this).stop().animate({'bottom': '10px'},{queue:false,duration:300});
		}, function() {
			$(".portfolio-icons", this).stop().animate({'bottom': '-40px'},{queue:false,duration:300});
		});
		
		// For each image
		$('.portfolio-item .post-feature').each(function() {
			// If the image has a class of 'post-feature' and the children element doesn't have a 'mask-overlay' class
			if($(this).attr('class') == 'post-feature' && $(this).children().attr('class') !== 'mask-overlay') {
				$(this).css('cursor', 'default')
				$(this).prepend('<span class="mask-overlay"></span>');
			}
		});
		
		$('.portfolio-item').each(function(){
			$(this).find('.mask-overlay').css('opacity','0');
			$(this).hover(function(){
				$(this).find('.mask-overlay').stop().animate({'opacity': 0.2});	
			}, function(){
				$(this).find('.mask-overlay').stop().animate({'opacity': 0});
			});
		});

		return false;

	}
	
	portfolioHover();


	// ------------------------------------------------------------------------------ //
	// Image Hover Effect //
	// ------------------------------------------------------------------------------ //

	(function() {

		var $image_hover = $('a.image-icon-zoom, a.image-icon-link, a.image-icon-play, a.image-no-link');

		$image_hover.each(function(){

			if ($.browser.msie && parseInt($.browser.version, 10) < 7) {} else {
				if ($.browser.msie && parseInt($.browser.version, 10) < 9) {
					$(this).hover(function(){
						$(this).find('.image-overlay').css("visibility", "visible");
					},function(){
						$(this).find('.image-overlay').css("visibility", "hidden");
					}).children('img').before('<span class="mask-overlay"></span>').after('<span class="image-overlay"></span>');
				} else {
				$(this).hover(function(){
						$(this).find('.image-overlay').stop().animate({
							opacity: '1'
						},"fast");
					},function(){
						$(this).find('.image-overlay').stop().animate({
							opacity: '0'
						},"fast");
					}).children('img').before('<span class="mask-overlay"></span>').after($('<span class="image-overlay"></span>').css({opacity: '0',visibility:'visible'}));
				}
				
				$(this).find('.mask-overlay').css('opacity','0');

				$(this).hover(function(){
					$(this).find('.mask-overlay').stop().animate({'opacity': 0.3});	
				}, function(){
					$(this).find('.mask-overlay').stop().animate({'opacity': 0});
				});
			}
		});

		$('.image-no-link').click(function(){
			return false;
		});

	})();


	// ------------------------------------------------------------------------------ //
	// prettyPhoto Plugin Settings //
	// ------------------------------------------------------------------------------ //

	function prettyPhoto() {

		if ($('a.image-icon-zoom').attr('data-rel') == undefined || $('a.image-icon-zoom').attr('data-rel') == '') {
			$("a.image-icon-zoom").attr("data-rel","prettyPhoto");}
			
		if ($('a.image-icon-play').attr('data-rel') == undefined || $('a.image-icon-play').attr('data-rel') == '') {
			$("a.image-icon-play").attr("data-rel","prettyPhoto");}
			
		$(".portfolio-container > .portfolio-item .post-feature span").children("a.image-hover").attr("data-rel","prettyPhoto[gal]");
		
		$(".portfolio-container > .portfolio-item .post-feature span").children("a.video-hover").attr("data-rel","prettyPhoto[gal]");
		
		$(".portfolio-container > .portfolio-item .post-feature span").children("a.link-hover").removeAttr("data-rel");
								
		$("a.image-no-link").removeAttr("data-rel");
		
		$("a[data-rel^='prettyPhoto']").prettyPhoto({
			animation_speed: 'fast', // fast/slow/normal 
			opacity: 0.70, // Value between 0 and 1 
			show_title: true, // true/false 
			allow_resize: true, // Resize the photos bigger than viewport. true/false 
			default_width: 500,
			default_height: 344,
			theme: 'pp_default', // light_rounded / dark_rounded / light_square / dark_square / facebook 
			overlay_gallery: false, // If set to true, a gallery will overlay the fullscreen image on mouse over 
			deeplinking: false, // Allow prettyPhoto to update the url to enable deeplinking. 
			social_tools: false
		});

		return false;
	}
	
	prettyPhoto();


	// ------------------------------------------------------------------------------ //
	// QuickSand plugin Settings //
	// ------------------------------------------------------------------------------ //

	(function() {

		// Clone applications to get a second collection
		var $data = $(".portfolio-container").clone();
		
		//NOTE: Only filter on the main portfolio page, not on the subcategory pages
		$('.portfolio-filter a').click(function() {
			$(".portfolio-filter a").removeClass("selected");

			// Use the last category class as the category to filter by. This means that multiple categories are not supported (yet)
			var $filterClass = $(this).attr('id');
			
			if ($filterClass == 'all') {
				var $filteredData = $data.find('.portfolio-item');
			} else {
				var $filteredData = $data.find('.portfolio-item[data-type~=' + $filterClass + ']');
			}

			$(".portfolio-container").quicksand($filteredData, {
				duration: 800,
				easing: 'easeInOutQuad',
				adjustHeight: 'dynamic',
				enhancement: function() {
					portfolioHover();
					prettyPhoto();
				}
			});	

			$(this).addClass("selected"); 			
			return false;
		});

	})();


	// ------------------------------------------------------------------------------ //
	// Elements //
	// ------------------------------------------------------------------------------ //


		// Toggles //
		//---------------------------------------------------------------- //

		(function() {
			var $toggles = $(".toggle-title");

			$(".toggle-content").hide();

			$toggles.toggle(function() {
					$(this).addClass('toggle-active');
					$(this).siblings('.toggle-content').slideDown("fast");
				},
				function() {
					$(this).removeClass('toggle-active');
					$(this).siblings('.toggle-content').slideUp("fast");
			});

		})();


		// Tabs //
		//---------------------------------------------------------------- //

		(function() {

			$(".tabs-container").each(function() {
				var $history = $(this).attr('data-history');
				if($history!=undefined && $history == 'true'){
					$history = true;
				}else {
					$history = false;
				}
				var $initialIndex = $(this).attr('data-initialIndex');
				if($initialIndex==undefined){
					$initialIndex = 0;
				}
				$("ul.tabs",this).tabs("div.tab-content > div", {tabs:'a', effect: 'fade', fadeOutSpeed: -200, history: $history, initialIndex: $initialIndex});
			});

		})();


		// Accordion //
		//---------------------------------------------------------------- //

		(function() {

			$(".accordion").each(function() {
				var $initialIndex = $(this).attr('data-initialIndex');
				if($initialIndex==undefined){
					$initialIndex = 0;
				}
				$(this).tabs("div.accordion-content", {tabs: '.accordion-title', effect: 'slide',initialIndex: $initialIndex});
			});

		})();


	// ------------------------------------------------------------------------------ //
	// Contact Form //
	// ------------------------------------------------------------------------------ //

	(function() {

		$('form.contact-form').submit(function() {
			$('form.contact-form .error').remove();
			var hasError = false;
			$('.requiredField').each(function() {
				if($.trim($(this).val()) == '') {
					 var labelText = $(this).prev('label').text();
					 $(this).parent().append('<div class="error">Please enter your '+labelText+'</div>');
					 hasError = true;
				 } else if($(this).hasClass('email')) {
					 var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
					 if(!emailReg.test($.trim($(this).val()))) {
					 var labelText = $(this).prev('label').text();
					 $(this).parent().append('<div class="error">You entered an invalid '+labelText+'</div>');
					 hasError = true;
					 }
				 }
			});
			if(!hasError) {
				$('form.contact-form.submit').fadeOut('normal', function() {
					$(this).parent().append('');
				});
			var formInput = $(this).serialize();
				$.ajax({
					type: "POST",
					url: "contact_form.php",
					data: formInput,
					success: function(result) {
						$('.contact-form').slideUp('slow', function(){
							$('div#result').html(result);
							$('div#result').slideDown('slow');
						});
					}
				});
			}

			return false;

		});

	})();

		
});


$(window).load(function() {

	// ------------------------------------------------------------------------------ //
	// FlexSlider //
	// ------------------------------------------------------------------------------ //

		// Home Page Slider //
		//---------------------------------------------------------------- //
		$('.home-slider.flexslider').flexslider({
			animation: "fade"
		});

		// Portfolio Slider / Blog Slider //
		//---------------------------------------------------------------- //
		$('.portfolio-slider.flexslider, .blog-slider.flexslider').flexslider({
			animation: "fade",
			controlNav: false,
			slideshow: false
		});

		// Testimonials Slider //
		//---------------------------------------------------------------- //
		$('.testimonials-slider.flexslider').flexslider({
			animation: "slide",
			controlNav: false,
			smoothHeight: true,
			slideshow: false
		});


	// ------------------------------------------------------------------------------ //
	// Content Slides Slider //
	// ------------------------------------------------------------------------------ //

		$('.content-slider').slides({
			effect: 'fade',
			crossfade: false,
			generatePagination: false,
			autoHeight: true,
			fadeSpeed: 200
		});


});