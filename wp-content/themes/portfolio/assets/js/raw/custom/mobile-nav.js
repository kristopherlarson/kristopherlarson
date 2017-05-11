;( function( $, document ) {

	'use strict';

	var el = document.getElementsByClassName( 'mobile-trigger' ),
		$el = $( el ),
		$mainNav = $( '.main-nav'),
		$body = $( document.body ),
		$bodyHtml = $( 'body, html' ),
		desktopWidth = 960,
		$featuredSlider = $( '.featured-slider' ),
		textToChange = el[0].childNodes[0],
		$window = $( window );

	// Debounce utility for resize event so it doesn't fire too many times.
	var debounce = function(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};

	// Because of fixed positioning slick has to be reinitialized.
	var runSlick = function() {

		$featuredSlider.slick({
			autoplay: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: true,
			autoplaySpeed: 2500,
			speed: 2500,
			fade: true,
			arrows: true
		});

	};

	var changeMenuTriggerText = function() {

		if ( $el.hasClass('is-active') ) {
			textToChange.nodeValue = 'Close';
		} else {
			textToChange.nodeValue = 'Menu';
		}

	};

	var setupMobileAriaAttributes = function() {

		// Button
		$el.attr({
				'aria-label'   : 'Site Navigation Toggle',
				'aria-expanded': false,
				'aria-controls': 'navigation',
				'aria-haspopup': true
			});

		// Navigation
		$mainNav.attr({
				'aria-hidden'    : true,
				'aria-labelledby': 'trigger-nav'
			});

	};

	var addActiveMobileAriaAttributes = function() {

		// Button
		$el.attr( 'aria-expanded', true );

		// Navigation
		$mainNav.attr( 'aria-hidden', false );

	};

	var removeActiveMobileAriaAttributes = function() {

		// Button
		$el.attr( 'aria-expanded', false );

		// Navigation
		$mainNav.attr( 'aria-hidden', true );

	};

	var removeMobileAriaAttributes = function() {

		// Button
		$el.removeAttr( 'aria-label aria-expanded aria-controls aria-haspopup' );

		// Navigation
		$mainNav.removeAttr( 'aria-hidden aria-labelledby' );

	};

	var checkForResize = debounce(function(e) {

		if ( $window.width() >= desktopWidth ) {

			if ( $body.hasClass('mobile-nav-active') ) {
				$bodyHtml.removeClass('no-scroll');
				$body.removeClass('mobile-nav-active');
				$body.addClass('desktop-nav-active');
				$el.removeClass('is-active');
			}

			changeMenuTriggerText();
			removeMobileAriaAttributes();

		} else {

			setupMobileAriaAttributes();

		}

	}, 500);

	var toggleMobileNav = function( e ) {

		if ( e ) {
			e.preventDefault();
			e.stopPropagation();
		}

		$bodyHtml.toggleClass('no-scroll');
		$body.toggleClass('desktop-nav-active mobile-nav-active');
		$el.toggleClass('is-active');

		if ( $el.hasClass('is-active') ) {

			addActiveMobileAriaAttributes();

		} else {

			removeActiveMobileAriaAttributes();

			// Because of fixed positioning slick has to be reinitialized.
			$featuredSlider.slick('unslick');
			runSlick()

		}

		changeMenuTriggerText();
	};

	var bindEvents = function() {

		$body.on( 'click', '.mobile-trigger', function ( e ) {
			toggleMobileNav( e );
		});

		window.addEventListener("resize", checkForResize, false);

	};

	var init = function() {

		if ( el.length ) {

			$body.addClass( 'desktop-nav-active' );
			bindEvents();
			console.info( 'Initialized mobile menu.' );
		}

	};

	init();

} )( jQuery, document );