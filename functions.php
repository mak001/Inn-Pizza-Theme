<?php

// allow editors to use customizer
$editor = get_role('editor');
$editor->add_cap('edit_theme_options');
	
// resets the theme
if(isset($_POST['reset-InnPizza-theme'])) {
	remove_theme_mods();
	//redirects to self (so it doesnt keep resetting)
	header("location: {$_SERVER['PHP_SELF']}");
	exit;
}
	
// Add RSS links to <head> section
add_theme_support('automatic-feed-links');

// Clean up the <head>
function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

// Declare sidebar widget zone
function innPizza_widget_init() {
	register_sidebar(array(
		'name' => 'Specials Widget',
		'id'   => 'specials-widgets',
	));
}

add_action('widgets_init', 'innPizza_widget_init');


function register_my_menu() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' );

// custom code
function innPizza_register_customize_controls( $wp_customize ) {
	class Customize_Control_Line_Seperator extends WP_Customize_Control {
		public $type = 'line-seperator';
		
		public function render_content() {
			echo '<hr>';
		}
	}
	
	class Customize_Control_Reset_Button extends WP_Customize_Control {
		public $type = 'reset-button';
		
		public function render_content() {
			
			echo '<form method="post" action="">
					<input name="reset-InnPizza-theme" class="button" type="submit" value="Reset to theme default settings" >
				 </form>';
		}
	}
}

add_action('customize_register', 'innPizza_register_customize_controls');

// logo defaults
$default_logo = get_template_directory_uri() . '/images/logo.png';
$default_logo_alt = 'Village Inn Pizza Family Resturaunt';
$default_logo_width = '174';
$default_logo_height = '180';

$defualt_header_bg_image = get_template_directory_uri() . '/images/header_background.jpg';

$default_header_bg_color = '#ab0803';
$default_body_bg_color = '#7e391d';

//nav defaults
$default_nav_bg_color = '#dd0606';
$default_nav_link_color = '#FFFFFF';
$default_nav_link_bg_color = '#dd0606';
$default_nav_link_hover_color = '#FFFFFF';
$default_nav_link_hover_bg_color = '#ab0803';

//main defaults
$default_main_color = '#000000';
// #deb187
$default_main_bg_color = 'rgba(222, 177, 135, 0.75)';
$default_body_background = get_template_directory_uri() . '/images/background.jpg';

//footer defaults
$default_footer_color = '#FFFFFF';
$default_footer_bg_color = '#ab0803';


function innPizza_customize_register($wp_customize) {
	global $default_logo, $default_logo_alt, $default_logo_width, $default_logo_height, 
		$defualt_header_bg_image,
		$default_header_bg_color, $default_body_bg_color, $default_body_background, 
		$default_nav_bg_color, $default_nav_link_color, $default_nav_link_bg_color,
		$default_nav_link_hover_color, $default_nav_link_hover_bg_color,
		$default_main_color, $default_main_bg_color,
		$default_footer_color, $default_footer_bg_color;
	
	/* -------- Header section --------- */
	$wp_customize->add_section('innPizza_header' , array(
		'title' => __('Header'),
		'description' => 'Modify the header',
		'priority' => '30'
	)); 
	
	// logo image
	$wp_customize->add_setting('logo_image' , array(
		'default' => $default_logo,
		// 'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 
		'logo_image' , array(
			'label' => __('Logo Image'),
			'section' => 'innPizza_header',
			'settings' => 'logo_image'
		)
	));
	
	$wp_customize->add_setting('logo_image_width' , array(
		'default' => $default_logo_width,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control('logo_image_width' , array(
		'label' => __('Logo image width (in pixels)'),
		'section' => 'innPizza_header',
		'settings' => 'logo_image_width'
	));
	
	$wp_customize->add_setting('logo_image_height' , array(
		'default' => $default_logo_height,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control('logo_image_height' , array(
		'label' => __('Logo image height (in pixels)'),
		'section' => 'innPizza_header',
		'settings' => 'logo_image_height'
	));
	
	//logo_alt
	$wp_customize->add_setting('logo_alt' , array(
		'default' => $default_logo_alt,
	));
	
	$wp_customize->add_control('logo_alt' , array(
			'label' => __('Logo Image alt'),
			'section' => 'innPizza_header',
			'settings' => 'logo_alt',
			'type' => 'text'
	));
	
	// background image
	$wp_customize->add_setting('header_bg_image' , array(
		'default' => $defualt_header_bg_image,
	));
	
	$wp_customize->add_control(new WP_Customize_Image_Control( 
		$wp_customize,	'header_bg_image', array(
			'label' => 'Header background image',
			'section' => 'innPizza_header',
			'settings' => 'header_bg_image',
		)
	));
	
	// background color
	$wp_customize->add_setting('header_bg_color' , array(
		'default' => $default_header_bg_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'header_bg_color', array(
			'label' => 'Header background color',
			'section' => 'innPizza_header',
		)
	));
	
	//show tagline
	$wp_customize->add_setting('show_tagline' , array(
		'default' => '1',
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control('show_tagline', array(
			'type' => 'checkbox',
			'label' => 'Show tagline under logo',
			'section' => 'innPizza_header',
		)
	);
	/* -------- End Header section --------- */
	
	/* -------- Nav section ---------------- */
	$wp_customize->add_section('innPizza_nav' , array(
		'title' => __( 'Navigation'),
		'description' => 'Modify the nav bar'
	)); 
	
	$wp_customize->add_setting('nav_bg_color' , array(
		'default' => $default_nav_bg_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'nav_bg_color', array(
			'label' => 'Nav background color',
			'section' => 'innPizza_nav',
		)
	));
	
	// normal link
	$wp_customize->add_setting('nav_link_bg_color' , array(
		'default' => $default_nav_link_bg_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'nav_link_bg_color', array(
			'label' => 'Nav link background color',
			'section' => 'innPizza_nav',
		)
	));
	
	$wp_customize->add_setting('nav_link_color' , array(
		'default' => $default_nav_link_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'nav_link_color', array(
			'label' => 'Nav link color',
			'section' => 'innPizza_nav',
		)
	));
	
	// seperator
	$wp_customize->add_setting('nav_normal_hover_seperator', array(
		'type' => 'filter',
		'sanitize_callback' => 'absint',
	));
	
	$wp_customize->add_control(new Customize_Control_Line_Seperator(
		$wp_customize, 'nav_normal_hover_seperator', array(
			'section' => 'innPizza_nav',
			'type' => 'line-seperator'
		)
	));

	
	// hover
	$wp_customize->add_setting('nav_link_hover_bg_color' , array(
		'default' => $default_nav_link_hover_bg_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'nav_link_hover_bg_color', array(
			'label' => 'Nav link hover background color',
			'section' => 'innPizza_nav',
		)
	));
	
	$wp_customize->add_setting('nav_link_hover_color' , array(
		'default' => $default_nav_link_hover_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'nav_link_hover_color', array(
			'label' => 'Nav link hover color',
			'section' => 'innPizza_nav',
		)
	));
	
	/* ----------- End Nav section ------------ */
	
	/* ------------ Main section ---------------*/
	$wp_customize->add_section('innPizza_content' , array(
		'title' => __( 'Content'),
		'description' => 'Modify how the content looks'
	)); 
	
	$wp_customize->add_setting('body_bg_color' , array(
		'default' => $default_body_bg_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'body_bg_color', array(
			'label' => 'Body background color',
			'section' => 'innPizza_content',
		)
	));
	
	$wp_customize->add_setting('body_background_image' , array(
		'default' => $default_body_background,
		// 'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 
		'body_background_image' , array(
			'label' => __('Background Image'),
			'section' => 'innPizza_content',
			'settings' => 'body_background_image'
		)
	));
	
	$wp_customize->add_setting('main_bg_color' , array(
		'default' => $default_main_bg_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'main_bg_color', array(
			'label' => 'Content background color',
			'section' => 'innPizza_content',
		)
	));
	
	$wp_customize->add_setting('main_color' , array(
		'default' => $default_main_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'main_color', array(
			'label' => 'Content text color',
			'section' => 'innPizza_content',
		)
	));
	
   /* ------ End main section ------- */
   
   /* ---------- Footer section ----- */
   $wp_customize->add_section('innPizza_footer' , array(
		'title' => __( 'Footer'),
		'description' => 'Modify the footer'
	)); 
   
   $wp_customize->add_setting('footer_bg_color' , array(
		'default' => $default_footer_bg_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'footer_bg_color', array(
			'label' => 'Footer background color',
			'section' => 'innPizza_footer',
		)
	));
	
	$wp_customize->add_setting('footer_color' , array(
		'default' => $default_footer_color,
		'transport' => 'postMessage',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize,	'footer_color', array(
			'label' => 'Footer text color',
			'section' => 'innPizza_footer',
		)
	));
	/* ------ End footer section ------- */
	
	/* --------- Reset section ----------*/
    $wp_customize->add_section('innPizza_reset' , array(
		'title' => __( 'Reset'),
		'description' => 'Reset the theme'
	));
	
	$wp_customize->add_setting('theme_reset' , array(
		'default' => '',
	));
	
	$wp_customize->add_control(new Customize_Control_Reset_Button( 
		$wp_customize,	'theme_reset', array(
			'label' => 'Reset',
			'section' => 'innPizza_reset',
		)
	));
   
}


add_action( 'customize_register', 'innPizza_customize_register' );

function innPizza_css_customizer() {
	global $defualt_header_bg_image, $default_header_bg_color, $default_body_bg_color, 
		$default_nav_bg_color, $default_nav_link_color, $default_nav_link_bg_color,
		$default_nav_link_hover_color, $default_nav_link_hover_bg_color,
		$default_main_color, $default_main_bg_color, $default_body_background,
		$default_footer_color, $default_footer_bg_color;
	?>
	<style type="text/css">
		
		body {
			background-color: <?php	echo get_theme_mod('body_bg_color', $default_body_bg_color);	?>;
			background-image: url(<?php	
				if (get_theme_mod('body_background_image')) {
					echo get_theme_mod('body_background_image');
				} else {
					echo $default_body_background;
				}
			?>);
		}
		
		#header {
			background-color: <?php	echo get_theme_mod('header_bg_color', $default_header_bg_color);	?>;
			background-image: url(<?php	if (get_theme_mod('header_bg_image')) {
				echo get_theme_mod('header_bg_image');
			} else {
				echo $defualt_header_bg_image;
			}	?>);
		}
		
		#header-overlay {
			background-color: <?php	
				$color = hex2rgb(get_theme_mod('header_bg_color', $default_header_bg_color));
				echo 'rgba(' .$color['red'] . ',' . $color['green'] . ',' . $color['blue'] . ', 0.69)';	
			?>;
		}
		
		@media screen and (max-width: 450px) {
			#header-overlay {
				background-color: <?php	
					$color = hex2rgb(get_theme_mod('header_bg_color', $default_header_bg_color));
					echo 'rgba(' .$color['red'] . ',' . $color['green'] . ',' . $color['blue'] . ', 0.85)';	
				?>;
			}
		}
		
		nav {
			background-color: <?php	echo get_theme_mod('nav_bg_color', $default_nav_bg_color);	?>;
		}
		
		nav ul li:not(:last-child) {
			border-color: <?php	echo get_theme_mod('nav_link_color', $default_nav_link_color);	?>;
			/* TODO?? - line ~413 in functions.php*/
		}
		
		nav li:hover {
			/*	border-bottom: 1px solid white;	*/ 
			border-color: <?php	echo get_theme_mod('nav_link_hover_color', $default_nav_link_hover_color);	?>;
		}
		
		nav li a {
			background-color: <?php	echo get_theme_mod('nav_link_bg_color', $default_nav_link_bg_color);	?>;
			color: <?php	echo get_theme_mod('nav_link_color', $default_nav_link_color);	?>;
		}
		
		
		nav li a:hover {
			background-color: <?php	echo get_theme_mod('nav_link_hover_bg_color', $default_nav_link_hover_bg_color);	?>;
			color: <?php	echo get_theme_mod('nav_link_hover_color', $default_nav_link_hover_color);	?>;
		}
		
		main {
			background-color: <?php	echo get_theme_mod('main_bg_color', $default_main_bg_color);	?>;
			color: <?php	echo get_theme_mod('main_color', $default_main_color);	?>;
		}
		
		#footer {
			background-color: <?php	echo get_theme_mod('footer_bg_color', $default_footer_bg_color);	?>;
			box-shadow: 0px 500px 0px 500px <?php	echo get_theme_mod('footer_bg_color', $default_footer_bg_color);	?>;
			color: <?php	echo get_theme_mod('footer_color', $default_footer_color);	?>;
		}
		
	</style>
	
	<?php
}

add_action('wp_head', 'innPizza_css_customizer');

// For live preview
function mytheme_customizer_live_preview() {
	wp_enqueue_script( 
		  'innPizza-themecustomizer', //Give the script an ID
		  get_template_directory_uri().'/js/theme-customizer.js', //Point to file
		  array( 'jquery','customize-preview' ), //Define dependencies
		  '', //Define a version (optional) 
		  true //Put script in footer?
	);
}
add_action( 'customize_preview_init', 'mytheme_customizer_live_preview' );

function my_customizer_styles() { ?>
	<style>
		#accordion-panel-nav_menus, 
		#accordion-panel-widgets,
		#accordion-section-static_front_page {
			display: none !important;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'my_customizer_styles' );

// from https://css-tricks.com/snippets/php/convert-hex-to-rgb/
function hex2rgb($colour) {
	if ( $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
	}
	if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
	} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
	} else {
			return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

?>