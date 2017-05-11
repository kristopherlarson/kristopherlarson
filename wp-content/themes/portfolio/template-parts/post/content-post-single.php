<?php
/* 
====================
    PAGE LOOP
====================
*/

while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( has_post_thumbnail() ) { ?>
            <a href="<?php the_permalink(); ?>"
               title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
		<?php } ?>
        <p class="date">Date: <?php the_time( get_option( 'date_format' ) ); ?></p>
        <p class="categories">Categories: <?php the_category( ', ' ); ?></p>
        <div>
			<?php the_content(); ?>
        </div>
        <footer>
            <p class="tags"><?php the_tags( '<span>', '</span><span>', '</span>' ); ?></p>
			<?php
            if ( comments_open() ) {
				comments_template();
            }
            ?>

        </footer>

    </article>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	    <?php if ( has_post_thumbnail() ) { ?>
            <?php the_post_thumbnail(); ?>
	    <?php } ?>

        <div class="post-single-content">
			<?php the_content(); ?>
        </div>

        <footer class="post-single-footer">

            <ul class="post-single-meta">

                <li class="post-single-date">
                    <time datetime="<?php echo esc_attr( get_the_time( 'c' ) ); ?>">
						<?php the_date();?>
                    </time>
                </li>

                <li class="post-single-author">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
						<?php the_author(); ?>
                    </a>
                </li>

            </ul>

			<?php get_template_part( 'template-parts/social/social-share' ); ?>

        </footer>

    </article>

<?php endwhile; ?>
