<?php 
/**
 * Remove the WordPress Logo and others from the admin bar
 * 
 * @link https://codex.wordpress.org/Function_Reference/remove_node
 * @link https://digwp.com/2016/06/remove-toolbar-items/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_Bar_Menu {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        
        // The 999 priority parameter helps to ensure that our "removal" function runs after the plugin's "add-node" function.
        add_action( 'admin_bar_menu', array( $this, 'views' ), 9999 );
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'menu_ids' => array(
                "menu-toggle"      => true,  // (boolean) | level-1
                "top-secondary"    => true,  // (boolean) | level-1
                "wp-logo"          => false, // (boolean) | level-1
                "site-name"        => true,  // (boolean) | level-1
                "comments"         => false, // (boolean) | level-1
                "new-content"      => false, // (boolean) | level-1
                "view"             => false, // (boolean) | level-1
                "archive"          => false, // (boolean) | level-1
                "edit"             => false, // (boolean) | level-1
                "customize"        => false, // (boolean) | level-1
                "my-account"       => true,  // (boolean) | level-2 | top-secondary
                "search"           => false, // (boolean) | level-2 | top-secondary
                "notes"            => false, // (boolean) | level-2 | top-secondary
                "user-actions"     => true,  // (boolean) | level-3 | my-account
                "user-info"        => true,  // (boolean) | level-4 | user-actions
                "edit-profile"     => true,  // (boolean) | level-4 | user-actions
                "logout"           => true,  // (boolean) | level-4 | user-actions
                "about"            => true,  // (boolean) | level-2 | wp-logo
                "wp-logo-external" => true,  // (boolean) | level-2 | wp-logo
                "wporg"            => true,  // (boolean) | level-3 | wp-logo-external
                "documentation"    => true,  // (boolean) | level-3 | wp-logo-external
                "support-forums"   => true,  // (boolean) | level-3 | wp-logo-external
                "feedback"         => true,  // (boolean) | level-3 | wp-logo-external
                "new-post"         => true,  // (boolean) | level-2 | new-content
                "new-media"        => true,  // (boolean) | level-2 | new-content
                "new-page"         => true,  // (boolean) | level-2 | new-content
                "new-user"         => true,  // (boolean) | level-2 | new-content
                "view-site"        => true,  // (boolean) | level-2 | site-name
                "dashboard"        => true,  // (boolean) | level-2 | site-name
                "appearance"       => false, // (boolean) | level-2 | site-name
                "themes"           => true,  // (boolean) | level-3 | appearance
                "widgets"          => true,  // (boolean) | level-3 | appearance
                "menus"            => true,  // (boolean) | level-3 | appearance
            ),
            'remove_menu' => 'default',      // (string|array) 'all', default', 'plugin', array('node-id')
            'howdy' => 'howdy,',             // (string)
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function is_plugin_exist ( $key ) {
        $default = $this->options()['menu_ids'];
        return ( array_key_exists($key,$default) ) ? false : true;
    }

    public function views( $wp_admin_bar ) {
        
        $opts = $this->options();

        // Remove menu items
        if ( !empty($opts['remove_menu']) ) {
            $this->view_remove_menu ( $wp_admin_bar, $opts );
        }

        // Change Howdy to hi
        if ( !empty($opts['howdy']) ) {
            $this->view_howdy ( $wp_admin_bar, $opts['howdy'] );
        }

    }
    
    public function view_remove_menu ( $wp_admin_bar, $opts ) {
        
        $menu_ids = [];
        foreach ($opts['menu_ids'] as $key=>$value){
            if ( $value !== true ) {
                $menu_ids[] .= $key;
            }
        }
        
        // Remove the toolbar menu
        $nodes = $wp_admin_bar->get_nodes();
        foreach ( $nodes as $node ) {
            switch ($opts['remove_menu']) {
                case 'all':
                    if ( $this->is_plugin_exist($node->id) ) {
                        $wp_admin_bar->remove_node($node->id);
                    } else {
                        if ( in_array($node->id,$menu_ids) ) {
                            $wp_admin_bar->remove_node($node->id);
                        }
                    }
                    break;
                case 'default':
                    if ( !$this->is_plugin_exist($node->id) ) {
                        if ( in_array($node->id,$menu_ids) ) {
                            $wp_admin_bar->remove_node($node->id);
                        }
                    }
                    break;
                case 'plugin':
                    if ( $this->is_plugin_exist($node->id) ) {
                        $wp_admin_bar->remove_node($node->id);
                    }
                    break;
                default:
                    if ( is_array($opts['remove_menu']) && !empty($opts['remove_menu']) ) {
                        foreach ($opts['remove_menu'] as $id) {
                            $wp_admin_bar->remove_node($id);
                        }
                    }
                    break;
            }
        }
    }

    public function view_howdy ( $wp_admin_bar, $howdy ) {
        $my_account = $wp_admin_bar->get_node('my-account');
        $title = str_replace( 'Howdy,', $howdy, $my_account->title );
        $wp_admin_bar->add_node( array(
            'id' => 'my-account',
            'title' => $title,
        ) );
    }

}