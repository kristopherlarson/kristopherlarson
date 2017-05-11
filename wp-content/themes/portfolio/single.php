<?php get_header(); ?>

<main>

    <?php get_template_part( 'template-parts/header/header-sub'); ?>

    <div id="primary" class="content-area">

        <?php get_template_part( 'template-parts/post/content-post-single' ); ?>

        <?php get_template_part( 'template-parts/pagination/pagination-single' ); ?>

        <?php // Comments
        if ( comments_open() || get_comments_number() ) {
	        comments_template();
        } ?>

        <?php // get_sidebar(); ?>

    </div>

</main>

<?php get_footer(); ?>