;( function( $ ) {

    'use strict';

    var popup = function(opts) {

        var options = $.extend( {
            event : null,
            url   : '',
            center: true,
            name  : '_blank',
            specs : {
                menubar   : 0,
                scrollbars: 0,
                status    : 1,
                titlebar  : 1,
                toolbar   : 0,
                top       : 100,
                left      : 100,
                width     : 500,
                height    : 300
            }
        }, opts );

        if( options.event ) {
            options.event.preventDefault();

            if( ! options.url.length ) {
                options.url = options.event.target.href;
            }
        }

        if( options.url.length ) {

            if( options.center ) {
                options.specs.top = ( screen.height / 2 ) - ( options.specs.height / 2 );
                options.specs.left = ( screen.width / 2 ) - ( options.specs.width / 2 );
                console.log(options.specs.width / 2);
            }

            var specs = [];

            $.each( options.specs, function( key, val ) {
                var spec = `${key}=${val}`;
                specs.push( spec );
            });

            window.open( options.url, options.name, specs.join() );
        }

    };

    var el = document.getElementsByClassName( 'share-popup' ),
        $el;

    var launchSocialPopup = function(e) {

        popup( {
            event: e,
            specs: {
                width : parseInt( $( e.currentTarget ).attr( 'data-width' ) ),
                height: parseInt( $( e.currentTarget ).attr( 'data-height' ) )
            }
        } );

    };

    var bindEvents = function() {

        $el.on( 'click', function(e) {
            launchSocialPopup(e);
        });

    };

    var init = function() {

        if (el.length) {
            $el = $(el);
            bindEvents();
            console.info( 'Initialized social popups.' );
        }

    };

    init();


} )( jQuery );