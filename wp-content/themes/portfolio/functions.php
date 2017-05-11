<?php

define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_IMAGES', THEME_URI . '/assets/images/' );
define( 'THEME_CSS', THEME_URI . '/assets/css/' );
define( 'THEME_JS', THEME_URI . '/assets/js/dist/' );
define( 'THEME_JS_VENDOR', THEME_URI . '/assets/js/vendor/' );

require_once( 'functions/cleanup.php' );
require_once( 'functions/enqueue.php' );
require_once( 'functions/theme-support.php' );
require_once( 'functions/nav.php' );
require_once( 'functions/post.php' );
require_once( 'functions/register.php' );
require_once( 'functions/media.php' );
require_once( 'functions/gallery.php' );
require_once( 'functions/font.php' );
require_once( 'functions/branding.php' );
require_once( 'functions/forms.php' );
require_once( 'functions/post-types.php' );
require_once( 'functions/social.php' );
require_once( 'functions/custom.php' );
