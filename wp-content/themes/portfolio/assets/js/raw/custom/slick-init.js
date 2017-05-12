;( function( $ ) {

	'use strict';

	var el = document.getElementsByClassName('transition-slider'),
		$el = $( el );


	var init = function() {

		if ( el.length ) {
			runSlick();
			console.info( 'Initialized homepage transition sliders.' );
		}

	};


	var runSlick = function() {

		/****** NOTE: if options are changed don't forget to match in mobile-nav.js slick initializer. ******/

		$el.slick({
			autoplay: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplaySpeed: 1000,
			speed: 6500,
			fade: true,
			arrows: false,
			dots: false,
			responsive: [
				{
					breakpoint: 640,
					settings: {
						dots: false
					}
				}
			]
		})
	};

	// Remove styling
	var removeStyles = function() {
		$elImage.removeAttr('style');
		$el.removeAttr('style');
	};


	init();

} )( jQuery );









;( function( $ ) {

    'use strict';

    var el = document.getElementsByClassName('portfolio-carousel'),
        $el = $( el );


    var init = function() {

        if ( el.length ) {
            runSlick();
            console.info( 'Initialized homepage transition sliders.' );
        }

    };


    var runSlick = function() {

        /****** NOTE: if options are changed don't forget to match in mobile-nav.js slick initializer. ******/

        $el.slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
			arrows: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        })
    };

    // Remove styling
    var removeStyles = function() {
        $elImage.removeAttr('style');
        $el.removeAttr('style');
    };


    init();

} )( jQuery );