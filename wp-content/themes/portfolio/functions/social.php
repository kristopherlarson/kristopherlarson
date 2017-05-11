<?php
/**
 * Template Tags: Social Sharing
 */


/**
 * Massages a link for use in social shares.
 *
 * @param string $url The url to parse
 *
 * @return string
 */

function social_parse_url( $url = '' ) {

	if ( ! is_scalar( $url ) ) {
		$url = '';
	}

	$scheme = parse_url( $url, PHP_URL_SCHEME );
	if ( empty( $scheme ) ) {
		$url = home_url( $url );
	}

	return $url;

}


/**
 * Test location and returns an array of data containing title, link, and body + image
 *
 * @param array $enabled_networks An array of enabled social networks.
 *
 * @return array
 */

function get_social_share_data( $enabled_networks = array() ) {

	global $wp_query;

	$data = [];

	if ( is_singular() || $wp_query->in_the_loop ) {

		global $post;

		$data['link']  = social_parse_url( get_permalink( $post->ID ) );
		$data['title'] = wp_strip_all_tags( esc_attr( get_the_title( $post ) ) );
		$data['body']  = esc_attr( $post->post_excerpt );

		// only hunt for a featured image if pinterest active, and if we are on single.
		// No pinterest for loops, because thats silly.
		if ( in_array( 'pinterest', $enabled_networks ) && has_post_thumbnail( $post->ID ) ) {

			$image             = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'slider-image' );
			$data['image_src'] = $image[0];

		}

	} elseif ( is_tax() || is_category() || is_tag() ) {

		$obj = get_queried_object();

		$data['link']  = social_parse_url( get_term_link( $obj, $obj->taxonomy ) );
		$data['title'] = wp_strip_all_tags( esc_attr( $obj->name ) );
		$data['body']  = esc_attr( $obj->description );

	} elseif ( is_post_type_archive() ) {

		$obj = get_queried_object();

		$data['link']  = social_parse_url( get_post_type_archive_link( $obj->name ) );
		$data['title'] = wp_strip_all_tags( esc_attr( $obj->label ) );
		$data['body']  = esc_attr( $obj->description );

	} elseif ( is_search() ) {

		$query = get_search_query();

		$data['link']  = social_parse_url( get_search_link( $query ) );
		$data['title'] = sprintf( __( 'Search Results: %s' ), esc_attr( $query ) );

	}

	return $data;
}


/**
 * Tests the network and returns a formatted a tag for that network with post/loop data injected into it.
 *
 * @param string $network The network key.
 * @param array $data Share data supplied by get_social_share_data()
 *
 * @return string
 */

function get_social_share_link( $network = '', $data = array() ) {

	$class = '  class="visual-hide"';

	switch ( $network ) {

		case "email":
			return sprintf(
				'<a href="mailto:?subject=%1$s&body=%2$s" title="%3$s"><span%4$s>%3$s</span><span class="font-icon icon-email"></span></a>',
				urlencode( $data['title'] ),
				urlencode( esc_url_raw( $data['link'] ) ),
				__( 'Share through Email' ),
				$class
			);

		case "print":
			return sprintf(
				'<a class="icon icon-print" href="#" title="%1$s" onclick="window.print();return false;"><span%2$s>%1$s</span><span class="font-icon icon-print"></span></a>',
				__( 'Print this page' ),
				$class
			);

		case "google":
			return sprintf(
				'<a class="share-popup" href="https://plus.google.com/share?url=%1$s" data-width="624" data-height="486" title="%2$s"><span class="font-icon icon-google"></span></a>',
				urlencode( esc_url_raw( $data['link'] ) ),
				__( 'Share on Google+' ),
				$class
			);

		case "pinterest";
			if ( empty( $data['image_src'] ) ) {
				$link = '';
			} else {
				$link = sprintf(
					'<a class="share-popup" href="http://pinterest.com/pin/create/button/?url=%1$s&amp;media=%2$s&amp;description=%3$s" data-width="624" data-height="300" title="%4$s"><span%5$s>%4$s</span><svg class="social-svg"><span class="font-icon icon-pinterest"></span></a>',
					urlencode( esc_url_raw( $data['link'] ) ),
					urlencode( esc_url_raw( $data['image_src'] ) ),
					urlencode( $data['title'] ),
					__( 'Share on Pinterest' ),
					$class
				);
			}

			return $link;

		case "twitter":
			$text = substr( $data['title'], 0, 140 - strlen( $data['link'] ) - 4 );
			if ( $text !== $data['title'] ) {
				$text .= "...";
			}

			return sprintf(
				'<a class="share-popup" href="https://twitter.com/share?url=%1$s&text=%2$s" data-width="550" data-height="450" title="%3$s"><span%4$s>%3$s</span><span class="font-icon icon-twitter"></span></a>',
				urlencode( esc_url( $data['link'] ) ),
				urlencode( $text ),
				__( 'Share on Twitter' ),
				$class
			);

		case "facebook":
			return sprintf(
				'<a class="share-popup" href="http://www.facebook.com/sharer.php?u=%1$s&t=%2$s" data-width="640" data-height="352" title="%3$s"><span%4$s>%3$s</span><span class="font-icon icon-facebook"></span></a>',
				urlencode( esc_url( $data['link'] ) ),
				urlencode( $data['title'] ),
				__( 'Share on Facebook' ),
				$class
			);

		case "linkedin":
			return sprintf(
				'<a class="share-popup" href="http://www.linkedin.com/shareArticle?mini=true&url=%1$s&title=%2$s" data-width="640" data-height="352" title="%3$s"><span%4$s>%3$s</span><span class="font-icon icon-linkedin"></span></a>',
				urlencode( esc_url( $data['link'] ) ),
				urlencode( $data['title'] ),
				__( 'Share on LinkedIn' ),
				$class
			);

		default:
			return '';
			break;
	}

}


/**
 * Loops over enabled networks and builds an array of formatted share links using get_social_share_link()
 *
 * @param array $enabled_networks An array of enabled social networks.
 *
 * @return array
 */

function get_social_share_links( $enabled_networks = array() ) {

	$data = get_social_share_data( $enabled_networks );

	if ( empty( $data ) ) {
		return null;
	}

	$links = array();

	foreach ( $enabled_networks as $network ) {
		$links[] = get_social_share_link( $network, $data );
	}

	return $links;

}


/**
 * Template tag that outputs share link html as long as some networks are enabled and we have data to work with.
 *
 * @param boolean $echo whether to echo or return
 *
 * @return string
 */

function the_social_share_links( $enabled_networks = array(), $echo = true ) {

	if ( empty( $enabled_networks ) ) {
		return null;
	}

	$links = get_social_share_links( $enabled_networks );

	if ( empty( $links ) ) {
		return null;
	}

	$social_share = sprintf( '<nav class="social-sharing"><ul class="social-icons"><li>%s</li></ul></nav>',
		implode( '</li><li>', array_filter( $links ) )
	);

	if ( $echo ) {
		echo $social_share;
	} else {
		return $social_share;
	}

}