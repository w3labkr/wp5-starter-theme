<?php 
/**
 * The hEntry schema 
 *
 * @link http://microformats.org/wiki/hentry
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Hero {

    public $_opts;

    public function __construct( $opts=array() ){

        $this->_opts = $opts;
        $this->views();

    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'slides' => [
                [ 'image'=>''. STARTER_IMG .'/hero.jpg' .'', 'caption'=>'<h3>Dillon Shook</h3><p>Photo by Rolands Varsbergs on Unsplash</p>' ],
            ],
            'background' => array(
                'color'      => '',
                'attachment' => 'fixed',
                'size'       => 'cover',
                'position'   => 'center',
                'repeat'     => 'no-repeat',
            ),
            'classes' => array(
                'header'      => 'hero-header screen-reader-text',
                'content'     => 'hero-content',
                'slider'      => 'slider',
                'initialize'  => 'slider-initialize',
                'slides'      => 'slides slider-slick',
                'slide'       => 'slide aligns',
                'slide-inner' => 'slide-inner align-middle',
            ),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function views() {
        $html  = '';
        $html .= $this->view_header();
        $html .= $this->view_content();
        echo $html;
    }

    public function view_header() {
        $opts = $this->options();

        $html  = '';
        $html .= '<header class="'. $opts['classes']['header'] .'">';
            $html .= '<div class="container">';
                $html .= '<h2 id="hero-title">Hero Content</h2>';
            $html .= '</div>';
        $html .= '</header>';
        return $html;
    }

    public function view_content() {
        $opts = $this->options();

        $html  = '';
        $html .= '<div class="'. $opts['classes']['content'] .'">';
            $html .= $this->view_slider();
        $html .= '</div>';
        return $html;
    }
    
    public function view_slider() {
        $opts = $this->options();

        $html  = '';
        $html .= '<div class="'. $opts['classes']['slider'] .'">';
            $html .= $this->view_initialize();
            $html .= $this->view_slides();
        $html .= '</div>';
        return $html;

    }

    public function view_initialize() {
        $opts = $this->options();

        $html  = '';
        $html .= '<div class="'. $opts['classes']['initialize'] .'">';
            $html .= $this->view_slide($opts['slides'][0]);
        $html .= '</div>';
        return $html;
    }

    public function view_slides() {
        $opts = $this->options();

        $html  = '';
        $html .= '<div class="'. $opts['classes']['slides'] .'">';
            foreach ($opts['slides'] as $slide) {
                $html .= $this->view_slide($slide);
            }
        $html .= '</div>';
        return $html;
    }

    public function view_slide($slide) {
        $opts = $this->options();
        $bg = $opts['background'];

        $css  = '';
        $css .= 'style="';
            $css .= (empty($slide['image']))? '' : 'background-image:url('. $slide['image'] .');';
            $css .= (empty($bg['color']))? '' : 'background-color:'. $bg['color'] .';';
            $css .= (empty($bg['attachment']))? '' : 'background-attachment:'. $bg['attachment'] .';';
            $css .= (empty($bg['size']))? '' : 'background-size:'. $bg['size'] .';';
            $css .= (empty($bg['position']))? '' : 'background-position:'. $bg['position'] .';';
            $css .= (empty($bg['repeat']))? '' : 'background-repeat:'. $bg['repeat'] .';';
        $css .= '"';

        $html .= '<div class="'. $opts['classes']['slide'] .'" '. $css .'>';
            $html .= '<div class="'. $opts['classes']['slide-inner'] .'">';
                $html .= '<div class="container">';
                    $html .= $slide['caption'];
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}