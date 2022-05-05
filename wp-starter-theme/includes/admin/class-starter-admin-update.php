<?php 
/**
 * Hide all WordPress update notifications in dashboard
 *
 * @link https://thomas.vanhoutte.be/miniblog/wordpress-hide-update/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_Update {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_filter( 'pre_site_transient_update_core', array($this,'view_update_core') );
        add_filter( 'pre_site_transient_update_plugins', array($this,'view_update_plugins') );
        add_filter( 'pre_site_transient_update_themes', array($this,'view_update_themes') );
    }

    public function options() {

        $options = $this->_opts;

        $defaults = array(
            'updates' => array(
                'update_core'    => true,
                'update_plugins' => true,
                'update_themes'  => true,
            ),
            'disable' => '',
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        $updates = $settings['updates'];
        $disable = $settings['disable'];

        if ( $disable == 'all' && !empty($disable) ) {
            foreach ($updates as $update=>$value) {
                $settings['updates'][$update] = false;
            }
        } 
        else {
            foreach($disable as $update) {
                if ( array_key_exists($update,$settings['updates']) ) {
                    $settings['updates'][$update] = false;
                }
            }
        }

        return $settings;

    }

    public function view_update_core () {
        $updates = $this->options()['updates'];
        if ( $updates['update_core'] !== false ) {
            return;
        }

        global $wp_version;
        return(object) array(
            'last_checked'=> time(),
            'version_checked'=> $wp_version,
            'updates' => array()
        );
    }

    public function view_update_plugins () {
        $updates = $this->options()['updates'];
        if ( $updates['update_plugins'] !== false ) {
            return;
        }

        global $wp_version;
        return(object) array(
            'last_checked'=> time(),
            'version_checked'=> $wp_version,
            'updates' => array()
        );
    }

    public function view_update_themes () {
        $updates = $this->options()['updates'];
        if ( $updates['update_themes'] !== false ) {
            return;
        }

        global $wp_version;
        return(object) array(
            'last_checked'=> time(),
            'version_checked'=> $wp_version,
            'updates' => array()
        );
    }

}