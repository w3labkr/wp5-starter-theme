<?php 
/**
 * Add Layout
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_Layout {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'container' => '',       // (string) '' or fluid
            'secondary' => array(
                'id' => 'sidebar-1', // (string) sidebar id
                'display' => true,   // (boolean)
                'column'  => 3,      // (int)
            ),
            'tertiary'  => array(
                'id' => 'sidebar-2', // (string) sidebar id
                'display' => true,   // (boolean)
                'column'  => 3,      // (int)
            ),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function get_container() {
        $opts = $this->options();
        $container = 'container';

        if ( empty($opts['container']) && self::is_sidebar('secondary') == false && self::is_sidebar('tertiary') == false ) {
            $container .= '-fluid';
        } elseif ( !empty($opts['container']) ) {
            $container .= '-' . $opts['container'];
        }
        return $container;
    }

    public function get_primary() {

        $opts = $this->options();

        $primary = 'content-area column-';
        $secondary = $opts['secondary'];
        $tertiary = $opts['tertiary'];

        if ( self::is_sidebar('secondary') && self::is_sidebar('tertiary') ) {
            $primary .= 12 - $secondary['column'] - $tertiary['column'];
        } elseif ( self::is_sidebar('secondary') ) {
            $primary .= 12 - $secondary['column'];
        } elseif ( self::is_sidebar('tertiary') ) {
            $primary .= 12 - $tertiary['column'];
        } else {
            $primary .= 12;
        }
        
        return $primary;
    }

    public function is_sidebar( $layout='' ) {
        $opts = $this->options();
        $sidebar = $opts[$layout];
        $is_active = false;
        
        if ( $sidebar['display'] && is_active_sidebar($sidebar['id']) ) {
            $is_active = true;
        } 

        return $is_active;
    }

    public function get_secondary() {
        if ( ! self::is_sidebar('secondary') ) {
            return;
        }
        $opts = $this->options();
        $secondary = $opts['secondary'];
        echo '<aside id="secondary" class="column-'. $secondary['column'] .' widget-area" itemscope itemtype="http://schema.org/WPSideBar">';
            echo '<h2 class="screen-reader-text">Secondary Content</h2>';
            dynamic_sidebar($secondary['id']);
        echo '</aside>';
    }

    public function get_tertiary() {
        if ( ! self::is_sidebar('tertiary') ) {
            return;
        }
        $opts = $this->options();
        $tertiary = $opts['tertiary'];
        echo '<aside id="tertiary" class="column-'. $tertiary['column'] .' widget-area" itemscope itemtype="http://schema.org/WPSideBar">';
            echo '<h2 class="screen-reader-text">Secondary Content</h2>';
            dynamic_sidebar($tertiary['id']);
        echo '</aside>';
    }

}