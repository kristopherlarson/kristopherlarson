<?php
/*
====================
    FEATURED CATEGORIES
====================
*/

if ( is_woocommerce_activated() ) {

	$args = apply_filters( 'amped_product_categories_args', array(
		'limit' 			=> 3,
		'columns' 			=> 3,
		'child_categories' 	=> 0,
		'orderby' 			=> 'name',
		'title'				=> __( 'Shop by Category', 'amped-theme' ),
	) );

	echo '<section class="feature-categories" aria-label="Product Categories">';

		echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

		do_action( 'amped_homepage_after_product_categories_title' );

		echo amped_do_shortcode( 'product_categories', array(
			'number'  => intval( $args['limit'] ),
			'columns' => intval( $args['columns'] ),
			'orderby' => esc_attr( $args['orderby'] ),
			'parent'  => esc_attr( $args['child_categories'] ),
		) );

	echo '</section>';
}