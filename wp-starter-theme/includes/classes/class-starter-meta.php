<?php 
/**
 * Meta
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Meta {

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
    public static function add_adjacent_meta() {
        add_action( 'wp_head', 'Starter_Meta::add_adjacent_posts_rel_link_wp_head' );
    }

    public static function add_adjacent_posts_rel_link_wp_head() {
        global $paged;
        echo ( get_previous_posts_link() ) ? '<link rel="prev" href="' . get_pagenum_link( $paged - 1 ) . '" />' : '';
        echo ( get_next_posts_link() ) ? '<link rel="next" href="' . get_pagenum_link( $paged + 1 ) . '" />' : '';
    }
    
}