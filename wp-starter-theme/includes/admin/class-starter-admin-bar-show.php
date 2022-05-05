<?php 
/**
 * Remove the WordPress Logo and others from the admin bar
 * 
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/show_admin_bar
 * @link https://codex.wordpress.org/Function_Reference/current_user_can
 * @link https://codex.wordpress.org/Roles_and_Capabilities
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_Bar_Show {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_filter( 'show_admin_bar' , array( $this, 'views' ) );
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'roles'  => array(               // (string|array) 'all'
                'administrator' => true,     // (boolean)
                'editor'        => true,     // (boolean)
                'author'        => true,     // (boolean)
                'contributor'   => true,     // (boolean)
                'subscriber'    => true,     // (boolean)
            ),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function views ( $content ) {

        $opts = $this->options();
        $user = wp_get_current_user();

        if ( $opts['roles'] == 'all' & !empty($opts['roles']) ) {
            $content = false;
        } else {
            // Fixed: Invalid argument supplied for foreach() if roles is 'all'
            $roles = $this->view_roles();
            foreach ( $roles as $role ) {
                if ( in_array( strtolower($role), (array) $user->roles ) ) {
                    $content = false;
                }
            }
        }

        return $content;
    }

    public function view_roles () {
        $opts = $this->options();
        $roles = [];
        foreach ($opts['roles'] as $role=>$value){
            if ( $value !== true ) {
                $roles[] .= $role;
            }
        }
        return $roles;
    }

}