(function($) {
	
	// FROM http://stackoverflow.com/a/5624139
	function hexToRGB(hex) {
		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(shorthandRegex, function(m, r, g, b) {
			return r + r + g + g + b + b;
		});

		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	}
	
	function rgbFromString(rgba) {
		var result = /^(rgba\()?(\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*((\d{2})|(\d{0,1}.\d{0,}))\)$/i.exec(rgba);
		//console.log(result);
		return result ? {
			r: result[2],
			g: result[3],
			b: result[4]
		} : null;
	}
	
	$(window).resize(function() {
		var rgb = rgbFromString($('#header-overlay').css('background-color'));
		//console.log(rgb);
		var rgbString = rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'];
		$('#header-overlay').css({
			'background-color': 'rgba(' + rgbString + ', ' + getHeaderTransperency() + ')'
		});
	});
	
	function getHeaderTransperency() {
		if ($(window).width() > 450) {
			return '0.69';
		} 
		return '0.85';
	}

	wp.customize('body_bg_color', function(value) {
		value.bind(function(newVal) {
			$('body').css('background-color', newVal);
		});
	});
	
	wp.customize('body_background_image', function(value) {
		value.bind(function(newVal) {
			$('body').css('background-image', 'url(' + newVal + ')');
			console.log("new background image: " + newVal);
		});
	});
	
	/* --------- Header ----------*/
	wp.customize('header_bg_color', function(value) {
		value.bind(function(newVal) {
			$('#header').css('background-color', newVal);
			var rgb = hexToRGB(newVal);
			var rgbString = rgb['r'] + ', ' + rgb['g'] + ', ' + rgb['b'];
			$('#header-overlay').css({
				'background-color': 'rgba(' + rgbString + ', ' + getHeaderTransperency() + ')'
			});
		});
	});
	
	// Logo image
	wp.customize('logo_image', function(value) {
		value.bind(function(newVal) {
			$('.logo').attr('src', newVal);
		});
	});
	
	wp.customize('logo_image_width', function(value) {
		value.bind(function(newVal) {
			$('.logo').width(newVal);
		});
	});
	
	wp.customize('logo_image_height', function(value) {
		value.bind(function(newVal) {
			$('.logo').height(newVal);
		});
	});
	
	wp.customize('show_tagline', function(value) {
		value.bind(function(newVal) {
			if (newVal) {
				$('#header .description').css('display', 'block');
			} else {
				$('#header .description').css('display', 'none');
			}
		});
	});
	
	/* -------- Nav ----------- */
	wp.customize('nav_bg_color', function(value) {
		value.bind(function(newVal) {
			$('nav').css('background-color', newVal);
		});
	});
	
	wp.customize('nav_link_bg_color', function(value) {
		value.bind(function(newVal) {
			$('nav li a').css('background-color', newVal);
		});
	});
	
	wp.customize('nav_link_color', function(value) {
		value.bind(function(newVal) {
			$('nav li a').css('color', newVal);
		});
	});
	
	wp.customize('nav_link_hover_bg_color', function(value) {
		value.bind(function(newVal) {
			var style = '<style class="nav-hover-bg">nav li a:hover {background-color:' + newVal + ';}</style>';
			var preExisting = $('.nav-hover-bg');
			
			if (preExisting.length) {
				preExisting.replaceWith(style);
			} else {
				$('head').append(style);
			}
		});
	});
	
	wp.customize('nav_link_hover_color', function(value) {
		value.bind(function(newVal) {
			var style = '<style class="nav-hover-color">'+
			'nav li a:hover {color:' + newVal + ';}'+
			'nav li:hover {border-color:' + newVal + '}'+
			'</style>';
			var preExisting = $('.nav-hover-color');
			
			if (preExisting.length) {
				preExisting.replaceWith(style);
			} else {
				$('head').append(style);
			}
		});
	});
	
	/* -------- Main ----------- */
	wp.customize('main_bg_color', function(value) {
		value.bind(function(newVal) {
			$('main').css('background-color', newVal);
		});
	});
	
	wp.customize('main_color', function(value) {
		value.bind(function(newVal) {
			$('main').css('color', newVal);
		});
	});
	
	/* -------- Footer ----------- */
	wp.customize('footer_bg_color', function(value) {
		value.bind(function(newVal) {
			$('#footer').css({
				'background-color': newVal,
				'box-shadow': '0px 500px 0px 500px ' + newVal,
			});
			
		});
	});
	
	wp.customize('footer_color', function(value) {
		value.bind(function(newVal) {
			$('#footer').css('color', newVal);
		});
	});
	
}) ( jQuery );