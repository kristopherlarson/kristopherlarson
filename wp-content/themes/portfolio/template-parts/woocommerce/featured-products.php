<?php
/*
====================
    FEATURED PRODUCTS - Marked featured
====================
*/

if ( is_woocommerce_activated() ) {

	$args = apply_filters( 'amped_featured_products_args', array(
		'limit'   => 8,
		'columns' => 4,
		'orderby' => 'date',
		'order'   => 'desc',
		'title'   => __( 'We Recommend', 'amped-theme' ),
	) );

	echo '<section class="featured-products" aria-label="Featured Products">';

		echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

		echo amped_do_shortcode( 'featured_products', array(
			'per_page' => intval( $args['limit'] ),
			'columns'  => intval( $args['columns'] ),
			'orderby'  => esc_attr( $args['orderby'] ),
			'order'    => esc_attr( $args['order'] ),
		) );

	echo '</section>';
}