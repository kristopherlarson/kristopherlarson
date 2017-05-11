<?php
/* 
====================
    FEATURED RECENTLY ADDED PRODUCTS
====================
*/


if ( is_woocommerce_activated() ) {

	$args = apply_filters( 'amped_recent_products_args', array(
		'limit' 			=> 4,
		'columns' 			=> 4,
		'title'				=> __( 'New In', 'amped-theme' ),
	) );

	echo '<section class="recently-added-products" aria-label="Recent Products">';

		echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

		echo amped_do_shortcode( 'recent_products', array(
			'per_page' => intval( $args['limit'] ),
			'columns'  => intval( $args['columns'] ),
		) );

	echo '</section>';
}