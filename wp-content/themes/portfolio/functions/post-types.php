<?php


// Create Portfolio Custom Post Type
add_action( 'init', 'portfolio_init' );

function portfolio_init() {
	$labels = array(
		'name'               => 'Portfolio',
		'singular_name'      => 'Portfolio',
		'menu_name'          => 'Portfolio',
		'name_admin_bar'     => 'Portfolio',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Portfolio',
		'new_item'           => 'New Portfolio',
		'edit_item'          => 'Edit Portfolio Item',
		'view_item'          => 'View Portfolio',
		'all_items'          => 'All Portfolio Items',
		'search_items'       => 'Search Portfolio Items',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-format-gallery',
		'supports'           => array( 'title')
	);

	register_post_type( 'portfolio', $args );

}