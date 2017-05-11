<?php
/* 
====================
	FOOTER NAVIGATION
====================
*/
wp_nav_menu( array(
	'theme_location'	=> 'footer_nav',
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
	'items_wrap' 		=> '<ul class="footer-nav">%3$s</ul>',
	'depth' 			=> 1,
) ); 
?>