<?php 
if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

/**
 * Wordpress Remove Comments
 * 
 * @link https://gist.github.com/mattclements/eab5ef656b2f946c4bfb
 * @uses DB: TRUNCATE wp_commentmeta; TRUNCATE wp_comments;
 */
class Starter_Comments_Remove {

    public function __construct(){
        add_action( 'admin_init', array( $this, 'post_types_support' ) );
        add_filter( 'comments_open', array( $this, 'status' ), 20, 2 );
        add_filter( 'pings_open', array( $this, 'status' ), 20, 2 );
        add_filter( 'comments_array', array( $this, 'hide_existing' ), 10, 2 );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array( $this, 'admin_menu_redirect' ) );
        add_action( 'admin_init', array( $this, 'dashboard' ) );
        add_action( 'init', array( $this, 'admin_bar' ) );
        add_action( 'widgets_init', array( $this, 'recent_comments' ) );
    }

    // Disable support for comments and trackbacks in post types
    public function post_types_support() {
        $post_types = get_post_types();
        foreach ($post_types as $post_type) {
            if(post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }

    // Close comments on the front-end
    public function status() {
        return false;
    }

    // Hide existing comments
    public function hide_existing($comments) {
        $comments = array();
        return $comments;
    }

    // Remove comments page in menu
    public function admin_menu() {
        remove_menu_page('edit-comments.php');
    }

    // Redirect any user trying to access comments page
    public function admin_menu_redirect() {
        global $pagenow;
        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url()); exit;
        }
    }

    // Remove comments metabox from dashboard
    public function dashboard() {
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    }

    // Remove comments links from admin bar
    public function admin_bar() {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    }

    // https://www.isitwp.com/remove-recent-comments-wp_head-css/
    public function recent_comments() {
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }

} // class

// new Starter_Comments_Remove();