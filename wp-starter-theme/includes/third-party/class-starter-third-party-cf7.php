<?php
/**
 * Allow shortcodes in Contact Form 7
 *
 * @link http://tipstolearn.com/include-your-shortcodes-inside-contact-form-7-plugin/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Third_Party_Cf7 {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_filter( 'wpcf7_form_elements', array( $this, 'view_shortcode' ) );
 
        /**
         * Disable cf7
         * 
         * @link https://www.isitwp.com/deregister-contact-form-7-css-style-sheet/
         */
        // define( 'WPCF7_AUTOP', false ); // put in wp-config.php
        // add_filter( 'wpcf7_load_js', '__return_false' );
        // add_filter( 'wpcf7_load_css', '__return_false' );
        // add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
    }

    public function wps_deregister_styles() {
        wp_deregister_style( 'contact-form-7' );
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'shortcode' => true,
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function view_shortcode( $form ) {
        $ops = $this->options();
        $form = ( $ops['shortcode'] ) ? do_shortcode($form) : $form;
        return $form;
    }

}