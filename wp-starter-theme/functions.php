<?php
/**
 * WP Starter Theme's functions
 */

require_once( __DIR__ .'/includes/class-starter.php');


/**
 * Sets up theme defaults and registers support for various WordPress features.
 * 
 * @link https://developer.wordpress.org/reference/hooks/after_setup_theme/
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
 */
if ( !function_exists('starter_theme_setup') ):
    function starter_theme_setup() {

        // Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
        // add_theme_support('post-formats', array('aside', 'gallery' ));

        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'menu-1' => __('Primary', 'starter-text-domain'),
            )
       );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));

    }
endif;
add_action('after_setup_theme', 'starter_theme_setup');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function starter_theme_widgets_init() {

    register_sidebar( array(
        'name'          => __('Primary Sidebar', 'starter-text-domain'),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
 
    register_sidebar( array(
        'name'          => __('Secondary Sidebar', 'starter-text-domain'),
        'id'            => 'sidebar-2',
        'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li></ul>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __('Footer Widget 1', 'starter-text-domain'),
        'id'            => 'footer-widget-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
 
    register_sidebar( array(
        'name'          => __('Footer Widget 2', 'starter-text-domain'),
        'id'            => 'footer-widget-2',
        'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li></ul>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __('Footer Widget 3', 'starter-text-domain'),
        'id'            => 'footer-widget-3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
 
    register_sidebar( array(
        'name'          => __('Footer Widget 4', 'starter-text-domain'),
        'id'            => 'footer-widget-4',
        'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li></ul>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

}
add_action('widgets_init', 'starter_theme_widgets_init');


/**
 * Enqueue scripts
 *
 * @param string $handle Script name
 * @param string $src Script url
 * @param array $deps (optional) Array of script names on which this script depends
 * @param string|bool $ver (optional) Script version (used for cache busting), set to null to disable
 * @param bool $in_footer (optional) Whether to enqueue the script before </head> or before </body>
 */
function starter_theme_scripts() {

    // STYLESHEET
    starter_enqueue_style('grid-system-style', STARTER_CSS .'/grid-system.min.css', array(), '');
    starter_enqueue_style('grid-component-style', STARTER_CSS .'/grid-component.css', array(), '');
    starter_enqueue_style('grid-typography-style', STARTER_CSS .'/grid-typography.css', array(), '');
    starter_enqueue_style('starter-slick-style', STARTER_SLICK .'/slick.css', array(), '');
    starter_enqueue_style('starter-nkdialog-style', STARTER_NKDIALOG .'/NkDialog.min.css', array(), '');
    starter_enqueue_style('starter-main-style', STARTER_CSS .'/main.css', array(), '');
    starter_enqueue_style('starter-responsive-style', STARTER_CSS .'/responsive.css', array(), '');
    
    // CDN
    // starter_enqueue_script('*-script-async', 'SRC', array(), '', true);
    // starter_enqueue_script('*-script-crossorigin', 'SRC', array(), 'INTEGRITY', true);

    // JAVSSCRIPT
    wp_deregister_script('jquery');
    starter_enqueue_script('jQuery', STARTER_JQUERY .'/jquery.min.js', false, '', true);  
    starter_enqueue_script('jQuery-migrate', STARTER_JQUERY .'/jquery-migrate.min.js', array(), '', true);  
    starter_enqueue_script('starter-anime-script', STARTER_ANIME .'/anime.min.js', array(), '', true);
    starter_enqueue_script('starter-imagesloaded-script', STARTER_IMAGESLOADED .'/imagesloaded.pkgd.min.js', array(), '', true);
    starter_enqueue_script('starter-masonry-script', STARTER_MASONRY .'/masonry.pkgd.min.js', array(), '', true);
    starter_enqueue_script('starter-slick-script', STARTER_SLICK .'/slick.min.js', array(), '', true);
    starter_enqueue_script('starter-nkdialog-script', STARTER_NKDIALOG .'/NkDialog.min.js', array(), '', true);
    starter_enqueue_script('starter-geography-script', STARTER_JS .'/jquery-geography-google.min.js', array(), '', true);
    starter_enqueue_script('starter-scrolling-script', STARTER_JS .'/jquery-scrolling.min.js', array(), '', true);
    starter_enqueue_script('starter-helper-script', STARTER_JS .'/helper.js', array(), '', true);
    starter_enqueue_script('starter-main-script', STARTER_JS .'/main.js', array(), '', true);

    // POLYFILL
    starter_enqueue_script('starter-html5shiv-script', STARTER_HTML5SHIV .'/html5shiv.min.js', array(), '', false);
    wp_script_add_data('starter-html5shiv-script', 'conditional', 'lt ie 9');
    starter_enqueue_script('starter-respond-script', STARTER_RESPOND .'/respond.min.js', array(), '', false);
    wp_script_add_data('starter-respond-script', 'conditional', 'lt ie 9');
    starter_enqueue_script('starter-selectivizr-script', STARTER_SELECTIVIZR .'/selectivizr.js', array(), '', false);
    wp_script_add_data('starter-selectivizr-script', 'conditional', 'lt ie 9');

}
add_action('wp_enqueue_scripts', 'starter_theme_scripts');
