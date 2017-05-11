<?php while ( have_posts() ) : the_post(); ?>

    <article id="page-<?php the_ID(); ?>" <?php post_class( 'base-content' ); ?>>
        <?php the_content(); ?>
    </article>

<?php endwhile; ?>
