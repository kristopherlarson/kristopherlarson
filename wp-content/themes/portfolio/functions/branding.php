<?php
/*
====================
	Modify the admin footer text
====================
*/

add_filter( 'admin_footer_text', 'amped_modify_footer_admin' );

function amped_modify_footer_admin() {
	echo '<span id="footer-thankyou">Theme Development by <a href="https://tenthmusedesign.com" target="_blank">Tenth Muse Design</a></span>';
}

/*
====================
	Login Screen: Use your own URL for login logo link
====================
*/

add_filter( 'login_headerurl', 'amped_url_login' );
function amped_url_login() {

	return get_bloginfo( 'wpurl' ); //This line keeps the link on current website instead of WordPress.org
}

/*
====================
	Login Screen: Change login logo hover text
====================
*/

add_filter( 'login_headertitle', 'amped_login_logo_url_title' );
function amped_login_logo_url_title() {

	return 'GET AMPED!';

}

/*
====================
	Login Screen: Set 'remember me' to be checked
====================
*/

add_action( 'init', 'amped_login_checked_remember_me' );
function amped_login_checked_remember_me() {

	add_filter( 'login_footer', 'amped_rememberme_checked' );
}

function amped_rememberme_checked() {

	echo "<script>document.getElementById('rememberme').checked = true;</script>";

}

/*
====================
	Add theme info box into WordPress Dashboard
====================
*/

add_action( 'wp_dashboard_setup', 'amped_add_dashboard_widgets' );
function amped_add_dashboard_widgets() {

	wp_add_dashboard_widget( 'wp_dashboard_widget', 'Theme Details', 'amped_theme_info' );

}

function amped_theme_info() {

	echo "<ul>
  <li><strong>Developed By:</strong> Tenth Muse Design</li>
  <li><strong>Website:</strong> <a href='https://tenthmusedesign.com'>https://tenthmusedesign.com</a></li>
  <li><strong>Email:</strong> <a href='mailto:zach@tenthmusedesign.com'>zach@tenthmusedesign.com</a></li>
  <li><strong>Phone:</strong> 435-359-2546</li>
  </ul>";

}


/*
====================
	Removes Useless Links From The Admin Menu
====================
*/


function amped_remove_logo_and_submenu() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'about' );
	$wp_admin_bar->remove_menu( 'wporg' );
	$wp_admin_bar->remove_menu( 'documentation' );
	$wp_admin_bar->remove_menu( 'support-forums' );
	$wp_admin_bar->remove_menu( 'feedback' );
}

add_action( 'wp_before_admin_bar_render', 'amped_remove_logo_and_submenu' );


/*
====================
	Adds Custom Logo In Admin Screen
====================
*/


function wpb_custom_logo() {
	echo '
<style type="text/css">
#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
background-image: url(' . get_bloginfo( 'stylesheet_directory' ) . '/images/global/mini-m.svg) !important;
background-position: 0 0;
color:rgba(0, 0, 0, 0);
background-repeat: no-repeat;
top: 3px;

}
#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
background-position: 0 0;
}
</style>
';
}

//hook into the administrative header output
add_action( 'wp_before_admin_bar_render', 'wpb_custom_logo' );


/*
====================
	Cleans up Admin Dashboard Clutter
====================
*/


function amped_remove_dashboard_widgets() {

	global $wp_meta_boxes;

	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );

	remove_action( 'wp_version_check', 'wp_version_check' );
	remove_action( 'admin_init', '_maybe_update_core' );
	add_filter( 'pre_transient_update_core', create_function( '$a', "return null;" ) );

}

add_action( 'wp_dashboard_setup', 'amped_remove_dashboard_widgets' );


/*
====================
	Admin Color Scheme
====================
*/


function register_color_scheme() {
	wp_admin_css_color( "amped", "Amused", get_stylesheet_directory_uri() . "/css/admin.css", array(
		"#217D94",
		"#363b3f",
		"#9098A0",
		"#8BC251"
	) );
}

add_action( "admin_init", "register_color_scheme" );


/*
====================
	Force Users To Amped Color Scheme
====================
*/

add_filter( 'get_user_option_admin_color', 'change_admin_color' );
function change_admin_color( $result ) {
	return 'amped';
}