<?php
/*
====================
    FEATURED ON SALE PRODUCTS
====================
*/

if ( is_woocommerce_activated() ) {

	$args = apply_filters( 'amped_on_sale_products_args', array(
		'limit'   => 4,
		'columns' => 4,
		'title'   => __( 'On Sale', 'amped-theme' ),
	) );

	echo '<section class="on-sale-products" aria-label="On Sale Products">';

		echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

		echo amped_do_shortcode( 'sale_products', array(
			'per_page' => intval( $args['limit'] ),
			'columns'  => intval( $args['columns'] ),
		) );

	echo '</section>';
}