<?php
/* 
====================
  ENQUEUE CSS
====================
*/
if ( ! function_exists( 'amped_theme_styles' ) ) {

	function amped_theme_styles() {
		if ( is_front_page() ) {
			wp_enqueue_style( 'slick', THEME_CSS . 'vendor/slick/slick.css' );
		}
		wp_enqueue_style( 'app-css', THEME_CSS . 'app.css' );
	}

	if ( ! is_admin() ) {
		add_action( 'wp_enqueue_scripts', 'amped_theme_styles' );
	}

}

/* 
====================
  ENQUEUE SCRIPTS
====================
*/
if ( ! function_exists( 'amped_jquery_enqueue' ) ) {

	if ( ! is_admin() ) {
		add_action( "wp_enqueue_scripts", "amped_jquery_enqueue" );
	}
	function amped_jquery_enqueue() {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', "http" . ( $_SERVER['SERVER_PORT'] == 443 ? "s" : "" ) . "://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js", false, null );
		wp_enqueue_script( 'jquery' );
	}

}

if ( ! function_exists( 'amped_theme_scripts' ) ) {

	function amped_theme_scripts() {

		if ( is_front_page() ) {
			wp_enqueue_script( 'slick-js', THEME_JS_VENDOR . 'slick.min.js', array( 'jquery' ), null, true );
		}

		wp_enqueue_script( 'app-js', THEME_JS . 'app.js', array( 'jquery' ), null, true );
	}

	if ( ! is_admin() ) {
		add_action( 'wp_enqueue_scripts', 'amped_theme_scripts' );
	}

}