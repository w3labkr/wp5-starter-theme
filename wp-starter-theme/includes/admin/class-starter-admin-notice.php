<?php 
/**
 * Disable Admin Notices WordPress
 *
 * @link https://pluginsreviews.com/disable-admin-notices-wordpress/
 * @link https://www.role-editor.com/remove-admin-notices/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_Notice {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_filter( 'ure_role_additional_options', array($this,'ure_add_block_admin_notices_option'), 10, 1 );
        add_action( 'admin_print_scripts', array($this,'views'), 10, 1 );
    }

    public function options() {

        $options = $this->_opts;

        $defaults = array(
            'notices' => array(
                'user_admin_notices' => true,
                'admin_notices'      => true,
                'all_admin_notices'  => true,
            ),
            'disable' => [],
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        $notices = $settings['notices'];
        $disable = $settings['disable'];

        if ( $disable == 'all' && !empty($disable) ) {
            foreach ($notices as $notice=>$value) {
                $settings['notices'][$notice] = false;
            }
        } 
        else {
            foreach($disable as $notice) {
                if ( array_key_exists($notice,$settings['notices']) ) {
                    $settings['notices'][$notice] = false;
                } 
            }
        }

        return $settings;
    }
    
    public function ure_add_block_admin_notices_option($items) {
        $notices = $this->options()['notices'];
        if ( $notices['admin_notices'] == false || $notices['all_admin_notices'] == false ) {
            $item = URE_Role_Additional_Options::create_item('block_admin_notices', esc_html__('Block admin notices', 'user-role-editor'), 'admin_init', 'ure_block_admin_notices');
            $items[$item->id] = $item;
            print_r($items);
        }
        return $items;
    }

    public function views() {
        global $wp_filter;

        $notices = $this->options()['notices'];

        // user admin
        if ( is_user_admin() ) {
            switch ($notices['user_admin_notices']) {
                case false:
                    if ( isset($wp_filter['user_admin_notices']) ) {
                        unset($wp_filter['user_admin_notices']);
                    }
                    break;
            }
        } 
        elseif ( isset($wp_filter['admin_notices']) ) {
            switch ($notices['admin_notices']) {
                case false:
                    unset($wp_filter['admin_notices']);
                    break;
            }            
        }

        // all admin
        switch ($notices['all_admin_notices']) {
            case false:
                if ( isset($wp_filter['all_admin_notices']) ) {
                    unset($wp_filter['all_admin_notices']);
                }
                break;
        }            

    }

}