<header id="masthead" class="site-header">

    <div class="logo">
        <img src="<?php echo THEME_IMAGES; ?>logo.png" alt="<?php echo get_bloginfo('name'); ?>">
    </div>

    <nav class="main-nav" aria-label="Site Navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
        <button class="mobile-trigger" type="button">
			<?php _e( 'Menu', 'amped-theme'); ?>
            <span class="mobile-trigger-box">
						<span class="mobile-trigger-inner"></span>
					</span>
        </button>
		<?php //get_template_part( 'template-parts/navigation/menu-nav' ); ?>
		<?php //get_template_part( 'templates-parts/navigation/mega-nav' ); ?>
    </nav>

</header>