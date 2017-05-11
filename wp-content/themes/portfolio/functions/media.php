<?php

// Lazyload post content
add_filter( 'the_content', 'amped_enable_lazy_loading_the_content' );

// Lazyload post thumbnails
add_filter( 'post_thumbnail_html', 'amped_post_thumbnail_html', 10, 3 );

/**
 * Modifies the content to enable lazy loading for all <img> tags
 */
if ( ! function_exists( 'amped_enable_lazy_loading_the_content' ) ) {

	function amped_enable_lazy_loading_the_content( $content ) {
		return amped_lazyload_modify_img_tags( $content );
	}

}

/**
 * Modifies the post thumbnail html to enable lazy loading for the image
 */
if ( ! function_exists( 'amped_post_thumbnail_html' ) ) {

	function amped_post_thumbnail_html( $html, $post_id, $post_image_id ) {
		return amped_lazyload_modify_img_tags( $html );
	}

}

/**
 * Takes a string and modifies any <img> tags within it by:
 * - Adding the class 'lazyload'
 * - Modifying the 'src' attribute
 * - Changes 'srcset' and 'sizes' attributes to data-srcset and data-sizes
 */
if ( ! function_exists( 'amped_lazyload_modify_img_tags' ) ) {

	function amped_lazyload_modify_img_tags( $content ) {

		$content = mb_convert_encoding( $content, 'HTML-ENTITIES', "UTF-8" );

		// Get out if we don't have any content
		if ( empty( $content ) ) {
			return $content;
		}

		$document = new DOMDocument();
		libxml_use_internal_errors( true );
		$document->loadHTML( utf8_decode( $content ) );

		// Grab all image tags
		$imgs = $document->getElementsByTagName( 'img' );

		// Loop through all image tags
		foreach ( $imgs as $img ) {

			$existing_class = $img->getAttribute( 'class' );  // Store existing class (if the image has one applied)
			$src            = $img->getAttribute( 'src' );               // Store src attribute value
			$srcset         = $img->getAttribute( 'srcset' );
			$sizes          = $img->getAttribute( 'sizes' );

			// Add 'lazy' class and the existing class(es) to the image
			$img->setAttribute( 'class', "lazyload $existing_class" );

			// Add new data sizing
			$img->setAttribute( 'data-src', $src );
			$img->setAttribute( 'data-srcset', $srcset );
			$img->setAttribute( 'data-sizes', $sizes );

			// Change Src
			$img->setAttribute( 'src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' );

			// Remove normal responsive tags
			$img->removeAttribute( 'srcset' );
			$img->removeAttribute( 'sizes' );

		}

		$html = preg_replace( '/^<!DOCTYPE.+?>/', '', str_replace( array(
			'<html>',
			'</html>',
			'<body>',
			'</body>'
		), array( '', '', '', '' ), $document->saveHTML() ) );

		return $html;

	}

}