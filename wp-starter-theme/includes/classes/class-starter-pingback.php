<?php 
/**
 * Disable Pingback
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Pingback {

    public function __construct(){

        /**
         * Disable Self Pingbacks
         * 
         * @link https://www.wpbeginner.com/wp-tutorials/how-disable-self-pingbacks-in-wordpress/
         */
        add_action( 'pre_ping', array( $this, 'disable_self_pingback' ) );
    }

    public function disable_self_pingback( &$links ) {
        foreach ( $links as $l => $link ) {
            if ( 0 === strpos( $link, get_option( 'home' ) ) )
                unset($links[$l]);
        }
    }

}

// new Starter_Ping();