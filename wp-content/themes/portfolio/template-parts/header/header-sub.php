<?php

global $post;

$header_image_large = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'sub-page');

?>


<header class="page-header">
	<div class="hero-sub background-cover" style="background-image: url('<?php echo $header_image_large[0]; ?>');">

		<?php if ( is_404() ) { ?>
			<h1>Page Not Found!</h1>
		<?php } elseif ( is_search() ) { ?>
			<h1><?php printf( 'Search Results for: %s', get_search_query() ); ?></h1>
		<?php } elseif ( is_home() ) { ?>
			<h1>Blog</h1>
		<?php } else { ?>
			<h1><?php the_title(); ?></h1>
		<?php } ?>

	</div>
</header>
