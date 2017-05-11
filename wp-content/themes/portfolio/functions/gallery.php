<?php
/* 
====================
	WORDPRESS GALLERY USES FRESCO FOR LIGHTBOX
====================
*/

// Gallery example: http://www.wcwcd.org/news-information/gallery/

/** Uncomment for custom image size **
 * add_image_size( 'gallery-size', 258, 171, true );
 *
 * if ( ! function_exists( 'amped_gallery_sizing' ) ) {
 * function amped_gallery_sizing( $sizes ) {
 * return array_merge( $sizes, array(
 * 'gallery-size' => __( 'Gallery Size' ),
 * ) );
 * }
 * add_filter( 'image_size_names_choose', 'amped_gallery_sizing' );
 * }
 */

if ( ! function_exists( 'amped_gallery_shortcode' ) ) {
	/*
	Changes Wordpress's default gallery shortcode to output display as Fresco Gallery. Post thumbnails will need to be edited to the desired size 
	*/
	remove_shortcode( 'gallery', 'gallery_shortcode' );
	add_shortcode( 'gallery', 'amped_gallery_shortcode' );

	function amped_gallery_shortcode( $attr ) {
		global $post, $wp_locale;
		static $instance = 0;
		$instance ++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) ) {
				$attr['orderby'] = 'post__in';
			}
			$attr['include'] = $attr['ids'];
		}

		$output = apply_filters( 'post_gallery', '', $attr );
		if ( $output != '' ) {
			return $output;
		}

		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( ! $attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		$atts = shortcode_atts( array(
			'order'   => 'ASC',
			'orderby' => 'menu_order ID',
			'id'      => $post ? $post->ID : 0,
			'itemtag' => 'div',
			'icontag' => 'figure',
			'size'    => 'gallery-thumbnail',
			'include' => '',
			'exclude' => '',
			'link'    => ''
		), $attr, 'gallery' );

		$id = intval( $atts['id'] );
		if ( 'RAND' == $atts['order'] ) {
			$atts['orderby'] = 'none';
		}

		if ( ! empty( $atts['include'] ) ) {
			$_attachments = get_posts( array( 'include'        => $atts['include'],
			                                  'post_status'    => 'inherit',
			                                  'post_type'      => 'attachment',
			                                  'post_mime_type' => 'image',
			                                  'order'          => $atts['order'],
			                                  'orderby'        => $atts['orderby']
			) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$attachments = get_children( array( 'post_parent'    => $id,
			                                    'exclude'        => $atts['exclude'],
			                                    'post_status'    => 'inherit',
			                                    'post_type'      => 'attachment',
			                                    'post_mime_type' => 'image',
			                                    'order'          => $atts['order'],
			                                    'orderby'        => $atts['orderby']
			) );
		} else {
			$attachments = get_children( array( 'post_parent'    => $id,
			                                    'post_status'    => 'inherit',
			                                    'post_type'      => 'attachment',
			                                    'post_mime_type' => 'image',
			                                    'order'          => $atts['order'],
			                                    'orderby'        => $atts['orderby']
			) );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
			}

			return $output;
		}

		$itemtag    = tag_escape( $atts['itemtag'] );
		$icontag    = tag_escape( $atts['icontag'] );
		$valid_tags = wp_kses_allowed_html( 'post' );
		if ( ! isset( $valid_tags[ $itemtag ] ) ) {
			$itemtag = 'div';
		}
		if ( ! isset( $valid_tags[ $icontag ] ) ) {
			$icontag = 'figure';
		}

		$selector = "gallery-{$instance}";

		$size_class = sanitize_html_class( $atts['size'] );

		$output .= "<{$itemtag} class='image-gallery'>";

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$attachmentMeta = wp_get_attachment_metadata( $id, false );
			$image_output   = wp_get_attachment_image_src( $id, $atts['size'], false );
			$image_link     = wp_get_attachment_image_src( $id, 'large', false );
			$title          = $attachment->post_title;
			// Uncomment for thumbnail meta, but it will need to be styled.
			//foreach ( $attachmentMeta as $meta => $value) {
			//echo '<pre>'. print_r($value->thumbnail->file, true) .'</pre>';
			//}
			//echo '<pre>'. print_r($attachmentMeta, true) .'</pre>';

			$output .= "
	            <{$icontag}>
	                <a href='" . $image_link[0] . "' class='fresco' data-fresco-group='" . $selector . "' data-fresco-caption='" . trim( wptexturize( $attachment->post_excerpt ) ) . "'>
	                	<span class='overlay'><span class='fa fa-icon-search'></span></span>
	                	<img src='" . $image_output[0] . "' alt='" . $title . "'>
	                </a>
	            </{$icontag}>
	        ";

		}

		$output .= "</{$itemtag}>";

		$output .= "
	            <div class='clear'></div>";

		return $output;
	}
}