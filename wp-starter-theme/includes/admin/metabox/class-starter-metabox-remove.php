<?php 
/**
 * Removes a meta box
 *
 * @link https://codex.wordpress.org/Function_Reference/remove_meta_box
 * @link https://developer.wordpress.org/reference/functions/remove_meta_box/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Metabox_Remove {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_action( 'admin_menu', array( $this, 'views' ) );
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'metaboxes' => array(
                'authordiv'           => [true,'normal'],   // (array) – Author metabox
                'categorydiv'         => [true,'side'],     // (array) – Categories metabox.
                'commentstatusdiv'    => [false,'normal'],  // (array) – Comments status metabox (discussion)
                'commentsdiv'         => [false,'normal'],  // (array) – Comments metabox
                'formatdiv'           => [true,'side'],     // (array) – Formats metabox
                'pageparentdiv'       => [true,'side'],     // (array) – Attributes metabox
                'postcustom'          => [true,'normal'],   // (array) – Custom fields metabox
                'postexcerpt'         => [true,'normal'],   // (array) – Excerpt metabox
                'postimagediv'        => [true,'side'],     // (array) – Featured image metabox
                'revisionsdiv'        => [true,'normal'],   // (array) – Revisions metabox
                'slugdiv'             => [false,'normal'],  // (array) – Slug metabox
                'submitdiv'           => [true,'side'],     // (array) – Date, status, and update/save metabox
                'tagsdiv-post_tag'    => [true,'side'],     // (array) – Tags metabox
                'trackbacksdiv'       => [false,'normal'],  // (array) – Trackbacks metabox
                'linktargetdiv'       => [false,'normal'],  // (array)
                'linkxfndiv'          => [false,'normal'],  // (array)
                'linkadvanceddiv'     => [false,'normal'],  // (array)
                'sqpt-meta-tags'      => [false,'normal'],  // (array)
                // 'tagsdiv-{$tax-name}' => [true,'side'],     // (array) - Custom taxonomies metabox
                // '{$tax-name}div'      => [true,'side'],     // (array) - Hierarchical custom taxonomies metabox
            ),
            'remove_meta_box' => array(
                'posttype' => array(
                    'all'  => [], // (string|array) 'all' or ['metabox','metabox']
                    'post' => [], // (string|array) 'all' or ['metabox','metabox']
                    'page' => [], // (string|array) 'all' or ['metabox','metabox']
                ),
                'template' => array(
                    // 'template-home.php' => array( 
                    //     'all'  => ['submitdiv'], 
                    // ),
                ),
            ),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function views() {

        $opts = $this->options();
        $remove_meta_box = $opts['remove_meta_box'];

        if ( !empty($remove_meta_box['posttype']) ) {
            $this->view_posttype();
        } 
        if ( !empty($remove_meta_box['template']) ) {
            $this->view_template();
        } 

    }

    public function view_posttype() {
        $opts = $this->options();
        $posttypes = $opts['remove_meta_box']['posttype'];
        $this->view_remove_loops($posttypes);
    }

    // Hide post type support if certain template is selected
    public function view_template() {

        if ( empty($this->view_path()) ) {
            return;
        }
        
        $opts = $this->options();
        $path = $this->view_path();
        $templates = $opts['remove_meta_box']['template'];
        
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

    public function view_remove_metaboxes() {
        $opts = $this->options();
        $metaboxes = [];
        foreach ($opts['metaboxes'] as $key=>$value){
            if ( $value[0] == false ) {
                $metaboxes[] .= $key;
            }
        }
        return $metaboxes;
    }

    public function view_remove_loops($posttypes) {
        
        $opts = $this->options();
        $posts = $this->view_posts();
        $metaboxes = $this->view_remove_metaboxes();

        foreach ($posttypes as $posttype=>$metabox_ids) {
            if ( $posttype == 'all' && $metabox_ids == 'all' ) {
                foreach ($posts as $post){
                    foreach ($metaboxes as $metabox) {
                        $context = $opts['metaboxes'][$metabox][1];
                        remove_meta_box($metabox,$post,$context);
                    }
                }
            } 
            elseif ( $posttype == 'all' && is_array($metabox_ids) ) {
                foreach ($posts as $post){
                    foreach ($metabox_ids as $metabox_id) {
                        $context = $opts['metaboxes'][$metabox_id][1];
                        remove_meta_box($metabox_id,$post,$context);
                    }
                }
            }
            elseif ( $posttype !== 'all' && $metabox_ids == 'all' ) {
                foreach ($metaboxes as $metabox) {
                    $context = $opts['metaboxes'][$metabox][1];
                    remove_meta_box($metabox,$posttype,$context);
                }
            }
            else {
                foreach ($metabox_ids as $metabox_id) {
                    $context = $opts['metaboxes'][$metabox_id][1];
                    remove_meta_box($metabox_id,$posttype,$context);
                }
            }
        }
    }

}