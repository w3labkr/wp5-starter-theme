<?php 
/**
 * The hEntry schema 
 *
 * @link http://microformats.org/wiki/hentry
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Hentry {

    /** 
     * Retrieve post title.
     * 
     * @link https://developer.wordpress.org/reference/functions/get_the_title/
     */
    public static function view_title( $post=null, $tag='h2', $class='', $gradient=true, $screen=true ) {

        $classes = self::get_class( 'entry-title', $screen, $class );

        $html  = '';
        $html .= '<'. $tag .' class="'. $classes .'" itemprop="headline">';
            $html .= get_the_title($post);
            // $html .= ( $gradient == true ) ? starter_get_gradient_text( $id=get_the_ID(), $text=get_the_title($post) ) : get_the_title($post);
        $html .= '</'. $tag .'>';

        return $html;
    }

    /** 
     * Return the post thumbnail URL.
     * 
     * @link https://developer.wordpress.org/reference/functions/get_the_post_thumbnail_url/
     */
    public static function view_thumbnail( $post=null, $screen=true, $class='' ) {

        $classes = self::get_class( 'entry-thumbnail', $screen, $class );

        $html  = '';
        $html .= '<div class="'. $classes .'" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
            $html .= '<img src="'. self::get_post_thumbnail_url($post) .'" alt="'. self::get_post_thumbnail_alt($post) .'"/>';
            $html .= '<meta itemprop="url" content="'. self::get_post_thumbnail_url($post) .'">';
            $html .= '<meta itemprop="width" content="'. self::get_post_thumbnail_width($post) .'">';
            $html .= '<meta itemprop="height" content="'. self::get_post_thumbnail_height($post) .'">';
        $html .= '</div>';

        return $html;
    }

    public static function view_meta( $post=null, $d='', $screen=false, $class='' ) {

        $classes = self::get_class( 'entry-meta', $screen, $class );

        $html  = '';
        $html .= '<div class="'. $classes .'">';
            $html .= self::view_author();
            $html .= self::view_published($post,$d);
            $html .= self::view_updated($post,$d);
            $html .= self::view_publisher();
            $html .= self::view_main_entity_of_page($post);
        $html .= '</div>';

        return $html;
    }

    /** 
     * Retrieve the author of the current post.
     * 
     * @link https://developer.wordpress.org/reference/functions/get_the_author/
     */
    public static function view_author( $screen=true, $class='' ) {

        $classes = self::get_class( 'entry-author', $screen, $class );

        $html  = '';
        $html .= '<span class="'. $classes .'">';
            $html .= 'Published by ';
            $html .= '<span class="author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person">';
                $html .= '<span class="fn" itemprop="name">'. get_the_author() .'</span>';
            $html .= '</span>';
        $html .= '</span>';

        return $html;
    }

    /** 
     * Retrieve the date on which the post was written. 
     * 
     * @link https://developer.wordpress.org/reference/functions/get_the_date/
     */
    public static function view_published( $post=null, $d='', $screen=true, $class='' ) {

        $classes = self::get_class( 'entry-published', $screen, $class );

        $html  = '';
        $html .= '<span class="'. $classes .'">';
            $html .= ' on ';
            $html .= '<time class="published" datetime="'. get_the_date(DATE_W3C) .'" itemprop="datePublished" content="'. get_the_date(DATE_W3C) .'">';
                $html .= get_the_date($d,$post);
            $html .= '</time>';
        $html .= '</span>';

        return $html;
    }

    /** 
     * Retrieve the date on which the post was last modified.
     * 
     * @link https://developer.wordpress.org/reference/functions/get_the_date/
     */
    public static function view_updated( $post=null, $d='', $screen=false, $class='' ) {

        $classes = self::get_class( 'entry-updated', $screen, $class );

        $html  = '';
        $html .= '<span class="'. $classes .'">';
            $html .= ' on ';
            $html .= '<time class="updated" datetime="'. get_the_modified_date(DATE_W3C) .'" itemprop="dateModified" content="'. get_the_modified_date(DATE_W3C) .'">';
                $html .= get_the_modified_date($d,$post);
            $html .= '</time>';
        $html .= '</span>';

        return $html;
    }

    /** 
     * Retrieves the full permalink for the current post or post ID.
     * 
     * @link https://developer.wordpress.org/reference/functions/get_permalink/
     */
    public static function view_permalink( $post=null, $screen=true, $class='' ) {

        $classes = self::get_class( 'entry-permalink', $screen, $class );

        $html  = '';
        $html .= '<a class="'. $classes .'" href="'. get_permalink($post) .'" rel="bookmark" itemprop="url">';
            $html .= '&mdash; Readmore';
        $html .= '</a>';

        return $html;
    }

    public static function view_main_entity_of_page( $post=null ) {
        return '<link itemprop="mainEntityOfPage" href="'. get_permalink($post) .'"/>';
    }

    public static function view_publisher( $screen=false, $class='' ) {

        $classes = self::get_class( 'entry-publisher', $screen, $class );

        $html  = '';
        $html .= '<div class="'. $classes .'" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
            $html .= '<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
                $html .= '<img src="'. self::get_custom_logo_url() .'" alt="'. self::get_custom_logo_alt() .'"/>';
                $html .= '<meta itemprop="url" content="'. self::get_custom_logo_url() .'">';
                $html .= '<meta itemprop="width" content="'. self::get_custom_logo_width() .'">';
                $html .= '<meta itemprop="height" content="'. self::get_custom_logo_height() .'">';
            $html .= '</div>';
            $html .= '<span class="fn org" itemprop="name" content="'. get_bloginfo('name') .'">'. get_bloginfo('name') .'</span>';
        $html .= '</div>';

        return $html;
    }

    /** 
     * Retrieves the post excerpt.
     * 
     * @link https://developer.wordpress.org/reference/functions/get_the_excerpt/
     */
    public static function view_summary( $post=null, $screen=true, $length=150, $class='' ) {
        
        $classes = self::get_class( 'entry-summary', $screen, $class );

        $html  = '';
        $html .= '<div class="'. $classes .'" itemprop="description">';
            $html .= starter_get_the_excerpt($length,$post);
        $html .= '</div>';

        return $html;
    }

    private static function get_class ( $default='', $screen=true, $class='' ) {
        $html  = $default;
        $html .= $screen = ( $screen == false ) ? ' screen-reader-text ' : ' ';
        $html .= $class;
        return trim($html);
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
     * Return the post thumbnail default URL.
     */
    private static function get_default_thumbnail() {
        return STARTER_IMG .'/thumbnail.png';
    }

    /**
     * Return the post thumbnail URL.
     *
     * @link https://developer.wordpress.org/reference/functions/get_the_post_thumbnail_url/
     */
    private static function get_post_thumbnail_url($post) {
        
        $image_url = self::get_default_thumbnail();
        
        if ( has_post_thumbnail($post) ) {
            $image_url = get_the_post_thumbnail_url($post);
        } 

        // Remove parameter if using image cdn
        $image_url = self::remove_cdn_parameter($image_url);

        return $image_url;
    }

    /**
     * To display the featured image alt tag
     *
     * priority: alt > caption > post_title
     * 
     * @link https://coderwall.com/p/kllffa/wordpress-post-thumbnail-alt
     */
    private static function get_post_thumbnail_alt($post) {
        
        $title = get_the_title($post);
        $image_alt = $title;

        if ( has_post_thumbnail($post) ) {
            $image_id = get_post_thumbnail_id($post);
            $image_meta = self::get_attachment_meta( $image_id );
            if ( !empty($image_meta['alt']) ) {
                $image_alt = $image_meta['alt'];
            } elseif( !empty($image_meta['caption']) ) {
                $image_alt = $image_meta['caption'];
            }
        } 

        return $image_alt;
    }

    private static function get_post_thumbnail_size($post) {

        $sizes = array(
            'width'  => '0',
            'height' => '0',
        );
        $image_url = self::get_post_thumbnail_url($post);
        $file = $_SERVER['DOCUMENT_ROOT'] . str_replace(get_bloginfo('url'),'',$image_url);

        if ( file_exists($file) ) {
            list($width,$height) = getimagesize($file);
            $sizes['width'] = $width;
            $sizes['height'] = $height;
        }

        return $sizes;
    }

    private static function get_post_thumbnail_width($post) {
        return self::get_post_thumbnail_size($post)['width'];
    }

    private static function get_post_thumbnail_height($post) {
        return self::get_post_thumbnail_size($post)['height'];
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