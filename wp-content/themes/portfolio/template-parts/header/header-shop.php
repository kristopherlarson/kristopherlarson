<?php
/* 
====================
	HEADER
====================
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="always" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link href="<?php echo THEME_IMAGES; ?>/favicon.ico" rel="icon" type="image/x-icon">
	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="main-container">

		<header id="masthead" class="site-header">

			<div class="row">
				<div class="small-6 columns">
					<a href="<?php echo home_url(); ?>" class="logo">
						<img src="<?php echo THEME_IMAGES; ?>logo.png" alt="<?php echo get_bloginfo('name'); ?>">
						<?php /* <svg class="icon icon-logo"><use xlink:href="#icon-logo" /></svg> */ ?>
					</a>
				</div>
				<div class="small-6 columns">
					<nav class="main-nav">
						<button class="mobile-trigger" type="button">
							<?php _e( 'Menu', 'amped-theme'); ?>
							<span class="mobile-trigger-box">
								<span class="mobile-trigger-inner"></span>
							</span>
						</button>
	                    <?php get_template_part( 'templates/menu', 'nav' ); ?>
						<?php //get_template_part( 'templates/menu', 'mega-nav' ); ?>
                	</nav>
                </div>
			</div>

			<?php
			/**
			 * Functions hooked into amped_header action
			 *
			 * @hooked storefront_product_search - 40
			 * @hooked storefront_header_cart    - 60
			 */
			do_action( 'amped_header' ); ?>

		</header>

	<div id="<?php echo is_front_page() ? 'home' : 'page' ?>-content" class="site-content">