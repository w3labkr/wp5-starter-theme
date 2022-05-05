<?php
/**
 * Remove RSS Feeds in WordPress
 *
 * @link https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Feed_Remove {

    public function __construct(){
        add_action('do_feed', 'disable_feed', 1);
        add_action('do_feed_rdf', 'disable_feed', 1);
        add_action('do_feed_rss', 'disable_feed', 1);
        add_action('do_feed_rss2', 'disable_feed', 1);
        add_action('do_feed_atom', 'disable_feed', 1);    
    }

    public function disable_feed() {
        wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
    }
 
}

// new Starter_Feed_Remove();