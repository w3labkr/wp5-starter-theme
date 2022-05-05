<?php 
/**
 * Remove a widget from the dashboard screen
 *
 * @link https://codex.wordpress.org/Dashboard_Screen
 * @link https://codex.wordpress.org/Dashboard_Widgets_API
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_Dashboard {

    public $_opts;

    public function __construct( $opts=array() ){

        $this->_opts = $opts;

        // Remove dashboard widget
        add_action( 'wp_dashboard_setup', array( $this, 'views' ), 10, 1 );
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'dashboards' => array(
                'welcome_panel'             => 'wp_welcome_panel',  // wp_welcome_panel
                'dashboard_right_now'       => 'normal',  // Right Now
                'dashboard_recent_comments' => 'normal',  // Recent Comments
                'dashboard_incoming_links'  => 'normal',  // Incoming Links
                'dashboard_plugins'         => 'normal',  // Plugins
                'dashboard_quick_press'     => 'side',    // Quick Press
                'dashboard_recent_drafts'   => 'side',    // Recent Drafts
                'dashboard_primary'         => 'side',    // WordPress blog
                'dashboard_secondary'       => 'normal',  // Other WordPress News
                'dashboard_activity'        => 'normal',  // since 3.8
            ),
            'remove_widget' => array(
                'dashboard' => [], // (string|array) 'all' or ['widget','widget']
            ),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function views() {

        $opts = $this->options();

        $opt_dashboards = $opts['dashboards'];
        $opt_remove_dashboard_widget = $opts['remove_widget'];

        if ( !empty($opt_remove_dashboard_widget) ) {
            self::view_remove($opt_dashboards,$opt_remove_dashboard_widget);
        } 

    }

    public function view_remove($dashboards=array(),$posttypes=array()) {
        foreach ($posttypes as $posttype=>$widgets) {
            if ( $widgets == 'all' && !empty($widgets) ) {
                foreach($dashboards as $widget=>$context) {
                    if ( strpos($widget,'welcome_panel') !== false ){
                        remove_action( $widget, $context );
                    } else {
                        remove_meta_box( $widget, $posttype, $context );
                    }
                }
            } 
            else {
                foreach ($widgets as $widget) {
                    if ( array_key_exists($widget,$dashboards) ) {
                        $context = $dashboards[$widget];
                        if ( strpos($widget,'welcome_panel') !== false ){
                            remove_action( $widget, $context );
                        } else {
                            remove_meta_box( $widget, $posttype, $context );
                        }
                    }
                }
            }
        }
    }

}