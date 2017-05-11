<?php
/*
====================
    FEATURED STORE CONTENT
====================
*/
if(have_posts()) {
	while(have_posts()) {
		the_post(); ?>

		<article id="page-<?php the_ID(); ?>" <?php post_class('amped-content'); ?> role="article">
			<?php the_content(); ?>
		</article>

	<?php } ?>

<?php } else { ?>

	<article id="post-not-found">
		<h2>Not Found</h2>
		<p>Sorry, but the requested URL is not on website.</p>
	</article>

<?php } ?>