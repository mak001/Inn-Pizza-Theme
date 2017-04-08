(function($) {
	
	var totalVisibility = false;

	function menuVisibility(navVisibility, headerVisibility) {
		if ($(window).width() > 500) {
			$('#mobile-nav, .cross, #nav-header').hide();
			$('.hamburger').show();
		} else {
			//nothing in the top is visible / on screen
			if (!navVisibility && !headerVisibility) {
				//so hamburger re-appears when scrolling up with it open and then down (really fast and during its animation)
				$('#mobile-nav').finish();
				$('#nav-header').show();
			} else {
				// hides the hamburger menu if it is shown
				if ($('#mobile-nav').css('display') == 'block') {
					$('#mobile-nav').slideUp(250, 'linear', function() {
						$('.hamburger').show();
						$('.cross').hide();
						$('#nav-header').hide();
					});
				} else {
					//so it doesnt delay hiding when hamburger isnt open
					$('#nav-header').hide();
				}
			}
		}
	}
	
	$(document).ready(function() {
		$("nav").sticky({
			topSpacing: 0,
			responsiveWidth: true,
		});
			
		/* Sets the height because it may vary browser to browser */
		$('#nav-header').css({
			height: $('nav li:last-child').height() + 'px',
		});
		
		$('#nav-header .hamburger, #nav-header .cross').css({
			height: $('#nav-header').height(),
			width: $('#nav-header').height(),
		});
		
		$('#mobile-nav').css({
			top: $('nav li:last-child').height() + 'px',
		});
		
		$('.cross').hide();
		
		old_visible = $('nav li:last-child').visible(totalVisibility);
		
		//runs the handler on scroll, resize and load (unsure if load actually works)
		$(window).on('DOMContentLoaded load resize scroll', function() {
				menuVisibility($('nav li:last-child').visible(totalVisibility), $('header').visible(true));
			}
		);
		
		if ($(window).width() <= 500) {
			//manually trigger it so if the page is loaded to a specific element it will show up without scrolling
			menuVisibility(old_visible, $('header').visible(true));
		}
	});
	
	$(window).load(function(){
		/* Clones the nav so it can be used in the hamburger later */
		$('#main-menu').clone().attr('id', '').appendTo('#mobile-nav');
		
		// opens/closes the hamburger menu
		$('#nav-header').click(function() {
			$('#mobile-nav').slideToggle(
				500, 'linear', function() {
					$('.cross, .hamburger').toggle();
				}
			);
		});
		
		$('body').on('touchmove', function(event) {
			if ($('#mobile-nav').css('display') == 'block') {
				event.preventDefault();
			}
		});
	});
	
}) (jQuery);