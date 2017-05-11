<?php

/* 
====================
	SET EXCERPT - NO READMORE ( PERFECT FOR WIDGETS )
====================
*/
if ( ! function_exists( 'excerpt' ) ) {
	function excerpt( $limit ) {
		$excerpt = explode( ' ', get_the_excerpt(), $limit );
		if ( count( $excerpt ) >= $limit ) {
			array_pop( $excerpt );
			$excerpt = implode( " ", $excerpt ) . '...';
		} else {
			$excerpt = implode( " ", $excerpt );
		}
		$excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );

		return $excerpt;
	}
}

/* 
====================
	CUSTOM EXCERPT FOR BLOGS AND SUCH
====================
*/
if ( ! function_exists( 'custom_excerpt' ) ) {
	function custom_excerpt( $text ) {
		global $post;
		if ( '' == $text ) {
			$text           = get_the_content( '' );
			$text           = apply_filters( 'the_content', $text );
			$text           = str_replace( '\]\]\>', ']]&gt;', $text );
			$text           = preg_replace( '@<script[^>]*?>.*?</script>@si', '', $text );
			$text           = strip_tags( $text, '<p>' );
			$excerpt_length = 80;
			$words          = explode( ' ', $text, $excerpt_length + 1 );
			if ( count( $words ) > $excerpt_length ) {
				array_pop( $words );
				array_push( $words, '... <br><br><a href="' . get_permalink( $post->ID ) . '" class="button">Read More</a>' );
				$text = implode( ' ', $words );
			}
		}

		return $text;
	}

	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
	add_filter( 'get_the_excerpt', 'custom_excerpt' );
}

/* 
====================
	COMMENTS TEMPLATE
====================
*/
if ( ! function_exists( 'foundation_comment' ) ) {
	function foundation_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
				?>
                <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                <p>
                    Pingback: <?php comment_author_link(); ?> <?php edit_comment_link( '(Edit)', '<span>', '</span>' ); ?></p>
				<?php
				break;
			default :
				global $post;
				?>
            <li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                    <header>
						<?php
						echo "<span class='comment-gravatar'>";
						echo get_avatar( $comment, 44 );
						echo "</span>";
						printf( '%2$s %1$s',
							get_comment_author_link(),
							( $comment->user_id === $post->post_author ) ? '<span>Posted by: </span>' : ''
						);
						printf( '<br><a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf( __( '%1$s at %2$s', 'foundation' ), get_comment_date(), get_comment_time() )
						);
						?>
                    </header>
					<?php if ( '0' == $comment->comment_approved ) { ?>
                        <p>Your comment is awaiting moderation.</p>
					<?php } ?>
                    <section>
						<?php comment_text(); ?>
                    </section>
                    <div class="reply">
						<?php comment_reply_link( array_merge( $args, array(
							'reply_text' => 'Reply',
							'after'      => ' &darr; <br><br>',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth']
						) ) ); ?>
                    </div>
                </article>
				<?php
				break;
		}
	}
}

/* 
====================
	Pagination
====================
*/
if ( ! function_exists( 'amped_pagination' ) ) :
	function amped_pagination() {
		global $wp_query;

		$big = 999999999; // This needs to be an unlikely integer

		// For more options and info view the docs for paginate_links()
		// http://codex.wordpress.org/Function_Reference/paginate_links
		$paginate_links = paginate_links( array(
			'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'mid_size'  => 5,
			'prev_next' => true,
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'type'      => 'list',
		) );

		$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination'>", $paginate_links );
		$paginate_links = str_replace( '<li><span class="page-numbers dots">', "<li><a href='#'>", $paginate_links );
		$paginate_links = str_replace( "<li><span class='page-numbers current'>", "<li class='current'><a href='#'>", $paginate_links );
		$paginate_links = str_replace( '</span>', '</a>', $paginate_links );
		$paginate_links = str_replace( "<li><a href='#'>&hellip;</a></li>", "<li><span class='dots'>&hellip;</span></li>", $paginate_links );
		$paginate_links = preg_replace( '/\s*page-numbers/', '', $paginate_links );

		// Display the pagination if more than one page is found.
		if ( $paginate_links ) {
			echo '<div class="pagination-centered">';
			echo $paginate_links;
			echo '</div>';
		}
	}
endif;