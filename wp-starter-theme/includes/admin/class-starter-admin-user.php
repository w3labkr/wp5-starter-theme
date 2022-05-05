<?php 
/**
 * Add an Admin User in WordPress
 *
 * @link https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_User {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_action( 'init', array( $this, 'accounts' ) );
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'username' => 'Username',         // (string|array) '' or []
            'password' => 'Password',         // (string|array) '' or []
            'email'    => 'email@domain.com', // (string|array) '' or []
            'roles'    => 'administrator',    // (string|array) '' or [] - administrator, editor, author, contributor, subscriber
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function accounts(){
        $opts = $this->options();

        // add multi account
        if ( is_array($opts['username']) ) {
            foreach( $opts['username'] as $key=>$value ) {
                if ( !username_exists( $opts['username'][$key] )  && !email_exists( $opts['email'][$key] ) ) {
                    $user_id = wp_create_user( $opts['username'][$key], $opts['password'][$key], $opts['email'][$key] );
                    $user = new WP_User( $user_id );
                    $user->set_role( $opts['roles'][$key] );
                }                
            }
        }
        else {
            // add single account
            if ( !username_exists( $opts['username'] )  && !email_exists( $opts['email'] ) ) {
                $user_id = wp_create_user( $opts['username'], $opts['password'], $opts['email'] );
                $user = new WP_User( $user_id );
                $user->set_role( $opts['roles'] );
            }
        }
    }

}

// new Starter_Admin_User();