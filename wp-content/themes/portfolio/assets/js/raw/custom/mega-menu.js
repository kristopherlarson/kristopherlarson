;(function ($, document, window) {

    'use strict';

    // Setup Vars
    var el = document.getElementById('mega-menu'),
        $el = $(el),
        $body = $(document.body),
        desktopWidth = 960,
        $window = $(window),
        $mainMenuItems = $el.children('.menu-item'),
        $subMenu = $('.sub-menu'),
        $menuTriggers = $mainMenuItems.find('.is-parent-trigger'),
        win = typeof window != 'undefined' && window,
        doc = typeof document != 'undefined' && document,
        docElem = doc && doc.documentElement,
        viewportW = function() {
            var a = docElem['clientWidth'], b = win['innerWidth'];
            return a < b ? b : a;
        };

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

    // Aria attributes setup
    var setupMenuAriaAttributes = function (){

        // Parent Menu Items
        $menuTriggers
            .attr({
                'aria-expanded': false,
                'aria-haspopup': true
            });

        // Child Menus
        $subMenu
            .attr({
                'aria-hidden': true,
                'role': 'group'
            });

        $.each( $menuTriggers, function( item, value ) {
            var $itemSubMenu = $(value).next( '.sub-menu' );
            var $subMenuID = $itemSubMenu.attr( 'id' );

            // Parent Menu Items
            $(value)
                .attr({
                    'aria-controls': $subMenuID,
                    'aria-owns': $subMenuID
                });

            // Child Menus
            $itemSubMenu.attr( 'aria-labelledby', $(value).attr( 'id' ) );

        });

    };

    //Setup navigation menu open Aria
    var setupMenuOpenAriaAttributes = function($trigger) {
        $trigger.attr('aria-expanded', true);
        $trigger.next( '.sub-menu' ).attr( 'aria-hidden', false );
    };

    //Setup navigation menu closed Aria
    var setupMenuClosedAriaAttributes = function() {
        $menuTriggers.attr('aria-expanded', false);
        $subMenu.attr('aria-hidden', true);
    };

    // Utility function to toggle menu classes
    var toggleMegaMenuClasses = function($this) {
        // Store all nav buttons not clicked on
        var $siblings = $this.parent().siblings().children('.is-parent-trigger');

        // Toggle class on clicked item and remove from any siblings
        $this.toggleClass( 'is-active' );
        $siblings.removeClass( 'is-active');
        setupMenuClosedAriaAttributes();

        // Toggle body class if a menu is open
        if( $this.parent().is('.is-active') ) {
            $body.addClass( 'mega-menu-active' );
            setupMenuOpenAriaAttributes($this);
        } else {
            $body.removeClass( 'mega-menu-active' );
        }

    };

    // Force close menu function
    var closeMenus = function(e) {
        $mainMenuItems.removeClass( 'is-active' );
        $body.removeClass( 'mega-menu-active' );
    };

    // Toggle menu depending on what is clicked on
    var toggleMegaMenu = function(e) {
        // Store clicked on item in variable
        var $this = $(e.currentTarget);

        // If html is clicked on and isn't menu button
        if ( $this.is( $( 'html' ) ) ) {
            if ( $body.hasClass( 'mega-menu-active' ) ) {
                closeMenus();
                setupMenuClosedAriaAttributes();
            }
            return;
        }

        // Run menu toggle if button is clicked on
        if ( $this.is( $menuTriggers ) ) {
            e.preventDefault();
            e.stopPropagation();

            toggleMegaMenuClasses($this);
        }
    };

    // Handle click events on menu
    var menuClicked = function () {
        $el
            .on('click', '.is-parent-trigger', function(e) {
                toggleMegaMenu(e);
            })
            .on('click', '.sub-menu', function(e){
                e.stopPropagation();
            });
    };

    // Handle click event on everywhere else if menu is open
    var htmlParentClicked = function () {
        $('html').on('click', function(e){
            toggleMegaMenu(e);
        });
    };

    // Close menu if open when shrinking viewport
    var checkForResize = debounce(function(e) {
        if (viewportW() <= desktopWidth) {
            closeMenus();
            setupMenuClosedAriaAttributes();
        }
    }, 500);

    // Close menu if Esc key is pushed
    var closeMenusOnEsc = function() {
        $body.on('keydown', function(e) {
            if (e.which === 27) {
                if ( $body.hasClass( 'mega-menu-active' ) ) {
                    $( '.is-parent-trigger.is-active' ).focus();
                    closeMenus();
                    setupMenuClosedAriaAttributes();
                }
            }
        });
    };

    // Run all events
    var bindEvents = function() {
        htmlParentClicked();
        menuClicked();
        closeMenusOnEsc();
        window.addEventListener("resize", checkForResize, false);
    };

    // Initializer function
    var init = function() {
        if (el) {
            bindEvents();
            setupMenuAriaAttributes();
            console.info('Initialized mega menu.');
        }
    };

    init();

})(jQuery, document, window);