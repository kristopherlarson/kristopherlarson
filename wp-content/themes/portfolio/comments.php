<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>

        <h4 class="comment-title">
            <?php
            printf( _n( '1 reply to &ldquo;%2$s&rdquo;', '%1$s replies to &ldquo;%2$s&rdquo;', get_comments_number(), 'foundation' ),
                number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            ?>
        </h4>

        <ol class="comment-list">
            <?php wp_list_comments( array(
                'callback' => 'foundation_comment',
                'style'    => 'ol'
            ) );
            ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
            <nav role="navigation">
                <h4>Comment navigation</h4>
                <div><?php previous_comments_link( '&larr; Older Comments' ); ?></div>
                <div><?php next_comments_link( 'Newer Comments &rarr;' ); ?></div>
            </nav>
        <?php }

        if ( ! comments_open() && get_comments_number() ) { ?>
            <p>Comments are closed.</p>
        <?php } ?>

    <?php endif; ?>

    <?php if ( comments_open() ) { ?>

        <div class="panel comment-form">
            <?php comment_form(); ?>
        </div>

    <?php } ?>

</div><!-- #comments -->
