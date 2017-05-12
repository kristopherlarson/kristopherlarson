<section class="transition-slider">

    <?php

    $slider_images = get_field('transition_slider');

    if (!empty($slider_images)):

        foreach ($slider_images as $slider_image): ?>

            <figure>

                <div class="media-cover background-cover lazyload"
                     data-bgset="<?php echo $slider_image['sizes']['slider-image-small']; ?> [(max-width: 960px)] |
                                <?php echo $slider_image['sizes']['slider-image']; ?> [(max-width: 1280px)] |
                                <?php echo $slider_image['sizes']['slider-image-retina']; ?>"
                     data-sizes="auto" role="img" aria-label="<?php the_title(); ?>">

            </figure>

        <?php endforeach; ?>

    <?php endif; ?>

</section>
