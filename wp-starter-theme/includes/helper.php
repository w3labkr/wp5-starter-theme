<?php 
if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

/**
 * Add last modified time as version to css and js
 */
if ( ! function_exists( 'starter_enqueue_style' ) ) {
    function starter_enqueue_style( $handle, $src='', $deps=array(), $version='', $media='all' ) {
        return Starter_Enqueue_Script::get_wp_enqueue_style( $handle, $src, $deps, $version, $media );
    }
}

if ( ! function_exists( 'starter_enqueue_script' ) ) {
    function starter_enqueue_script( $handle, $src='', $deps=array(), $version='', $in_footer=false ) {
        return Starter_Enqueue_Script::get_wp_enqueue_script( $handle, $src, $deps, $version, $in_footer );
    }
}


/**
 * Track post views
 */
if ( ! function_exists( 'starter_set_post_view' ) ) {
    function starter_set_post_view() {
        return Starter_Post_View::setter(); 
    }
}
if ( ! function_exists( 'starter_get_post_view' ) ) {
    function starter_get_post_view($post_id='') {
        return Starter_Post_View::getter($post_id); 
    }
}

if ( ! function_exists( 'starter_the_post_view' ) ) {
    function starter_the_post_view($post_id='') {
        echo starter_get_post_view($post_id); 
    }
}


/**
 * Get current post, page and taxonomy id
 */
if ( ! function_exists( 'starter_get_the_id' ) ) {
    function starter_get_the_id() {
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
}


/**
 * Get current post, page and taxonomy id
 */
if ( ! function_exists( 'starter_get_the_slug' ) ) {
    function starter_get_the_slug() {
        return str_replace( get_bloginfo('url'), '', get_permalink() );
    }
}


/**
 * Title Character Length
 * 
 * The curious case of a WordPress plugin, a rival site spammed with traffic, a war of words, and legal threats - The Register 
 * Headline string length must be within range [0, 110]
 *
 * @link https://search.google.com/structured-data
 * @link https://stackoverflow.com/questions/4617769/wordpress-titles-if-longer-than-50-characters-show-ellipsis
 */
if ( ! function_exists( 'starter_get_the_title' ) ) {
    function starter_get_the_title( $charlength=110, $post_id=null ){
        $title = get_the_title($post_id);
        if ( mb_strlen($title) > $charlength ) {
            $title  = mb_substr( $title, 0, $charlength );
            $title  = trim($title);
            $title .= '...';
        }
        return $title;
    }
}


/**
 * Retrieves the post excerpt.
 * By default the excerpt length is set to return 55 words.
 * 
 * @link https://codex.wordpress.org/Function_Reference/get_the_excerpt
 */
if ( ! function_exists( 'starter_get_the_excerpt' ) ) {
    function starter_get_the_excerpt( $charlength=55, $post=null ) {
        $excerpt = get_the_excerpt($post);
        $excerpt = strip_tags($excerpt);
        $charlength++;
        if ( mb_strlen($excerpt) > $charlength ) {
            $subex = mb_substr( $excerpt, 0, $charlength - 5 );
            $exwords = explode( ' ', $subex );
            $excute = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
            if ( $excute < 0 ) {
                $excerpt = mb_substr( $subex, 0, $excute );
            } else {
                $excerpt = $subex;
            }
            $excerpt .= '...';
        } 
        return $excerpt;
    }
}

if ( ! function_exists( 'starter_the_excerpt' ) ) {
    function starter_the_excerpt( $charlength=55, $post=null ) {
        echo starter_get_the_excerpt($charlength,$post);
    }
}

/**
 * Get size information for all currently-registered image sizes.
 */
if ( ! function_exists( 'starter_get_image_sizes' ) ) {
    function starter_get_image_sizes() {
        return Starter_Image::get_image_sizes();
    }
}

/**
 * Detect Active Plugin
 * 
 * @link https://stackoverflow.com/questions/38595044/wordpress-check-if-plugin-is-installed
 * @link https://stackoverflow.com/questions/41361510/is-there-any-way-to-get-yoast-title-inside-page-using-their-variable-i-e-ti
 */
if ( ! function_exists( 'starter_is_plugin_active' ) ) {
    function starter_is_plugin_active( $plugin ){
        $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
        foreach( $active_plugins as $active_plugin ){
            if( strpos( $active_plugin, $plugin ) !== false ){
                return true;
            }
        }
        return false;
    }
}

if ( ! function_exists( 'starter_is_active_sidebar' ) ) {
    function starter_is_active_sidebar( $id ){
        if ( ! is_active_sidebar( $id ) ) {
            return;
        }
        dynamic_sidebar( $id );   
    }
}


/**
 * Conditional tag search-no-results
 * 
 * @link https://wordpress.stackexchange.com/questions/172984/conditional-tag-search-no-results
 */
if ( ! function_exists( 'starter_is_search_has_results' ) ) {
    function starter_is_search_has_results() {
        if ( ! is_search() ) return;
        global $wp_query;
        return ( 0 !== $wp_query->found_posts ) ? true : false;
    }    
}


/**
 * Array Sort for php
 * 
 * @link http://php.net/manual/kr/function.sort.php
 */
if ( ! function_exists( 'starter_array_sort' ) ) {
    function starter_array_sort( $array, $field='', $order=SORT_ASC ) {
        
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $field) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
        
    }
}
