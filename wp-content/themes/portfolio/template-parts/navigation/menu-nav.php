<style>
	.navbar {
		opacity: 0;
		height: 0;
	}
</style>
<?php
/* 
====================
	NAVIGATION
====================
*/
wp_nav_menu( array(
	'theme_location'	=> 'main_nav',
	'menu'				=> '',
	'container'       	=> false,
	'container_class' 	=> '',
	'container_id'    	=> '',
	'menu_class'      	=> '',
	'menu_id'         	=> '',
	'echo'            	=> true,
	'fallback_cb' 		=> false,
	'before'          	=> '',
	'after'           	=> '',
	'link_before'     	=> '',
	'link_after'      	=> '',
	'items_wrap' 		=> '<ul id="main-navigation" class="navbar">%3$s</ul>',
	'depth' 			=> 2,
	'walker' 			=> new Custom_Nav_Menu()
) ); 
?>