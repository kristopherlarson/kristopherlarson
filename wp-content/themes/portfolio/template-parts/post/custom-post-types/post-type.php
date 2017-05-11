<?php
/* 
====================
    CUSTOM LOOP
====================
*/

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = array(
	'post_type'      => 'amped-post',
	'post_status'    => 'publish',
	'posts_per_page' => 10,
	'orderby'        => 'date',
	'paged'          => $paged,
);

$custom_query = new WP_Query( $args );

if ( $custom_query->have_posts() ) :

	while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="post-header">

                <h3 class="post-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_title(); ?>
                    </a>
                </h3>

                <div class="post-meta">
                    <div class="post-categories">
						<?php the_category(); ?>
                    </div>
                    <div class="post-tags">
						<?php the_tags(); ?>
                    </div>
                </div>

            </header>

			<?php if ( has_post_thumbnail() ) { ?>
                <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail(); ?>
                </a>
			<?php } ?>

			<?php the_excerpt(); ?>

            <footer class="post-footer">

                <ul class="post-info">
                    <li class="post-meta-date">
                        <time datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
							<?php the_time( 'F j, Y' ); ?>
                        </time>
                    </li>
                    <li class="post-meta-author">
                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
							<?php the_author(); ?>
                        </a>
                    </li>
                </ul>

            </footer>

        </article>

	<?php endwhile; ?>

	<?php // Amped pagination
	if ( function_exists( 'amped_pagination' ) ) {
		amped_pagination();
	} ?>

<?php else : ?>
    <article>
        <h1>Sorry, no posts found!</h1>
    </article>
<?php endif; ?>

<?php wp_reset_postdata(); ?>