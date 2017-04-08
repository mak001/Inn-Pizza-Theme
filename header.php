<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<link rel="shortcut icon" href="/favicon.ico">
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<link rel="stylesheet" href="<?php echo bloginfo('template_url'); ?>/css/Soliloquy.css">
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>

	<?php wp_head(); ?>
	
	<?php
		// gets the defaults
		global $default_logo;
		global $default_logo_alt;
		global $default_logo_width;
		global $default_logo_height;
		
	?>
	
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.sticky.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.visible.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/nav.js"></script>
	<!--	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/Soliloquy.js"></script>	-->
</head>

<body <?php body_class(); ?>>
	<!--
	<p id="skipnav">
		<a href="#main">Skip navigation</a>
	</p>
	-->

	<div id="page-wrap">

		<header id="header">
			<div id="header-overlay"></div>
			<div id="header-container">
				<a href="<?php echo get_option('home'); ?>/">
					<img src="<?php
							// could not get the nice version of get_theme_mod to work
							if (get_theme_mod('logo_image')) {
								echo get_theme_mod('logo_image'); 
							} else {
								echo $default_logo;
							}
					?>" 
					width="<?php	echo get_theme_mod('logo_image_width', $default_logo_width)	?>" 
					height="<?php	echo get_theme_mod('logo_image_height', $default_logo_height)	?>" 
					alt="<?php echo get_theme_mod('logo_alt',  $default_logo_alt); ?>" 
					class="logo">
				</a>
				<?php	if (get_theme_mod('show_tagline')):	?>
				<div class="description"><?php bloginfo('description'); ?></div>
				<?php	endif;	?>
				</div>
		</header>
		<nav>
			<?php wp_nav_menu(array('theme_location' => 'header-menu', 'menu_id' => 'main-menu' )); //&#9776;  //&#735; ?>
			<div id="nav-header">
				Navigation
				<button class="hamburger"><span></span><span></span><span></span></button>
				<button class="cross"><span></span><span></span></button>
			</div>
			<div id="mobile-nav">
			</div>
		</nav>