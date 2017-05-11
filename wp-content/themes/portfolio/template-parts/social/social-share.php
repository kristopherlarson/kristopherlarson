<aside class="social-share">

	<h6 class="visual-hide social-share-title">
		Share On Social Media
	</h6>

	<?php // Share Buttons
	$social_links = the_social_share_links( array( 'facebook', 'twitter', 'email' ), false );

	if( ! empty( $social_links ) ) { ?>
		<?php echo $social_links; ?>
	<?php } ?>

</aside>