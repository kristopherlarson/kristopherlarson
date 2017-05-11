<?php

$args = array(
	'post_type'      => 'portfolio',
	'post_status'    => 'publish',
	'posts_per_page' => 10,
	'orderby'        => 'date',
);

$custom_query = new WP_Query( $args );

if ( $custom_query->have_posts() ) :

	while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

		<div id="carousel-item">
			<div class="carousel-image">

			</div>
		</div>

	<?php endwhile; ?>

<?php else : ?>
	<article>
		<h1>Sorry, no posts found!</h1>
	</article>
<?php endif; ?>

<?php wp_reset_postdata(); ?>