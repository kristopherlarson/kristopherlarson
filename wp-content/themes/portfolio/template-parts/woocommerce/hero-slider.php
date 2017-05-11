<?php
/*
====================
    SLIDER STORE
====================
*/


?>
<section class="featured-slider store-hero-slider">

	<?php
	$slider_images = get_field('store_hero_images', 'option');
	//    echo '<pre>';
	//    print_r($slider_images);
	//    echo '</pre>';

	if( ! empty( $slider_images ) ):

		foreach( $slider_images as $slider_image ): ?>

			<figure class="slider-image">
				<img class="lazyload"
				     data-src="<?php echo $slider_image['sizes']['slider-image']; ?>"
				     data-srcset="<?php echo $slider_image['sizes']['slider-image-small']; ?> 960w,
		                <?php echo $slider_image['sizes']['slider-image']; ?> 1280w,
		                <?php echo $slider_image['sizes']['slider-image-retina']; ?> 1920w"
				     alt="<?php echo $slider_image['alt']; ?>" />

				<div class="slider-caption">
					<h2><?php echo $slider_image['caption'] ?></h2>
				</div>
			</figure>

		<?php endforeach; ?>

	<?php endif; ?>

</section>
