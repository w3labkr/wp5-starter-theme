<?php 
/**
 * The hEntry schema 
 *
 * @link http://microformats.org/wiki/hentry
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Preload_Image {

    public $_opts;

    public function __construct( $opts=array() ){

        $this->_opts = $opts;
        
        add_action( 'wp_head', array( $this, 'views' ) );

    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'slides' => [
                [ 'image'=> STARTER_IMG .'/hero.jpg' ],
            ],
            'images' => [], // ['abc.jpg, def.png']
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    /**
     * Preloading images using CSS only
     * 
     * @link https://stackoverflow.com/questions/1373142/preloading-css-images
     */
    public function views() {
        $opts = $this->options();
        
        $html  = '';
        $html .= '<style>';
        $html .= 'body:after {';
            $html .= 'position: absolute; width:0; height:0; overflow:hidden; z-index:-1;';
            $html .= 'content:';
                foreach ( $opts['slides'] as $slide ) {
                    $html .= ' url('. $slide['image'] .')';
                }
                foreach ( $opts['images'] as $image ) {
                    $html .= ' url('. $image .')';
                }
            $html .= ';';
        $html .= '}';
        $html .= '</style>';

        echo $html;
    }

}