<?php
/* 
====================
	WORDPRESS CLEANER
====================
*/
if ( ! function_exists( 'amped_start_cleanup' ) ) {

	function amped_start_cleanup() {

		add_action( 'init', 'amped_cleanup_head' );
		add_filter( 'the_generator', 'amped_remove_rss_version' );
		add_filter( 'wp_head', 'amped_remove_wp_widget_recent_comments_style', 1 );
		add_action( 'wp_head', 'amped_remove_recent_comments_style', 1 );
		add_filter( 'amped_gallery_style', 'amped_gallery_style' );
		add_filter( 'embed_oembed_html', 'amped_embed', 99, 4 );
		add_filter( 'the_content', 'amped_wp_image_output', 12, 1 );

	}

	add_action( 'after_setup_theme', 'amped_start_cleanup' );

}

/* 
====================
	HEADER CLEANUP
====================
*/
if ( ! function_exists( 'amped_cleanup_head' ) ) {

	function amped_cleanup_head() {

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		add_filter( 'style_loader_src', 'amped_remove_wp_ver_css_js', 9999 );
		add_filter( 'script_loader_src', 'amped_remove_wp_ver_css_js', 9999 );

	}

};

/* 
====================
	REMOVE WP VERSION FROM RSS
====================
*/
if ( ! function_exists( 'amped_remove_rss_version' ) ) {
	function amped_remove_rss_version() {
		return '';
	}
};

/* 
====================
	REMOVE WP VERSION FROM SCRIPTS
====================
*/

if ( ! function_exists( 'amped_remove_wp_ver_css_js' ) ) {
	function amped_remove_wp_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}
};

/* 
====================
	REMOVE INJECTED CSS FROM COMMENTS
====================
*/
if ( ! function_exists( 'amped_remove_wp_widget_recent_comments_style' ) ) {
	function amped_remove_wp_widget_recent_comments_style() {
		if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
			remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
		}
	}
};

/* 
====================
	REMOVE INJECTED CSS FORM COMMENTS WIDGET
====================
*/
if ( ! function_exists( 'amped_remove_recent_comments_style' ) ) {
	function amped_remove_recent_comments_style() {
		global $wp_widget_factory;
		if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
			remove_action( 'wp_head', array(
				$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
				'recent_comments_style'
			) );
		}
	}
}

/* 
====================
	REMOVE INJECTED CSS FROM GALLERY
====================
*/
if ( ! function_exists( 'amped_gallery_style' ) ) {
	function amped_gallery_style( $css ) {
		return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
	}
};


/*
====================
WRAP VIDEO EMBEDS FLEX-VIDEO
====================
*/

if ( ! function_exists( 'amped_embed' ) ) {

	function amped_embed( $html, $url, $attr, $post_id ) {

		return '<div class="responsive-embed widescreen">' . $html . '</div>';

	}
};

/*
====================
CUSTOMIZE IMAGE OUTPUT
====================
*/
if ( ! function_exists( 'amped_wp_image_output' ) ) {

	function amped_wp_image_output( $html ) {

		$regex = '#((<\s*figure[^>]*?>)(.*?))?((<\s*a\s[^>]*?>)(.*?))?((<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>))((.*?)(</a>))?((.*?)(</figure>))?#i';
		$html  = preg_replace_callback( $regex, 'amped_image_wrap_regex_callback', $html );

		return $html;

	}
}


if ( ! function_exists( 'amped_image_wrap_regex_callback' ) ) {

	function amped_image_wrap_regex_callback( $matches ) {

		$full_match = $matches[0];
		$the_figure = $matches[2];
		$the_img = $matches[7];
		$the_img_src = $matches[9];

		$updated_image = str_replace( $the_img_src, $the_img_src, $the_img );

		if ( empty( $the_figure ) ) {
			$full_match = sprintf( '<figure class="wp-image-wrap">%s</figure>', $full_match );
		}

		return str_replace( $the_img, $updated_image, $full_match );

	}
}

?>