<?php

$previous = get_adjacent_post( false, '', true );
$next     = get_adjacent_post( false, '', false );

if ( empty( $next ) && empty( $previous ) ) {
	return;
}

?>

<nav class="pagination pagination-single">

	<h3 id="pagination-label" class="visual-hide">
		Post Pagination
	</h3>

	<ol class="pagination-list">

		<?php if ( $previous ) { ?>
			<li class="pagination-list-item pagination-next">
				<a href="<?php echo esc_attr( get_permalink( $previous->ID ) ); ?>" rel="prev">
					<?php echo $previous->post_title; ?>
				</a>
			</li>
		<?php } ?>

		<?php if ( $next ) { ?>
			<li class="pagination-item pagination-previous">
				<a href="<?php echo esc_attr( get_permalink( $next->ID ) ); ?>" rel="next">
					<?php echo $next->post_title; ?>
				</a>
			</li>
		<?php } ?>

	</ol>

</nav>