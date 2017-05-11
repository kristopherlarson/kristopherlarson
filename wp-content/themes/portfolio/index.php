<?php get_header(); ?>

<main>

    <?php get_template_part( 'template-parts/header/header-sub'); ?>

    <div id="primary" class="content-area">

        <?php get_template_part( 'template-parts/post/content-post-loop' ); ?>

        <?php // get_sidebar(); ?>

    </div>

</main>

<?php get_footer(); ?>