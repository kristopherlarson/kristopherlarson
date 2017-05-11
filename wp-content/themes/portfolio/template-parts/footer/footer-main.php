<footer class="footer">
    <div class="footer-copyright">
        <h6>
            &copy; <?php echo date( 'Y' ); ?>
            <a href="<?php echo esc_url( home_url() ); ?>" rel="bookmark">
                <?php bloginfo( 'name' ); ?>
            </a>
            <span><?php _e( 'All Rights Reserved', 'amped-theme' ); ?></span>
        </h6>
    </div>

    <nav class="footer-nav">
        <?php // Footer Menu
        get_template_part('template-parts/navigation/menu-footer'); ?>
    </nav>

    <a href="https://tenthmusedesign.com" rel="nofollow" target="_blank">Inspired by Tenth Muse Design</a>
</footer>