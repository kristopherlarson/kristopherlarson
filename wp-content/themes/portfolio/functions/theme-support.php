<?php
/* 
====================
	FUNCTIONS - SUPPORT
====================
*/

if ( ! function_exists( 'custom_support' ) ) {

	function custom_support() {

		// Localize theme
		load_theme_textdomain( 'amped-theme' );

		// Featured Images
		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'caption'
		) );

		add_theme_support( 'title-tag' );

		// Automatic Feed Links & Post Formats
		// add_theme_support( 'automatic-feed-links' );
		// Post Formats http://codex.wordpress.org/Post_Formats
		// add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery', 'status' ) );
	}

	add_action( 'after_setup_theme', 'custom_support' );

}