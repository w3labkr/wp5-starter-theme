<?php 
/**
 * Simple shortcode for displaying a menu 
 *
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
 * 
 * @uses [get_menu menu="Main Menu"]
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Shortcode_Menu {

    public function __construct(){
                
        // actions
        add_shortcode( 'get_menu', array( $this, 'menu_func' ) );

    }

    public function menu_func($args) {

        $menu = isset($atts['menu']) ? $atts['menu'] : '';
        
        ob_start();
        wp_nav_menu(array(
            'menu' => $menu
        ) );

        return ob_get_clean();
    }

}

new Starter_Shortcode_Menu();