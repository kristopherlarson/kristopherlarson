<?php
/*
====================
    FEATURED POPULAR PRODUCTS
====================
*/

if ( is_woocommerce_activated() ) {

	$args = apply_filters( 'amped_popular_products_args', array(
		'limit'   => 4,
		'columns' => 4,
		'title'   => __( 'Fan Favorites', 'amped-theme' ),
	) );

	echo '<section class="popular-products" aria-label="Popular Products">';

		echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

		echo amped_do_shortcode( 'top_rated_products', array(
			'per_page' => intval( $args['limit'] ),
			'columns'  => intval( $args['columns'] ),
		) );

	echo '</section>';
}