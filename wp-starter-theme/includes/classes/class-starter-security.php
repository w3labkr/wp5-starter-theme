<?php 
if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Security {

    public function __construct(){

        /**
         * Disable XML-RPC
         *
         * XML-RPC is a method that allows third party apps to communicate with your WordPress site remotely. 
         * This could cause security issues and can be exploited by hackers.
         *
         * @link https://codex.wordpress.org/XML-RPC_Extending
         * @link https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
         */
        add_filter( 'xmlrpc_enabled', '__return_false' );
        add_filter( 'pings_open', '__return_false', PHP_INT_MAX);

        // Disable X-Pingback header
        add_filter( 'wp_headers', array( $this, 'disable_x_pingback' ) );

        /**
         * Redirect to home if Using /?author=1 Query Parameter
         * 
         * @link https://www.wp-tweaks.com/hackers-can-find-your-wordpress-username/
         */
        add_action( 'template_redirect', array( $this, 'redirect_to_home' ) );

        /**
         * Diable REST Endpoint 
         * 
         * @link https://www.wp-tweaks.com/hackers-can-find-your-wordpress-username/
         */
        add_filter( 'rest_endpoints', array( $this, 'disable_rest_endpoints' ) );

        /**
         * Remove Unnecessary Tags From WordPress Header
         * 
         * WordPress auto generates a whole lot of unnecessary tags/elements 
         * that can not only slow down your website but also in some cases cause security issues.
         * 
         * @link https://orbitingweb.com/blog/remove-unnecessary-tags-wp-head/
         */
        /* Removes RSD, XMLRPC, WLW, WP Generator, ShortLink and Comment Feed links */
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'wp_shortlink_wp_head' );
        remove_action( 'wp_head', 'feed_links', 2 ) ; 
        remove_action( 'wp_head', 'feed_links_extra', 3 );

        /** 
         * Removes prev and next article links 
         *
         * These links are important for SEO. 
         * They are used to let search engines, like Google, know how paginated pages are connected. 
         * That means if you are not splitting your single blog post into multiple pages, 
         * you would only require these tags on pages like category archives. 
         * 
         * @link https://www.codetriple.com/remove-unnecessary-meta-tags-in-wordpress/
         */
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
        add_action( 'wp_head', array( $this, 'add_adjacent_posts_rel_link_wp_head' ) );

    }
    
    public function disable_x_pingback( $headers ) {
        unset( $headers['X-Pingback'] );
        return $headers;
    }

    public function redirect_to_home() {
        $is_author_set = get_query_var( 'author', '' );
        if ( $is_author_set != '' && !is_admin()) {
            wp_redirect( home_url(), 301 );
            exit;
        }
    }
    
    public function disable_rest_endpoints ( $endpoints ) {
        if ( isset( $endpoints['/wp/v2/users'] ) ) {
            unset( $endpoints['/wp/v2/users'] );
        }
        if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
            unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
        }
        return $endpoints;
    }

    public function add_adjacent_posts_rel_link_wp_head(){
        global $paged;
        if( is_archive() || is_category() || is_tag() || is_tax() ) {
            echo ( get_previous_posts_link() ) ? '<link rel="prev" href="' . get_pagenum_link( $paged - 1 ) . '" />' : '';
            echo ( get_next_posts_link() ) ? '<link rel="next" href="' . get_pagenum_link( $paged + 1 ) . '" />' : '';
        }
    }
    
}