<?php
/*
====================
    FEATURED BEST SELLING PRODUCTS
====================
*/

if ( is_woocommerce_activated() ) {
	
	$args = apply_filters( 'amped_best_selling_products_args', array(
		'limit'   => 4,
		'columns' => 4,
		'title'	  => esc_attr__( 'Best Sellers', 'amped' ),
	) );
	
	echo '<section class="best-selling-products" aria-label="Best Selling Products">';

		echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';
	
		echo amped_do_shortcode( 'best_selling_products', array(
			'per_page' => intval( $args['limit'] ),
			'columns'  => intval( $args['columns'] ),
		) );

	echo '</section>';
}