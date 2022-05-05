<?php 
/**
 * Add last modified time as version to css and js
 *
 * @link https://wordpress.stackexchange.com/questions/269736/add-last-modified-time-as-version-to-css-and-js
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/reference/functions/get_theme_file_uri/
 * @link https://developer.wordpress.org/reference/functions/get_theme_file_path/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Enqueue_Script {

    public static function get_version( $src ){

        $path = str_replace( STARTER_URI, '', $src );
        $file = STARTER_PATH . $path;
        if ( file_exists( $file ) ) {
            $ver = date( 'Ymd', filemtime( $file ) );
        }

        return $ver;
    }

    public static function get_wp_enqueue_style( $handle, $src, $deps, $version, $media ) {

        // Remove request parameter
        if ( preg_match( "/(.*)(?:\?)(.*)/", $src, $match ) ) {
            $src = $match[1];
            $ver = $match[2];
        } 
        else {
            $ver = ( empty($version) ) ? self::get_version( $src ) : $version;
        }

        return wp_enqueue_style( $handle, $src, $deps, $ver, $media );
    }

    public static function get_wp_enqueue_script( $handle, $src, $deps, $version, $in_footer ) {

        // Remove request parameter
        if ( preg_match( "/(.*)(?:\?)(.*)/", $src, $match ) ) {
            $src = $match[1];
            $ver = $match[2];
        } 
        else {
            $ver = ( empty($version) ) ? self::get_version( $src ) : $version;
        }

        return wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
    }

}

/*
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
*/