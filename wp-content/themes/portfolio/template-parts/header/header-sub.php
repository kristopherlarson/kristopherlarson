<?php


?>


<header class="page-header">

    <?php if ( is_404() ) { ?>
        <h1>Page Not Found!</h1>
    <?php } elseif ( is_search() ) { ?>
        <h1><?php printf( 'Search Results for: %s', get_search_query() ); ?></h1>
    <?php } elseif ( is_home() ) { ?>
        <h1>Blog</h1>
    <?php } else { ?>
        <h1><?php the_title(); ?></h1>
    <?php } ?>

</header>
