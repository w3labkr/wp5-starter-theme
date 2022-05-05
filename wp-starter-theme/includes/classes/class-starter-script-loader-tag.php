<?php 
/**
 * Filters the HTML script tag of an enqueued script.
 *
 * @link https://developer.wordpress.org/reference/hooks/script_loader_tag/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Script_Loader_Tag {

    public function __construct(){
        add_filter( 'script_loader_tag', array( $this, 'views' ), 10, 3 );
    }

    public function views( $tag, $handle, $src ) {

        if ( preg_match( "/(?:script-async)/", $handle ) ) {
            $tag = "<script src='". esc_url( $src ) ."' async defer></script>\n";
        }
        elseif( preg_match( "/(?:script-crossorigin)/", $handle ) ) {
            if ( preg_match( "/(.*)(?:\?ver\=)(.*)/", $src, $match ) ) {
                $tag = "<script src='". $match[1] ."' integrity='". $match[2] ."' crossorigin='anonymous'></script>\n";
            }            
        }

        return $tag;
    }

}