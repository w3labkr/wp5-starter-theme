<?php


if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Third_Party_Jetpack {

    public function __construct(){

        /**
         * Removing All of Jetpack CSS
         *
         * @link https://css-tricks.com/snippets/wordpress/removing-jetpack-css/
         */
        add_filter('jetpack_sharing_counts', '__return_false', 99);
        add_filter('jetpack_implode_frontend_css', '__return_false', 99);
        
        /**
         * Remove each Jetpack CSS file, one at a time
         *
         * @link https://css-tricks.com/snippets/wordpress/removing-jetpack-css/
         */
        // add_action('wp_print_styles', array($this, 'remove_jetpack_implode_frontend_css'));

        /**
         * Please note that Email sharing is only available 
         * if you are using the Akismet spam-filtering plugin 
         *
         * @link https://jetpack.com/support/sharing/
         */
        add_filter('sharing_services_email', '__return_true');

        /**
         * How can I move where the sharing icons are displayed?
         *
         * @link https://jetpack.com/support/sharing/
         */        
        add_action('loop_start', array($this, 'view_remove_share'));

        /**
         * How can I hide the sharing buttons on mobile?
         *
         * @link https://jetpack.com/support/sharing/
         */
        add_action('wp_head', array($this, 'view_mobile_share'));


        /**
         * Disable jetpack error message
         * /wp-json/jetpack/v4/jitm?message_path=wp%3Aedit-post%3Aadmin_notices&query=paged%253D6&_wpnonce=97ab0770dc
         * 
         * @link https://wordpress.org/support/topic/mixed-content-problem-3/
         */
        // add_filter('jetpack_just_in_time_msgs', '__return_false', 99);
    }

    // remove each CSS file, one at a time
    public function remove_jetpack_implode_frontend_css() {
        wp_deregister_style('AtD_style');                    // After the Deadline
        wp_deregister_style('jetpack_likes');                // Likes
        wp_deregister_style('jetpack_related-posts');        // Related Posts
        wp_deregister_style('jetpack-carousel');             // Carousel
        wp_deregister_style('grunion.css');                  // Grunion contact form
        wp_deregister_style('the-neverending-homepage');     // Infinite Scroll
        wp_deregister_style('infinity-twentyten');           // Infinite Scroll - Twentyten Theme
        wp_deregister_style('infinity-twentyeleven');        // Infinite Scroll - Twentyeleven Theme
        wp_deregister_style('infinity-twentytwelve');        // Infinite Scroll - Twentytwelve Theme
        wp_deregister_style('noticons');                     // Notes
        wp_deregister_style('post-by-email');                // Post by Email
        wp_deregister_style('publicize');                    // Publicize
        wp_deregister_style('sharedaddy');                   // Sharedaddy
        wp_deregister_style('sharing');                      // Sharedaddy Sharing
        wp_deregister_style('stats_reports_css');            // Stats
        wp_deregister_style('jetpack-widgets');              // Widgets
        wp_deregister_style('jetpack-slideshow');            // Slideshows
        wp_deregister_style('presentations');                // Presentation shortcode
        wp_deregister_style('jetpack-subscriptions');        // Subscriptions
        wp_deregister_style('tiled-gallery');                // Tiled Galleries
        wp_deregister_style('widget-conditions');            // Widget Visibility
        wp_deregister_style('jetpack_display_posts_widget'); // Display Posts Widget
        wp_deregister_style('gravatar-profile-widget');      // Gravatar Widget
        wp_deregister_style('widget-grid-and-list');         // Top Posts widget
        wp_deregister_style('jetpack-widgets');              // Widgets
    }

    public function view_remove_share() {
        remove_filter('the_content', 'sharing_display', 19);
        remove_filter('the_excerpt', 'sharing_display', 19);
        if ( class_exists('Jetpack_Likes') ) {
            remove_filter('the_content', array(Jetpack_Likes::init(), 'post_likes'), 30, 1);
        }
    }

    // Check if we are on mobile
    public function view_is_mobile() {
     
        // Are Jetpack Mobile functions available?
        if ( !function_exists('jetpack_is_mobile') ) {
            return false;
        }
     
        // Is Mobile theme showing?
        if ( isset($_COOKIE['akm_mobile']) && $_COOKIE['akm_mobile'] == 'false') {
            return false;
        }
     
        return jetpack_is_mobile();
    }
     
    // Let's remove the sharing buttons when on mobile
    public function view_mobile_share() {
        // On mobile?
        if ( $this->view_is_mobile() ) {
            add_filter( 'sharing_show', '__return_false' );
        }
    }    

}
