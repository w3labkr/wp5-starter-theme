<?php 
/**
 * Add and remove support for a feature from a post type
 * 
 * @link https://codex.wordpress.org/Function_Reference/post_type_supports
 * @link https://codex.wordpress.org/Function_Reference/remove_post_type_support
 * @link https://codex.wordpress.org/Function_Reference/add_post_type_support
 * @link https://developer.wordpress.org/reference/functions/remove_post_type_support/
 * @link https://developer.wordpress.org/reference/functions/add_post_type_support/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Admin_Posttype_Support {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_action( 'admin_menu', array( $this, 'views' ) );
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'supports' => array(
                'title'           => true,  // (boolean)
                'editor'          => true,  // (boolean) content
                'author'          => true,  // (boolean)
                'thumbnail'       => true,  // (boolean) featured image - current theme must also support Post Thumbnails
                'excerpt'         => true,  // (boolean)
                'trackbacks'      => false, // (boolean)
                'custom-fields'   => true,  // (boolean)
                'comments'        => false, // (boolean) also will see comment count balloon on edit screen
                'revisions'       => true,  // (boolean) will store revisions
                'page-attributes' => true,  // (boolean) template and menu order - hierarchical must be true
                'post-formats'    => true,  // (boolean) removes post formats, see Post Formats
            ),
            'remove_post_type_support' => array(
                'posttype' => array(
                    'all'  => [], // (string|array) 'all', or ['feature','feature']
                    'post' => [],    // (string|array) 'all', or ['feature','feature']
                    'page' => [],    // (string|array) 'all', or ['feature','feature']
                ),
                'template' => array(),
                'priority' => 0,               // (int)
            ),
            'add_post_type_support' => array(
                'posttype' => array(
                    'all'  => [],              // (string|array) 'all' or ['feature','feature']
                    'page' => ['excerpt'],     // (string|array) 'all' or ['feature','feature']
                ),
                'template' => array(),
                'priority' => 1,               // (int)
            ),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function views() {

        $opts = $this->options();

        $add_posttype = $opts['add_post_type_support']['posttype'];
        $add_template = $opts['add_post_type_support']['template'];
        $add_priority = $opts['add_post_type_support']['priority'];

        $remove_posttype = $opts['remove_post_type_support']['posttype'];
        $remove_template = $opts['remove_post_type_support']['template'];
        $remove_priority = $opts['remove_post_type_support']['priority'];

        if ( $remove_priority <= $add_priority ) {
            if ( !empty($remove_posttype) ) { $this->view_remove_posttype(); } 
            if ( !empty($add_posttype)    ) { $this->view_add_posttype();    } 
            if ( !empty($remove_template) ) { $this->view_remove_template(); } 
            if ( !empty($add_template)    ) { $this->view_add_template();    } 
        }
        else {
            if ( !empty($add_posttype)    ) { $this->view_add_posttype();    } 
            if ( !empty($remove_posttype) ) { $this->view_remove_posttype(); } 
            if ( !empty($add_template)    ) { $this->view_add_template();    } 
            if ( !empty($remove_template) ) { $this->view_remove_template(); } 
        }
    }

    public function view_add_posttype() {
        $opts = $this->options();
        $opts_add = $opts['add_post_type_support'];
        $posttypes = $opts_add['posttype'];
        $this->view_add_loops($posttypes);
    }

    public function view_remove_posttype() {
        $opts = $this->options();
        $opts_remove = $opts['remove_post_type_support'];
        $posttypes = $opts_remove['posttype'];
        $this->view_remove_loops($posttypes);
    }

    public function view_add_template() {

        if ( empty($this->view_path()) ) {
            return;
        }

        $opts = $this->options();
        $opts_add = $opts['add_post_type_support'];
        $path = $this->view_path();
        $templates = $opts_add['template'];

        foreach ($templates as $file=>$posttypes) {
            if( strpos($path,$file) ) {
                $this->view_add_loops($posttypes);
            }
        }
    }

    public function view_remove_template() {

        if ( empty($this->view_path()) ) {
            return;
        }

        $opts = $this->options();
        $opts_remove = $opts['remove_post_type_support'];
        $path = $this->view_path();
        $templates = $opts_remove['template'];

        foreach ($templates as $file=>$posttypes) {
            if( strpos($path,$file) !== false ) {
                $this->view_remove_loops($posttypes);
            }
        }
    }

    public function view_path() {

        $post_id = '';

        // Get the post ID on edit post with filter_input super global inspection.
        $current_post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
        // Get the post ID on update post with filter_input super global inspection.
        $update_post_id = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT );
     
        // Check to see if the post ID is set, else return.
        if ( isset($current_post_id) ) {
           $post_id = absint( $current_post_id );
        } 
        elseif ( isset($update_post_id) ) {
           $post_id = absint( $update_post_id );
        } 

        // Get the template of the current post.
        $path = get_post_meta( $post_id, '_wp_page_template', true );

        return $path;
        
    }

    public function view_posts() {
        return get_post_types(array('public'=>true));
    }

    public function view_add_supports() {
        $opts = $this->options();
        $supports = [];
        foreach ($opts['supports'] as $key=>$value){
            if ( $value !== false ) {
                $supports[] .= $key;
            }
        }
        return $supports;
    }

    public function view_add_loops($posttypes) {
        
        $opts = $this->options();
        $posts = $this->view_posts();
        $supports = $this->view_add_supports();

        foreach ($posttypes as $posttype=>$features) {
            if ( $posttype == 'all' && $features == 'all' ) {
                foreach ($posts as $post){
                    foreach ($supports as $support) {
                        add_post_type_support($post,$support);
                    }
                }
            }
            elseif ( $posttype == 'all' && is_array($features) ) {
                foreach ($posts as $post){
                    foreach ($features as $feature) {
                        add_post_type_support($post,$feature);
                    }
                }
            }
            elseif ( $posttype !== 'all' && $features == 'all' ) {
                foreach ($supports as $support) {
                    add_post_type_support($posttype,$support);
                }
            }
            else {
                foreach ($features as $feature) {
                    add_post_type_support($posttype,$feature);
                }
            }
        }
    }

    public function view_remove_supports() {
        $opts = $this->options();
        $supports = [];
        foreach ($opts['supports'] as $key=>$value){
            if ( $value !== true ) {
                $supports[] .= $key;
            }
        }
        return $supports;
    }

    public function view_remove_loops($posttypes) {
        
        $opts = $this->options();
        $posts = $this->view_posts();
        $supports = $this->view_remove_supports();

        foreach ($posttypes as $posttype=>$features) {
            if ( $posttype == 'all' && $features == 'all' ) {
                foreach ($posts as $post){
                    foreach ($supports as $support) {
                        remove_post_type_support($post,$support);
                    }
                }
            }
            elseif ( $posttype == 'all' && is_array($features) ) {
                foreach ($posts as $post){
                    foreach ($features as $feature) {
                        remove_post_type_support($post,$feature);
                    }
                }
            }
            elseif ( $posttype !== 'all' && $features == 'all' ) {
                foreach ($supports as $support) {
                    remove_post_type_support($posttype,$support);
                }
            }
            else {
                foreach ($features as $feature) {
                    remove_post_type_support($posttype,$feature);
                }
            }
        }
    }

}