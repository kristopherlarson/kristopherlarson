<?php
register_nav_menus(
	array(
		'main_nav'   => 'Main Navigation',
		'mega_nav'   => 'Mega Navigation',
		'footer_nav' => 'Footer Navigation',
	)
);

/* If sidebar needed use an example from below and uncomment code
if ( ! function_exists( 'amped_sidebar_widgets' ) ) {
	function amped_sidebar_widgets() {

		register_sidebar( array(
			'name'          => 'Main Sidebar',
			'id' 			=> 'sidebar-main',
			'description'   => 'Drag widgets to this sidebar container.',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

	}

	add_action( 'widgets_init', 'amped_sidebar_widgets' );
} */

?>