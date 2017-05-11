<?php /*
add_action( 'init', 'amped_post_init' );

function amped_post_init() {
	$labels = array(
		'name'               => 'Amped Post Type',
		'singular_name'      => 'Amped Post',
		'menu_name'          => 'Amped',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Amped Post',
		'new_item'           => 'New Amped Post',
		'edit_item'          => 'Edit Amped Post',
		'view_item'          => 'View Amped Post',
		'all_items'          => 'All Amped Posts',
		'search_items'       => 'Search Amped Posts',
		'parent_item_colon'  => '',
		'not_found'          => 'No Amped Posts found.',
		'not_found_in_trash' => 'No Amped Posts found in Trash.',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-editor-table',
		'supports'           => array( 'title', 'custom-fields' )
	);

	register_post_type( 'amped-post', $args );
} */