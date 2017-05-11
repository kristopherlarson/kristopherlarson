<?php
/*
====================
	TEMPLATE NAME: Store
====================
*/ ?>

<?php get_header(); ?>

<main>

    <?php get_template_part( 'template-parts/woocommerce/hero', 'slider' ); ?>

    <div id="primary" class="content-area">

        <?php get_template_part( 'template-parts/woocommerce/featured', 'content' ); ?>

        <?php get_template_part( 'template-parts/woocommerce/featured', 'categories' ); ?>

        <?php get_template_part( 'template-parts/woocommerce/featured', 'products' ); ?>

        <?php get_template_part( 'template-parts/woocommerce/featured', 'popular' ); ?>

        <?php get_template_part( 'template-parts/woocommerce/featured', 'on-sale' ); ?>

        <?php get_template_part( 'template-parts/woocommerce/featured', 'best-selling' ); ?>

        <?php get_template_part( 'template-parts/woocommerce/featured', 'recently-added' ); ?>

    </div>

</main>


<?php get_footer(); ?>