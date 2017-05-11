<style>
	.mega-nav {
		opacity: 0;
	}
</style>
<?php
/*
====================
	NAVIGATION
====================
*/
wp_nav_menu( array(
	'theme_location'    => 'mega_nav',
	'container'         => false,
	'container_class'   => '',
	'menu_class'        => '',
	'menu_id'           => '',
	'depth'             => 3,
	'items_wrap' 		=> '<ul id="mega-menu" class="mega-nav">%3$s</ul>',
	'fallback_cb'       => false,
	'walker' 			=> new Mega_Walker_Nav_Menu()
) );
?>