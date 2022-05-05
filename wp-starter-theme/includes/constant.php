<?php
/**
 * WP Starter Theme's Definitions
 *
 * @link https://developer.wordpress.org/reference/functions/get_parent_theme_file_uri/
 * @link https://developer.wordpress.org/reference/functions/get_theme_file_path/
 */

// BUSINESS
define( 'BUSINESS_NAME', 'w3labkr' );
define( 'BUSINESS_ADDRESS', 'Avon NSW 2574, Australia' );
define( 'BUSINESS_TELEPHONE', '000-0000-0000' );

// COPYRIGHT
define( 'COPYRIGHT_YEAR', '' ); // Get dynamic copyright date if value is empty
define( 'COPYRIGHT_HOLDER', 'w3labkr' );
define( 'COPYRIGHT_URL', 'https://w3lab.kr' );
define( 'COPYRIGHT_LICENSE', 'GNU GENERAL PUBLIC LICENSE' );
define( 'COPYRIGHT_LICENSE_VERSION', 'Version 2' );
define( 'COPYRIGHT_GITHUB_URL', 'https://github.com/w3labkr/wp-starter-theme' );

// THEME
define( 'STARTER_PATH', get_theme_file_path() );
define( 'STARTER_URI', get_theme_file_uri() );
define( 'STARTER_ASSETS', STARTER_URI . '/assets' );
define( 'STARTER_CSS', STARTER_ASSETS . '/css' );
define( 'STARTER_FONT', STARTER_ASSETS . '/font' );
define( 'STARTER_IMG', STARTER_ASSETS . '/img' );
define( 'STARTER_JS', STARTER_ASSETS . '/js' );
define( 'STARTER_JSON', STARTER_ASSETS . '/json' );
define( 'STARTER_VENDOR', STARTER_ASSETS . '/vendor' );

// VENDOR
define( 'STARTER_JQUERY', STARTER_VENDOR . "/jquery/v3.3.1" );
define( 'STARTER_HTML5SHIV', STARTER_VENDOR . "/html5shiv/v3.7.3" );
define( 'STARTER_SELECTIVIZR', STARTER_VENDOR . "/selectivizr/v1.0.3b" );
define( 'STARTER_RESPOND', STARTER_VENDOR . "/respond/v1.4.2" );
define( 'STARTER_ANIME', STARTER_VENDOR . "/anime/v3.0.1" );
define( 'STARTER_SLICK', STARTER_VENDOR . "/slick/v1.9.0" );
define( 'STARTER_MASONRY', STARTER_VENDOR . "/masonry/v4.2.2" );
define( 'STARTER_IMAGESLOADED', STARTER_VENDOR . "/imagesloaded/v4.1.4" );
define( 'STARTER_NKDIALOG', STARTER_VENDOR . "/NkDialog/v1.1.0" );
