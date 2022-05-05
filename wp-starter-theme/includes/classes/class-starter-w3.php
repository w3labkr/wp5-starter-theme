<?php 
/**
 * Remove Type attribute script and style tags for wordpress
 * 
 * @link https://validator.w3.org/nu/
 * @link https://www.lee-harris.co.uk/blog/remove-type-attribute-script-tags-wordpress/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_W3 {

    public function __construct(){

        add_action( 'template_redirect', array( $this, 'validator' ), 10, 2 );

    }

    public function validator(){

        ob_start( function( $buffer ){

            $buffer = preg_replace( "/(?:( type\=('|\")text\/(javascript|css)('|\")))/", '', $buffer ); 
            
            // Also works with other attributes...
            // $buffer = str_replace( array( 'frameborder="0"', "frameborder='0'" ), '', $buffer );
            // $buffer = str_replace( array( 'scrolling="no"', "scrolling='no'" ), '', $buffer );
            
            return $buffer;
        });

    }


}

// new Starter_W3();