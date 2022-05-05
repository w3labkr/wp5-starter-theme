<?php 
/**
 * Track post views
 * 
 * @link https://www.isitwp.com/post-views-without-plugin/
 * @link https://www.isitwp.com/track-post-views-without-a-plugin-using-post-meta/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Post_View {

    public function __construct(){
        
        // Remove issues with prefetching adding extra views
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 

    }

    public static function get_post_id() {
        $result = '';
        $object = get_queried_object();
        if ( is_singular() || is_single() || is_page() ) {
            $result = $object->ID;
        } 
        elseif ( is_tax() || is_category() ) {
            $result = $object->term_id;
        }
        return $result;
    }

    public static function setter() {

        if ( !is_singular() && !is_single() && !is_page() ) {
            return;
        } 

        $post_id = self::get_post_id();
        $count_key = 'starter_post_view';
        $count = get_post_meta($post_id, $count_key, true);
        
        if( $count == '' ){
            $count = 0;
            delete_post_meta($post_id, $count_key);
            add_post_meta($post_id, $count_key, 0);
        }
        else {
            $count++;
            update_post_meta($post_id, $count_key, $count);
        }

    }

    public static function getter($post_id){

        $post_id = empty($post_id) ? self::get_post_id() : $post_id;
        $count_key = 'starter_post_view';
        $count = get_post_meta($post_id, $count_key, true);
        
        if( $count == '' ){
            delete_post_meta($post_id, $count_key);
            add_post_meta($post_id, $count_key, 0);
            return 0;
        }

        return $count;
    }

}