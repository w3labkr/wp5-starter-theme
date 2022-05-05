<?php 
/**
 * the_content
 *
 * @link https://developer.wordpress.org/reference/functions/the_content/
 * @link https://gist.github.com/CoachBirgit/e2c79015dae3026d7b56
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Content {

    public function __construct(){

        // add_filter( 'the_content', array( $this, 'views' ) );

        /**
         * Custom HTML template for images you insert in posts
         * 
         * @link https://wordpress.stackexchange.com/questions/53735/add-data-attribute-to-all-images-inside-the-content
         * @link https://rudrastyh.com/wordpress/custom-html-for-post-images.html
         */
        // add_filter( 'image_send_to_editor', array( $this, 'rudr_custom_html_template' ), 10, 8 );
    }

    public function views( $content ) {

        $html  = '';
        $html .= '<div class="editor-content">';
            $html .= '<div class="container">';
                $html .= $content;
            $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
    
    public function rudr_custom_html_template($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
        /*
        $html - default HTML, you can use regular expressions to operate with it
        $id - attachment ID
        $caption - image Caption
        $title - image Title
        $align - image Alignment
        $url - link to media file or to the attachment page (depends on what you selected in media uploader)
        $size - image size (Thumbnail, Medium, Large etc)
        $alt - image Alt Text
        */
     
        /*
         * First of all lets operate with image sizes
         */
        list( $img_src, $width, $height ) = image_downsize($id, $size);
        $hwstring = image_hwstring($width, $height);
     
        /*
         * Second thing - get the image URL $image_thumb[0]
         */
        $image_thumb = wp_get_attachment_image_src( $id, $size );
     
        $out = '<div class="rudr-image">'; // I want to wrap image into this div element
        if($url){ // if user wants to print the link with image
            $out .= '<a href="' . $url . '" class="fancybox">';
        }
        $out .= '<img src="'. $image_thumb[0] .'" alt="'.$alt.'" '.$hwstring.'/>';
        if($url){
            $out .= '</a>';
        }
        $out .= '</div>';
        return $out; // the result HTML
    }

}