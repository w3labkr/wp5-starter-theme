<?php 
/**
 * Add Custom Parameters to Youtube Video oEmbeds
 * 
 * @link https://codex.wordpress.org/Embeds
 * @link https://developers.google.com/youtube/player_parameters
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Video {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        add_filter( 'embed_oembed_html', array( $this, 'embed_param' ), 10, 4 );
        add_filter( 'video_embed_html', array( $this, 'embed_param' ), 10, 4 ); // Jetpack
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'enablejsapi'    => false,         // (boolean|int) | 0 | 0,1
            'autoplay'       => false,         // (boolean|int) | 0 | 0,1
            'cc_load_policy' => false,         // (boolean|int) | 1 | 1
            'color'          => false,         // (boolean|string) | false | red,white | Diable modestbranding if enable color
            'controls'       => 2,             // (boolean|int) | 1 | 0,1,2
            'disablekb'      => false,         // (boolean|int) | 0 | 0,1 - disable keyboard
            'end'            => false,         // (boolean|int) | false | 80 | measured in seconds from the start of the video
            'fs'             => 1,             // (boolean|int) | 1 | 0,1 | full screen
            'hl'             => false,         // (boolean|string) | false | ISO 639-1
            'iv_load_policy' => 3,             // (boolean|int) | 1 | 1,3 - diable video special effect
            'loop'           => false,         // (boolean|int) | 0 | 0,1
            'modestbranding' => 1,             // (boolean|int) | 0 | 1 | Hides the YouTube logo in the controls
            'origin'         => false,         // (boolean|int) | false | 1 | Require option if enable enablejsapi
            'rel'            => 0,             // (boolean|int) | 1 | 0,1 | Stops the player from showing related videos.
            'showinfo'       => 0,             // (boolean|int) | 1 | 0,1 | Player controls and progress bar show/hide automatically when playing/pausing.
            'start'          => false,         // (boolean|int) | false | 60 | measured in seconds from the start of the video
            'wmode'          => 'transparent', // (boolean|string) | transparent | opaque,transparent
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function embed_param($html) {
        $opts = $this->options();

        /* Modify video parameters. */
        if( strpos($html,'youtube.com/embed/') !== false ) {

            $params = '';
            foreach( $opts as $key=>$value ) {
                if ( $value !== false ) {
                    $params .= '&#038;';
                    $params .= $key;
                    $params .=  '=';
                    $params .= $value;
                }
            }

            $pattern = [];
            $pattern['version'] = "/(\?version\=3)(?:.*?)(\'|\")/";
            $pattern['feature'] = "/(\?feature\=oembed)(?:.*?)(\'|\")/";
            $pattern['noparam'] = "/(youtube\.com\/embed\/)(.*?)(?:\?)/";

            if ( preg_match( $pattern['version'], $html, $match ) ) {
                $param = $match[1] . $params . $match[2];
                $regex = $pattern['version'];
            }
            elseif ( preg_match( $pattern['feature'], $html, $match ) ) {
                $param = $match[1] . $params . $match[2];
                $regex = $pattern['feature'];
            }
            elseif ( preg_match( $pattern['noparam'], $html, $match ) == false ) {
                // put your code
            }

            $html = preg_replace( $regex, $param, $html );

        }
        
        // Return oEmbed html
        return $html;
    }

}