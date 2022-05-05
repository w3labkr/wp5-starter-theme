<?php 
if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

/**
 * Disable the emoji
 * 
 * @link https://firstsiteguide.com/remove-wordpress-emoji/
 * @link https://kinsta.com/knowledgebase/disable-emojis-wordpress/
 * @link https://www.codetriple.com/remove-unnecessary-meta-tags-in-wordpress/
 * @link https://stackoverflow.com/questions/47465235/wordpress-emoji-disable-code-not-working
 */
class Starter_Emoji {

    public function __construct(){
        add_action( 'init', array( $this, 'disable_emojis' ) );
        add_action( 'wp_loaded', array( $this, 'remove_unwanted_js' ) );
        add_filter( 'wp_resource_hints', array( $this, 'disable_emojis_remove_dns_prefetch' ), 10, 2 );
    }

    // Disable Emoji Mess
    public function disable_emojis() {
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_filter('comment_text_rss', 'wp_staticize_emoji'); 
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter( 'tiny_mce_plugins', array( 'Starter_Emoji', 'disable_emojis_tinymce' ) );
        add_filter( 'emoji_svg_url', '__return_false' );
    }

    /**
     * Filter function used to remove the tinymce emoji plugin.
     * 
     * @param array $plugins 
     * @return array Difference betwen the two arrays
     */
    public function disable_emojis_tinymce( $plugins ) {
        if ( is_array( $plugins ) ) {
            return array_diff( $plugins, array( 'wpemoji' ) );
        } else {
            return array();
        }
    }

    /**
     * Remove emoji CDN hostname from DNS prefetching hints.
     *
     * @param  array  $urls          URLs to print for resource hints.
     * @param  string $relation_type The relation type the URLs are printed for.
     * @return array                 Difference betwen the two arrays.
     */
    public function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {

        if ( 'dns-prefetch' === $relation_type ) {

            // Strip out any URLs referencing the WordPress.org emoji location.
            $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
            foreach ( $urls as $key => $url ) {
                if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
                    unset( $urls[ $key ] );
                }
            }
        }

        return $urls;
    }

    /**
     * 403 Forbidden Links on WordPress Multisite
     *
     * @link https://wordpress.stackexchange.com/questions/32000/odd-script-file-trying-to-be-loaded
     */
    public function remove_unwanted_js(){
        remove_action( 'wp_head', 'remote_login_js_loader' );
    }

} // class

// new Starter_Emoji_Remove();