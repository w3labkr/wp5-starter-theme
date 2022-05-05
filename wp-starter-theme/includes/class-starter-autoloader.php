<?php 
/**
 * Registers a function to be autoloaded.
 * 
 * @link https://developer.wordpress.org/reference/functions/spl_autoload_register/
 * @link https://dsgnwrks.pro/how-to/using-class-autoloaders-in-wordpress/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Autoloader {

    public $_path = '';

    public function __construct(){

        if ( function_exists( '__autoload' ) ) {
            spl_autoload_register( '__autoload' );
        }

        spl_autoload_register( array( $this, 'autoload' ) );

        $this->_path = STARTER_PATH . '/includes';

    }

    public function is_class( $class, $prefix ) {
        if ( 0 === strpos( $class, $prefix ) ) {
            return true;
        }
        return false;
    }

    public function autoload( $class ){

        if ( strpos( $class, 'Starter_' ) !== 0 ) {
            return;
        }

        $name = str_replace( '_', '-', $class );
        $name = strtolower( $name ); 
        
        $file = '';
        $path = $this->_path;

        if ( $this->is_class( $class, 'Starter_Admin_' ) ) {
            $file = $path . "/admin/class-{$name}.php";            
        } 
        elseif ( $this->is_class( $class, 'Starter_Metabox_' ) ) {
            $file = $path . "/admin/metabox/class-{$name}.php";            
        } 
        elseif ( $this->is_class( $class, 'Starter_Shortcode_' ) ) {
            $file = $path . "/shortcode/class-{$name}.php";            
        } 
        elseif ( $this->is_class( $class, 'Starter_Third_Party_' ) ) {
            $file = $path . "/third-party/class-{$name}.php";            
        } 
        else {
            $file = $path . "/classes/class-{$name}.php";
        }

        // If a file is found
        if ( file_exists( $file ) ) {
            include ( $file );
        }

    }

}

new Starter_Autoloader();