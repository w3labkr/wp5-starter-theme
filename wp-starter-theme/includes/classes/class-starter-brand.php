<?php 
/**
 * Displays a Site Brand
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Brand {

    /** 
     * Retrieve post title.
     * 
     * @link https://developer.wordpress.org/reference/functions/get_the_title/
     */
    public static function view_brand() {

        $html  = '';
        $html .= '<div id="page-brand" class="site-brand">';
            $html .= '<h1 class="site-title" itemprop="name">';
                $html .= '<a class="site-logo" href="'. get_bloginfo('url') .'">';
                    $html .= '<img src="'. self::get_custom_logo_url() .'" alt="'. self::get_custom_logo_alt() .'" />';
                $html .= '</a>';
            $html .= '</h1>';
        $html .= '</div>';

        echo $html;
    }

    /**
     * get attachment meta
     * 
     * @link https://wordpress.stackexchange.com/questions/193196/how-to-get-image-title-alt-attribute/193198
     */
    private static function get_attachment_meta( $attachment_id ) {
        $attachment = get_post( $attachment_id );
        return array(
            'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption'     => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href'        => get_permalink( $attachment->ID ),
            'src'         => $attachment->guid,
            'title'       => $attachment->post_title
        );
    }
    
    private static function remove_cdn_parameter ( $image_url ) {
        
        $http_host = str_replace( 
            array( '-', '_', '.' ), 
            array( '\-', '\_', '\.' ), 
            $_SERVER['HTTP_HOST'] 
        );
        
        // Remove parameter if using image cdn
        $reg_cdn = "/(?:^https?:\/\/)(.*\/)(?:". $http_host .")(.*)/";
        if ( preg_match( $reg_cdn, $image_url, $match_cdn ) ) {
            $image_url = str_replace( $match_cdn[1], '', $image_url );
            // Remove query string
            $reg_query = "/(\?.*)/";
            if ( preg_match( $reg_query, $image_url, $match_query ) ) {
                $image_url = str_replace( $match_query[1], '', $image_url );
            }
        }

        return $image_url;
    }

    /**
     * Return a custom logo default URL.
     */
    private static function get_default_logo() {
        return STARTER_IMG .'/logo.png';
    }

    /**
     * Return the post thumbnail URL.
     *
     * @link https://developer.wordpress.org/reference/functions/get_the_post_thumbnail_url/
     */
    private static function get_custom_logo_url() {
        
        $image_url = self::get_default_logo();

        if ( has_custom_logo() ) {
            $image_id = get_theme_mod( 'custom_logo' );
            $image_img = wp_get_attachment_image_src( $image_id , 'full' );
            $image_url = $image_img[0];
        } 

        // Remove parameter if using image cdn
        $image_url = self::remove_cdn_parameter($image_url);

        return $image_url;
    }

    private static function get_custom_logo_alt() {

        $title = wp_title($sep='&raquo;',$display=false,$seplocation='');
        $image_alt = $title;

        if ( has_custom_logo() ) {
            $image_id = get_theme_mod( 'custom_logo' );
            $image_meta = self::get_attachment_meta( $image_id );
            if ( !empty($image_meta['alt']) ) {
                $image_alt = $image_meta['alt'];
            } elseif( !empty($image_meta['caption']) ) {
                $image_alt = $image_meta['caption'];
            }
        }

        return $image_alt; 
    }

    private static function get_custom_logo_size() {

        $sizes = array(
            'width'  => '0',
            'height' => '0',
        );
        $image_url = self::get_custom_logo_url();
        $file = $_SERVER['DOCUMENT_ROOT'] . str_replace(get_bloginfo('url'),'',$image_url);

        if ( file_exists($file) ) {
            list($width,$height) = getimagesize($file);
            $sizes['width'] = $width;
            $sizes['height'] = $height;
        }

        return $sizes; 
    }

    private static function get_custom_logo_width() {
        return self::get_custom_logo_size()['width'];
    }

    private static function get_custom_logo_height() {
        return self::get_custom_logo_size()['height'];
    }

}